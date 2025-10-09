<?php

namespace App\Domain\Service;

use App\Domain\DTO\TaskBlueprint;
use App\Domain\DTO\WorkPackageBlueprint;
use App\Domain\Model\Project;
use App\Domain\Model\ProjectStatus;
use App\Domain\Model\ProjectTemplate;
use App\Domain\Model\ProposalTemplate;
use App\Domain\Model\Task;
use App\Domain\Model\WorkPackage;
use App\Domain\Repository\ProjectRepository;
use App\Domain\Repository\ProjectTemplateRepository;
use App\Domain\Repository\ProposalTemplateRepository;
use DateInterval;
use DateTimeImmutable;
use RuntimeException;
use function array_map;

final class TemplateService
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly ProjectTemplateRepository $projectTemplateRepository,
        private readonly ProposalTemplateRepository $proposalTemplateRepository
    ) {
    }

    public function createProjectTemplate(
        string $templateId,
        string $name,
        string $description,
        string $sourceProjectId,
        string $createdBy
    ): ProjectTemplate {
        $project = $this->requireProject($sourceProjectId);

        $workPackages = array_map(
            static function (WorkPackage $workPackage): WorkPackageBlueprint {
                $tasks = array_map(
                    static fn (Task $task): TaskBlueprint => new TaskBlueprint(
                        $task->name(),
                        $task->description(),
                        $task->estimatedHours(),
                        $task->requiredSkills()
                    ),
                    $workPackage->tasks()
                );

                return new WorkPackageBlueprint(
                    $workPackage->code(),
                    $workPackage->name(),
                    $workPackage->objective(),
                    $tasks
                );
            },
            $project->workPackages()
        );

        $recommendedRoles = [];
        foreach ($project->teamAssignments() as $assignment) {
            $recommendedRoles[$assignment->role()] = $assignment->role();
        }

        $recommendedSkills = $project->requiredSkills();

        $template = new ProjectTemplate(
            $templateId,
            $name,
            $description,
            $workPackages,
            $recommendedRoles,
            $recommendedSkills,
            $project->id(),
            $createdBy
        );

        $this->projectTemplateRepository->save($template);

        return $template;
    }

    /**
     * @param array<string, string> $sections
     * @param array<string, string> $pricingBreakdown
     */
    public function createProposalTemplate(
        string $templateId,
        string $name,
        string $summary,
        string $sourceProjectId,
        array $sections,
        array $pricingBreakdown,
        string $createdBy
    ): ProposalTemplate {
        $this->requireProject($sourceProjectId);

        $template = new ProposalTemplate(
            $templateId,
            $name,
            $summary,
            $sections,
            $pricingBreakdown,
            $sourceProjectId,
            $createdBy
        );

        $this->proposalTemplateRepository->save($template);

        return $template;
    }

    public function instantiateProjectFromTemplate(
        string $projectId,
        ProjectTemplate $template,
        string $projectName,
        string $client,
        DateTimeImmutable $startDate,
        ?DateTimeImmutable $endDate = null
    ): Project {
        $project = new Project(
            $projectId,
            $projectName,
            $client,
            ProjectStatus::Draft,
            $startDate,
            $endDate
        );

        foreach ($template->workPackages() as $workPackageBlueprint) {
            $project->addWorkPackage($this->hydrateWorkPackage($workPackageBlueprint));
        }

        if ($endDate === null && $template->workPackages() !== []) {
            $project->updateSchedule($startDate, $startDate->add(new DateInterval('P14D')));
        }

        $this->projectRepository->save($project);

        return $project;
    }

    private function hydrateWorkPackage(WorkPackageBlueprint $blueprint): WorkPackage
    {
        $workPackage = new WorkPackage(
            $blueprint->code,
            $blueprint->name,
            $blueprint->objective
        );

        foreach ($blueprint->tasks as $taskBlueprint) {
            $workPackage->addTask(new Task(
                $taskBlueprint->name,
                $taskBlueprint->description,
                $taskBlueprint->estimatedHours,
                $taskBlueprint->requiredSkills
            ));
        }

        return $workPackage;
    }

    private function requireProject(string $projectId): Project
    {
        $project = $this->projectRepository->find($projectId);
        if (! $project instanceof Project) {
            throw new RuntimeException("Project {$projectId} was not found");
        }

        return $project;
    }
}

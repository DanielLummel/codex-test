<?php

namespace Tests\Domain;

use App\Domain\Model\Project;
use App\Domain\Model\ProjectStatus;
use App\Domain\Model\Task;
use App\Domain\Model\TeamAssignment;
use App\Domain\Model\WorkPackage;
use App\Domain\Service\TemplateService;
use App\Infrastructure\Repository\InMemory\InMemoryProjectRepository;
use App\Infrastructure\Repository\InMemory\InMemoryProjectTemplateRepository;
use App\Infrastructure\Repository\InMemory\InMemoryProposalTemplateRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class TemplateServiceTest extends TestCase
{
    private InMemoryProjectRepository $projectRepository;
    private InMemoryProjectTemplateRepository $projectTemplateRepository;
    private InMemoryProposalTemplateRepository $proposalTemplateRepository;
    private TemplateService $service;

    protected function setUp(): void
    {
        $this->projectRepository = new InMemoryProjectRepository();
        $this->projectTemplateRepository = new InMemoryProjectTemplateRepository();
        $this->proposalTemplateRepository = new InMemoryProposalTemplateRepository();
        $this->service = new TemplateService(
            $this->projectRepository,
            $this->projectTemplateRepository,
            $this->proposalTemplateRepository
        );
    }

    public function test_it_creates_project_template_from_existing_project(): void
    {
        $project = $this->createSampleProject();
        $this->projectRepository->save($project);

        $template = $this->service->createProjectTemplate(
            'tmpl-1',
            'Webshop Relaunch',
            'Vorlage basierend auf erfolgreichem Projekt',
            $project->id(),
            'pm@example.com'
        );

        self::assertCount(1, $template->workPackages());
        self::assertSame(['Lead Developer' => 'Lead Developer'], $template->recommendedRoles());
        self::assertSame('tmpl-1', $template->id());
    }

    public function test_it_creates_proposal_template(): void
    {
        $project = $this->createSampleProject();
        $this->projectRepository->save($project);

        $template = $this->service->createProposalTemplate(
            'proposal-1',
            'E-Commerce Angebot',
            'Standardangebot für mittelständische Kunden',
            $project->id(),
            ['Einleitung' => 'Überblick über das Projekt'],
            ['Implementierung' => '12000 EUR'],
            'pm@example.com'
        );

        self::assertSame('proposal-1', $template->id());
        self::assertArrayHasKey('Einleitung', $template->sections());
    }

    public function test_it_instantiates_project_from_template(): void
    {
        $project = $this->createSampleProject();
        $this->projectRepository->save($project);

        $template = $this->service->createProjectTemplate(
            'tmpl-2',
            'ERP Implementierung',
            'Standardablauf für ERP-Projekte',
            $project->id(),
            'pm@example.com'
        );

        $newProject = $this->service->instantiateProjectFromTemplate(
            'project-new',
            $template,
            'ERP Einführung Müller GmbH',
            'Müller GmbH',
            new DateTimeImmutable('2025-01-15')
        );

        self::assertSame('project-new', $newProject->id());
        self::assertCount(1, $newProject->workPackages());
        self::assertGreaterThan(0, $newProject->workload());
    }

    private function createSampleProject(): Project
    {
        $project = new Project(
            'project-1',
            'Webshop Launch',
            'ACME AG',
            ProjectStatus::Active,
            new DateTimeImmutable('2024-01-01'),
            new DateTimeImmutable('2024-03-01'),
            'Relaunch des bestehenden Webshops'
        );

        $package = new WorkPackage('WP1', 'Analyse', 'Ist-Analyse des bestehenden Systems');
        $package->addTask(new Task('Workshop', 'Stakeholder-Workshop', 8, ['Moderation', 'E-Commerce']));
        $package->addTask(new Task('Systemanalyse', 'Analyse der bestehenden Systeme', 16, ['PHP', 'Datenbanken']));

        $project->addWorkPackage($package);
        $project->assignTeamMember(new TeamAssignment($project->id(), 'member-1', 'Lead Developer', 80));

        return $project;
    }
}

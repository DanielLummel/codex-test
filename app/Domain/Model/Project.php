<?php

namespace App\Domain\Model;

use DateInterval;
use DateTimeImmutable;
use InvalidArgumentException;

final class Project
{
    /** @var WorkPackage[] */
    private array $workPackages = [];

    /** @var TeamAssignment[] */
    private array $teamAssignments = [];

    public function __construct(
        private readonly string $id,
        private string $name,
        private string $client,
        private ProjectStatus $status,
        private DateTimeImmutable $startDate,
        private ?DateTimeImmutable $endDate = null,
        private string $objective = ''
    ) {
        $this->rename($name);
        $this->client = trim($client);
        $this->objective = trim($objective);
        $this->ensureDateOrder();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function client(): string
    {
        return $this->client;
    }

    public function status(): ProjectStatus
    {
        return $this->status;
    }

    public function startDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function objective(): string
    {
        return $this->objective;
    }

    public function rename(string $name): void
    {
        $normalized = trim($name);
        if ($normalized === '') {
            throw new InvalidArgumentException('Project name cannot be empty.');
        }

        $this->name = $normalized;
    }

    public function updateSchedule(DateTimeImmutable $startDate, ?DateTimeImmutable $endDate): void
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->ensureDateOrder();
    }

    public function updateObjective(string $objective): void
    {
        $this->objective = trim($objective);
    }

    public function transitionTo(ProjectStatus $status): void
    {
        $this->status = $status;
    }

    public function extendByDays(int $days): void
    {
        if ($this->endDate === null) {
            $this->endDate = $this->startDate->add(new DateInterval('P' . $days . 'D'));

            return;
        }

        $this->endDate = $this->endDate->add(new DateInterval('P' . $days . 'D'));
    }

    public function addWorkPackage(WorkPackage $workPackage): void
    {
        $this->workPackages[$workPackage->code()] = $workPackage;
    }

    /**
     * @return WorkPackage[]
     */
    public function workPackages(): array
    {
        return array_values($this->workPackages);
    }

    public function assignTeamMember(TeamAssignment $assignment): void
    {
        $this->teamAssignments[$assignment->memberId()] = $assignment;
    }

    /**
     * @return TeamAssignment[]
     */
    public function teamAssignments(): array
    {
        return array_values($this->teamAssignments);
    }

    public function workload(): int
    {
        $total = 0;
        foreach ($this->workPackages as $workPackage) {
            foreach ($workPackage->tasks() as $task) {
                $total += $task->estimatedHours();
            }
        }

        return $total;
    }

    public function requiredSkills(): array
    {
        $skills = [];
        foreach ($this->workPackages as $workPackage) {
            foreach ($workPackage->tasks() as $task) {
                foreach ($task->requiredSkills() as $skill) {
                    $skills[strtolower($skill)] = $skill;
                }
            }
        }

        return array_values($skills);
    }

    private function ensureDateOrder(): void
    {
        if ($this->endDate !== null && $this->startDate > $this->endDate) {
            throw new InvalidArgumentException('Project end date must be after start date.');
        }
    }
}

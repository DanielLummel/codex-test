<?php

namespace Tests\Domain;

use App\Domain\Model\Project;
use App\Domain\Model\ProjectStatus;
use App\Domain\Model\Task;
use App\Domain\Model\WorkPackage;
use App\Domain\Service\DashboardService;
use App\Infrastructure\Repository\InMemory\InMemoryProjectRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class DashboardServiceTest extends TestCase
{
    public function test_it_builds_dashboard_snapshot_with_closing_and_overdue_projects(): void
    {
        $repository = new InMemoryProjectRepository();
        $referenceDate = new DateTimeImmutable('2024-04-01');

        $activeProject = new Project(
            'project-active',
            'Website Redesign',
            'ACME AG',
            ProjectStatus::Active,
            new DateTimeImmutable('2024-01-01'),
            new DateTimeImmutable('2024-04-10')
        );
        $activeProject->addWorkPackage($this->workPackageWithHours(40));
        $repository->save($activeProject);

        $overdueProject = new Project(
            'project-overdue',
            'CRM Rollout',
            'Globex',
            ProjectStatus::Active,
            new DateTimeImmutable('2023-10-01'),
            new DateTimeImmutable('2024-03-15')
        );
        $overdueProject->addWorkPackage($this->workPackageWithHours(60));
        $repository->save($overdueProject);

        $completedProject = new Project(
            'project-done',
            'Intranet Migration',
            'Innotech',
            ProjectStatus::Completed,
            new DateTimeImmutable('2023-01-01'),
            new DateTimeImmutable('2023-06-30')
        );
        $completedProject->addWorkPackage($this->workPackageWithHours(20));
        $repository->save($completedProject);

        $service = new DashboardService($repository);
        $snapshot = $service->buildSnapshot($referenceDate);

        self::assertSame(3, array_sum(array_column($snapshot->data['statusSummary'], 'count')));
        self::assertSame(120, $snapshot->data['totalWorkloadHours']);
        self::assertSame(1, count($snapshot->data['closingSoon']));
        self::assertSame('project-active', $snapshot->data['closingSoon'][0]['id']);
        self::assertSame('project-overdue', $snapshot->data['overdueProjects'][0]['id']);
    }

    private function workPackageWithHours(int $hours): WorkPackage
    {
        $package = new WorkPackage('WP-' . $hours, 'Arbeitspaket', 'Testpaket');
        $package->addTask(new Task('Task', 'Beschreibung', $hours));

        return $package;
    }
}

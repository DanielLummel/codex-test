<?php

namespace App\Domain\Service;

use App\Domain\DTO\DashboardSnapshot;
use App\Domain\Model\Project;
use App\Domain\Model\ProjectStatus;
use App\Domain\Repository\ProjectRepository;
use DateInterval;
use DateTimeImmutable;
use function array_values;

final class DashboardService
{
    public function __construct(private readonly ProjectRepository $projectRepository)
    {
    }

    public function buildSnapshot(DateTimeImmutable $referenceDate): DashboardSnapshot
    {
        $projects = $this->projectRepository->all();
        $statusCounts = $this->aggregateStatusCounts($projects);
        $totalWorkload = $this->totalWorkload($projects);
        $closingSoon = [];
        $overdue = [];

        foreach ($projects as $project) {
            $endDate = $project->endDate();
            if ($endDate === null) {
                continue;
            }

            if ($endDate < $referenceDate && ! $project->status()->isClosed()) {
                $overdue[] = [
                    'id' => $project->id(),
                    'name' => $project->name(),
                    'daysOverdue' => $endDate->diff($referenceDate)->days,
                ];
                continue;
            }

            $difference = $referenceDate->diff($endDate);
            if ($difference->invert === 0 && $difference->days <= 14 && $project->status() === ProjectStatus::Active) {
                $closingSoon[] = [
                    'id' => $project->id(),
                    'name' => $project->name(),
                    'daysRemaining' => $difference->days,
                ];
            }
        }

        usort($closingSoon, static fn (array $a, array $b): int => $a['daysRemaining'] <=> $b['daysRemaining']);
        usort($overdue, static fn (array $a, array $b): int => $b['daysOverdue'] <=> $a['daysOverdue']);

        return new DashboardSnapshot([
            'statusSummary' => $statusCounts,
            'totalWorkloadHours' => $totalWorkload,
            'activeProjects' => $statusCounts[array_search(ProjectStatus::Active, array_column($statusCounts, 'status'), true)]['count'] ?? 0,
            'closingSoon' => $closingSoon,
            'overdueProjects' => $overdue,
        ]);
    }

    /**
     * @param Project[] $projects
     */
    private function aggregateStatusCounts(array $projects): array
    {
        $statuses = [];
        foreach (ProjectStatus::cases() as $status) {
            $statuses[$status->value] = [
                'status' => $status,
                'count' => 0,
            ];
        }

        foreach ($projects as $project) {
            $statuses[$project->status()->value]['count']++;
        }

        return array_values($statuses);
    }

    /**
     * @param Project[] $projects
     */
    private function totalWorkload(array $projects): int
    {
        $total = 0;
        foreach ($projects as $project) {
            $total += $project->workload();
        }

        return $total;
    }
}

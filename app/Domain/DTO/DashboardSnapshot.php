<?php

namespace App\Domain\DTO;

use App\Domain\Model\ProjectStatus;

/**
 * @psalm-type StatusRow = array{status: ProjectStatus, count: int}
 * @psalm-type DashboardData = array{
 *     statusSummary: list<StatusRow>,
 *     totalWorkloadHours: int,
 *     activeProjects: int,
 *     closingSoon: list<array{id: string, name: string, daysRemaining: int}>,
 *     overdueProjects: list<array{id: string, name: string, daysOverdue: int}>
 * }
 */
final class DashboardSnapshot
{
    /** @param DashboardData $data */
    public function __construct(public readonly array $data)
    {
    }
}

<?php

namespace App\Domain\Model;

use InvalidArgumentException;

final class TeamAssignment
{
    public function __construct(
        private readonly string $projectId,
        private readonly string $memberId,
        private string $role,
        private int $allocationPercentage
    ) {
        $this->setRole($role);
        $this->setAllocation($allocationPercentage);
    }

    public function projectId(): string
    {
        return $this->projectId;
    }

    public function memberId(): string
    {
        return $this->memberId;
    }

    public function role(): string
    {
        return $this->role;
    }

    public function allocationPercentage(): int
    {
        return $this->allocationPercentage;
    }

    public function update(string $role, int $allocationPercentage): void
    {
        $this->setRole($role);
        $this->setAllocation($allocationPercentage);
    }

    private function setRole(string $role): void
    {
        $normalized = trim($role);
        if ($normalized === '') {
            throw new InvalidArgumentException('Assignment role cannot be empty.');
        }

        $this->role = $normalized;
    }

    private function setAllocation(int $allocation): void
    {
        if ($allocation < 0 || $allocation > 100) {
            throw new InvalidArgumentException('Allocation must be between 0 and 100 percent.');
        }

        $this->allocationPercentage = $allocation;
    }
}

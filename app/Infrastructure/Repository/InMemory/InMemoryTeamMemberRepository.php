<?php

namespace App\Infrastructure\Repository\InMemory;

use App\Domain\Model\TeamMember;
use App\Domain\Repository\TeamMemberRepository;

final class InMemoryTeamMemberRepository implements TeamMemberRepository
{
    /** @var array<string, TeamMember> */
    private array $members = [];

    public function save(TeamMember $member): void
    {
        $this->members[$member->id()] = $member;
    }

    public function find(string $memberId): ?TeamMember
    {
        return $this->members[$memberId] ?? null;
    }

    public function all(): array
    {
        return array_values($this->members);
    }
}

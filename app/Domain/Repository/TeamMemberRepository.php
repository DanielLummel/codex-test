<?php

namespace App\Domain\Repository;

use App\Domain\Model\TeamMember;

interface TeamMemberRepository
{
    public function save(TeamMember $member): void;

    public function find(string $memberId): ?TeamMember;

    /**
     * @return TeamMember[]
     */
    public function all(): array;
}

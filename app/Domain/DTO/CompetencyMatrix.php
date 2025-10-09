<?php

namespace App\Domain\DTO;

/**
 * @psalm-type SkillRow = array{skill: string, members: list<array{name: string, proficiency: int, available: bool, role: string}>}
 */
final class CompetencyMatrix
{
    /** @param SkillRow[] $rows */
    public function __construct(public readonly array $rows)
    {
    }
}

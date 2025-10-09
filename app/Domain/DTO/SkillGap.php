<?php

namespace App\Domain\DTO;

/**
 * @psalm-type SkillGapRow = array{skill: string, missing: bool, suggestedMembers: list<string>}
 */
final class SkillGap
{
    /** @param SkillGapRow[] $rows */
    public function __construct(public readonly array $rows)
    {
    }
}

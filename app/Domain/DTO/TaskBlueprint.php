<?php

namespace App\Domain\DTO;

final class TaskBlueprint
{
    /** @param string[] $requiredSkills */
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly int $estimatedHours,
        public readonly array $requiredSkills
    ) {
    }
}

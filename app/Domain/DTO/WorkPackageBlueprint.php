<?php

namespace App\Domain\DTO;

/** @psalm-type TaskBlueprintArray = array{name: string, description: string, estimatedHours: int, requiredSkills: list<string>} */
final class WorkPackageBlueprint
{
    /**
     * @param TaskBlueprint[] $tasks
     */
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly string $objective,
        public readonly array $tasks
    ) {
    }
}

<?php

namespace App\Domain\Model;

use InvalidArgumentException;

final class Task
{
    /** @param string[] $requiredSkills */
    public function __construct(
        private string $name,
        private string $description,
        private int $estimatedHours,
        private array $requiredSkills = []
    ) {
        $this->setName($name);
        $this->setEstimatedHours($estimatedHours);
        $this->setRequiredSkills($requiredSkills);
        $this->description = trim($description);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function estimatedHours(): int
    {
        return $this->estimatedHours;
    }

    /**
     * @return string[]
     */
    public function requiredSkills(): array
    {
        return $this->requiredSkills;
    }

    public function update(string $name, string $description, int $estimatedHours, array $requiredSkills): void
    {
        $this->setName($name);
        $this->description = trim($description);
        $this->setEstimatedHours($estimatedHours);
        $this->setRequiredSkills($requiredSkills);
    }

    private function setName(string $name): void
    {
        $normalized = trim($name);
        if ($normalized === '') {
            throw new InvalidArgumentException('Task name cannot be empty.');
        }

        $this->name = $normalized;
    }

    private function setEstimatedHours(int $estimatedHours): void
    {
        if ($estimatedHours < 0) {
            throw new InvalidArgumentException('Estimated hours must be positive.');
        }

        $this->estimatedHours = $estimatedHours;
    }

    /**
     * @param string[] $skills
     */
    private function setRequiredSkills(array $skills): void
    {
        $sanitized = [];
        foreach ($skills as $skill) {
            $skillName = trim((string) $skill);
            if ($skillName === '') {
                continue;
            }

            $sanitized[strtolower($skillName)] = $skillName;
        }

        $this->requiredSkills = array_values($sanitized);
    }
}

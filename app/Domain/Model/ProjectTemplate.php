<?php

namespace App\Domain\Model;

use App\Domain\DTO\WorkPackageBlueprint;

final class ProjectTemplate
{
    /**
     * @param WorkPackageBlueprint[] $workPackages
     * @param array<string, string> $recommendedRoles
     * @param string[] $recommendedSkills
     */
    public function __construct(
        private readonly string $id,
        private string $name,
        private string $description,
        private array $workPackages,
        private array $recommendedRoles,
        private array $recommendedSkills,
        private readonly string $sourceProjectId,
        private readonly string $createdBy
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return WorkPackageBlueprint[]
     */
    public function workPackages(): array
    {
        return $this->workPackages;
    }

    /**
     * @return array<string, string>
     */
    public function recommendedRoles(): array
    {
        return $this->recommendedRoles;
    }

    /**
     * @return string[]
     */
    public function recommendedSkills(): array
    {
        return $this->recommendedSkills;
    }

    public function sourceProjectId(): string
    {
        return $this->sourceProjectId;
    }

    public function createdBy(): string
    {
        return $this->createdBy;
    }

    public function rename(string $name): void
    {
        $this->name = $name;
    }

    public function updateDescription(string $description): void
    {
        $this->description = $description;
    }

    public function updateBlueprint(array $workPackages, array $recommendedRoles, array $recommendedSkills): void
    {
        $this->workPackages = $workPackages;
        $this->recommendedRoles = $recommendedRoles;
        $this->recommendedSkills = $recommendedSkills;
    }
}

<?php

namespace App\Infrastructure\Repository\InMemory;

use App\Domain\Model\Project;
use App\Domain\Repository\ProjectRepository;

final class InMemoryProjectRepository implements ProjectRepository
{
    /** @var array<string, Project> */
    private array $projects = [];

    public function save(Project $project): void
    {
        $this->projects[$project->id()] = $project;
    }

    public function find(string $projectId): ?Project
    {
        return $this->projects[$projectId] ?? null;
    }

    public function all(): array
    {
        return array_values($this->projects);
    }
}

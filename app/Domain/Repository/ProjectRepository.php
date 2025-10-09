<?php

namespace App\Domain\Repository;

use App\Domain\Model\Project;

interface ProjectRepository
{
    public function save(Project $project): void;

    public function find(string $projectId): ?Project;

    /**
     * @return Project[]
     */
    public function all(): array;
}

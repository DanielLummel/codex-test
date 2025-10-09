<?php

namespace App\Domain\Repository;

use App\Domain\Model\ProjectTemplate;

interface ProjectTemplateRepository
{
    public function save(ProjectTemplate $template): void;

    public function find(string $templateId): ?ProjectTemplate;

    /**
     * @return ProjectTemplate[]
     */
    public function all(): array;
}

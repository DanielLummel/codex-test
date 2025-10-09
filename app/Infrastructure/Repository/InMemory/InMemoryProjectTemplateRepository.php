<?php

namespace App\Infrastructure\Repository\InMemory;

use App\Domain\Model\ProjectTemplate;
use App\Domain\Repository\ProjectTemplateRepository;

final class InMemoryProjectTemplateRepository implements ProjectTemplateRepository
{
    /** @var array<string, ProjectTemplate> */
    private array $templates = [];

    public function save(ProjectTemplate $template): void
    {
        $this->templates[$template->id()] = $template;
    }

    public function find(string $templateId): ?ProjectTemplate
    {
        return $this->templates[$templateId] ?? null;
    }

    public function all(): array
    {
        return array_values($this->templates);
    }
}

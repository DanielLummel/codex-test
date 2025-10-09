<?php

namespace App\Infrastructure\Repository\InMemory;

use App\Domain\Model\ProposalTemplate;
use App\Domain\Repository\ProposalTemplateRepository;

final class InMemoryProposalTemplateRepository implements ProposalTemplateRepository
{
    /** @var array<string, ProposalTemplate> */
    private array $templates = [];

    public function save(ProposalTemplate $template): void
    {
        $this->templates[$template->id()] = $template;
    }

    public function find(string $templateId): ?ProposalTemplate
    {
        return $this->templates[$templateId] ?? null;
    }

    public function all(): array
    {
        return array_values($this->templates);
    }
}

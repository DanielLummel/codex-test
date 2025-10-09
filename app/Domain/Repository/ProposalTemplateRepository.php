<?php

namespace App\Domain\Repository;

use App\Domain\Model\ProposalTemplate;

interface ProposalTemplateRepository
{
    public function save(ProposalTemplate $template): void;

    public function find(string $templateId): ?ProposalTemplate;

    /**
     * @return ProposalTemplate[]
     */
    public function all(): array;
}

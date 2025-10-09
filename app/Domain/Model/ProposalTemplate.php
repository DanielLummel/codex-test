<?php

namespace App\Domain\Model;

final class ProposalTemplate
{
    /**
     * @param array<string, string> $sections
     * @param array<string, string> $pricingBreakdown
     */
    public function __construct(
        private readonly string $id,
        private string $name,
        private string $summary,
        private array $sections,
        private array $pricingBreakdown,
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

    public function summary(): string
    {
        return $this->summary;
    }

    /**
     * @return array<string, string>
     */
    public function sections(): array
    {
        return $this->sections;
    }

    /**
     * @return array<string, string>
     */
    public function pricingBreakdown(): array
    {
        return $this->pricingBreakdown;
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

    public function updateSummary(string $summary): void
    {
        $this->summary = $summary;
    }

    public function updateContent(array $sections, array $pricingBreakdown): void
    {
        $this->sections = $sections;
        $this->pricingBreakdown = $pricingBreakdown;
    }
}

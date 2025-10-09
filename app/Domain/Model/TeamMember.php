<?php

namespace App\Domain\Model;

final class TeamMember
{
    /** @var Skill[] */
    private array $skills = [];

    /** @var string[] */
    private array $projectRoles = [];

    public function __construct(
        private readonly string $id,
        private string $name,
        private string $role,
        private bool $available = true
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

    public function role(): string
    {
        return $this->role;
    }

    public function updateProfile(string $name, string $role): void
    {
        $this->name = $name;
        $this->role = $role;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function markAvailability(bool $available): void
    {
        $this->available = $available;
    }

    public function addSkill(Skill $skill): void
    {
        foreach ($this->skills as $existing) {
            if ($existing->equals($skill)) {
                return;
            }
        }

        $this->skills[] = $skill;
    }

    /**
     * @return Skill[]
     */
    public function skills(): array
    {
        return $this->skills;
    }

    public function assignRoleForProject(string $projectId, string $role): void
    {
        $this->projectRoles[$projectId] = $role;
    }

    public function projectRole(string $projectId): ?string
    {
        return $this->projectRoles[$projectId] ?? null;
    }
}

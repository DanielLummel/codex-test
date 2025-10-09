<?php

namespace App\Domain\Model;

use InvalidArgumentException;

final class Skill
{
    public function __construct(
        private readonly string $name,
        private readonly int $proficiency
    ) {
        $normalized = trim($name);

        if ($normalized === '') {
            throw new InvalidArgumentException('Skill name cannot be empty.');
        }

        if ($proficiency < 1 || $proficiency > 5) {
            throw new InvalidArgumentException('Skill proficiency must be between 1 and 5.');
        }

        $this->name = $normalized;
        $this->proficiency = $proficiency;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function proficiency(): int
    {
        return $this->proficiency;
    }

    public function equals(self $other): bool
    {
        return strcasecmp($this->name, $other->name) === 0
            && $this->proficiency === $other->proficiency;
    }
}

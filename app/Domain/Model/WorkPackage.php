<?php

namespace App\Domain\Model;

use InvalidArgumentException;

final class WorkPackage
{
    /** @var Task[] */
    private array $tasks = [];

    public function __construct(
        private string $code,
        private string $name,
        private string $objective
    ) {
        $this->setCode($code);
        $this->setName($name);
        $this->objective = trim($objective);
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function objective(): string
    {
        return $this->objective;
    }

    /**
     * @return Task[]
     */
    public function tasks(): array
    {
        return $this->tasks;
    }

    public function addTask(Task $task): void
    {
        $this->tasks[] = $task;
    }

    public function replaceTasks(array $tasks): void
    {
        foreach ($tasks as $task) {
            if (! $task instanceof Task) {
                throw new InvalidArgumentException('WorkPackage::replaceTasks expects Task instances.');
            }
        }

        $this->tasks = array_values($tasks);
    }

    private function setCode(string $code): void
    {
        $normalized = strtoupper(trim($code));
        if ($normalized === '') {
            throw new InvalidArgumentException('Work package code cannot be empty.');
        }

        $this->code = $normalized;
    }

    private function setName(string $name): void
    {
        $normalized = trim($name);
        if ($normalized === '') {
            throw new InvalidArgumentException('Work package name cannot be empty.');
        }

        $this->name = $normalized;
    }
}

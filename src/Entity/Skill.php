<?php

namespace App\Entity;

class Skill
{
    private string $name;

    private string $role;

    private int $chance;

    private string $label;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setChance(int $chance): void
    {
        $this->chance = $chance;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getChance(): int
    {
        return $this->chance;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}

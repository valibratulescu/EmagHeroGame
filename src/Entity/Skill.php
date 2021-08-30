<?php

namespace App\Entity;

class Skill
{
    /**
     * @var string
     */
    private $name = null;

    /**
     * @var string
     */
    private $role = null;

    /**
     * @var int
     */
    private $chance = null;

    /**
     * @var string
     */
    private $label = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $role
     *
     * @return void
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @param int $chance
     *
     * @return void
     */
    public function setChance(int $chance): void
    {
        $this->chance = $chance;
    }

    /**
     * @param string $label
     *
     * @return void
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getChance(): int
    {
        return $this->chance;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }
}

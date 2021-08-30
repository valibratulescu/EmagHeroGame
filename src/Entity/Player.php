<?php

namespace App\Entity;

use App\Entity\Constant\Player as ConstantPlayer;

class Player
{
    /**
     * @var string
     */
    private $name = null;

    /**
     * @var array
     */
    private $stats = [];

    /**
     * @var Skill[]
     */
    private $skills = [];

    /**
     * @var string
     */
    private $role = null;

    public function __construct(string $name, array $stats, ?array $skills = null)
    {
        $this->name   = $name;
        $this->stats  = $stats;
        $this->skills = $skills;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|null $role
     *
     * @return Skill[]
     */
    public function getSkills(string $role = null): array
    {
        if (empty($this->skills)) {
            return [];
        }

        return \is_string($role) ? $this->skills[$role] : $this->skills;
    }

    /**
     * @return array
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @return int
     */
    public function getHealth(): int
    {
        return $this->stats["health"];
    }

    /**
     * @return int
     */
    public function getStrength(): int
    {
        return $this->stats["strength"];
    }

    /**
     * @return int
     */
    public function getDefence(): int
    {
        return $this->stats["defence"];
    }

    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->stats["speed"];
    }

    /**
     * @return int
     */
    public function getLuck(): int
    {
        return $this->stats["luck"];
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param int $health
     *
     * @return void
     */
    public function setHealth(int $health): void
    {
        $this->stats["health"] = $health;
    }

    /**
     * @param int $strength
     *
     * @return void
     */
    public function setStrength(int $strength): void
    {
        $this->stats["strength"] = $strength;
    }

    /**
     * @param int $defence
     *
     * @return void
     */
    public function setDefence(int $defence): void
    {
        $this->stats["defence"] = $defence;
    }

    /**
     * @param int $speed
     *
     * @return void
     */
    public function setSpeed(int $speed): void
    {
        $this->stats["speed"] = $speed;
    }

    /**
     * @param int $luck
     *
     * @return void
     */
    public function setLuck(int $luck): void
    {
        $this->stats["luck"] = $luck;
    }

    /**
     * @return void
     */
    public function setRoleAttacker(): void
    {
        $this->role = ConstantPlayer::ROLE_ATTACKER;
    }

    /**
     * @return void
     */
    public function setRoleDefender(): void
    {
        $this->role = ConstantPlayer::ROLE_DEFENDER;
    }

    /**
     * @param array $skills
     *
     * @return void
     */
    public function setSkills(array $skills): void
    {
        $this->skills = $skills;
    }
}

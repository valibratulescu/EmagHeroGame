<?php

namespace App\Entity;

use App\Entity\Constant\Player as ConstantPlayer;

class Player
{
    private string $name;

    private array $stats = [];

    private string $role;

    /**
     * @var Skill[]
     */
    private array $skills = [];

    public function __construct(string $name, array $stats, ?array $skills = null)
    {
        $this->name   = $name;
        $this->stats  = $stats;
        $this->skills = $skills;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSkills(string $role = null): array
    {
        if (empty($this->skills)) {
            return [];
        }

        return \is_string($role) ? $this->skills[$role] : $this->skills;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function getHealth(): int
    {
        return $this->stats[ConstantPlayer::HEALTH];
    }

    public function getStrength(): int
    {
        return $this->stats[ConstantPlayer::STRENGTH];
    }

    public function getDefence(): int
    {
        return $this->stats[ConstantPlayer::DEFENCE];
    }

    public function getSpeed(): int
    {
        return $this->stats[ConstantPlayer::SPEED];
    }

    public function getLuck(): int
    {
        return $this->stats[ConstantPlayer::LUCK];
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setHealth(int $health): void
    {
        $this->stats[ConstantPlayer::HEALTH] = $health;
    }

    public function setStrength(int $strength): void
    {
        $this->stats[ConstantPlayer::STRENGTH] = $strength;
    }

    public function setDefence(int $defence): void
    {
        $this->stats[ConstantPlayer::DEFENCE] = $defence;
    }

    public function setSpeed(int $speed): void
    {
        $this->stats[ConstantPlayer::SPEED] = $speed;
    }

    public function setLuck(int $luck): void
    {
        $this->stats[ConstantPlayer::LUCK] = $luck;
    }

    public function setRoleAttacker(): void
    {
        $this->role = ConstantPlayer::ROLE_ATTACKER;
    }

    public function setRoleDefender(): void
    {
        $this->role = ConstantPlayer::ROLE_DEFENDER;
    }

    public function setSkills(array $skills): void
    {
        $this->skills = $skills;
    }
}

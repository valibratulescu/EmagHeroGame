<?php

namespace App\Entity;

use App\Entity\SkillInterface;
use App\Utils\MathUtils;

class Skill implements SkillInterface
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
     * @inheritdoc
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @inheritdoc
     */
    public function setChance(int $chance): void
    {
        $this->chance = $chance;
    }

    /**
     * @inheritdoc
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

    /**
     * @inheritdoc
     */
    public function activate(int $damage): int
    {
        return $damage;
    }

    /**
     * @return bool
     */
    public function canActivate(): bool
    {
        return MathUtils::checkWinChance($this->chance);
    }
}

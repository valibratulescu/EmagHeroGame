<?php

namespace App\Strategy;

readonly class SkillContext
{
    public function __construct(private SkillStrategy $skill) {}

    public function canCalculateDamage(): bool
    {
        return $this->skill->canActivate();
    }

    public function calculateDamage(int $damage): int
    {
        return $this->skill->activate($damage);
    }
}
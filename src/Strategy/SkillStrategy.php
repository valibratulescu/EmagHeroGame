<?php

namespace App\Strategy;

use App\Helper\MathHelper;

abstract class SkillStrategy
{
    private const int LUCK = 0;

    public function canActivate(): bool
    {
        return MathHelper::determineWinningChance(static::LUCK);
    }

    abstract public function activate(int $damage): int;
}
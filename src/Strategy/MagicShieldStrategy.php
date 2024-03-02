<?php

namespace App\Strategy;

use App\Entity\MagicShield;
use App\Helper\MathHelper;

class MagicShieldStrategy extends SkillStrategy
{
    public const int LUCK = MagicShield::LUCK;

    public function activate(int $damage): int
    {
        return MathHelper::round($damage / 2);
    }
}
<?php

namespace App\Strategy;

use App\Entity\RapidStrike;

class RapidStrikeStrategy extends SkillStrategy
{
    public const int LUCK = RapidStrike::LUCK;

    public function activate(int $damage): int
    {
        return $damage * 2;
    }
}
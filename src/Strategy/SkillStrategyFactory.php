<?php

namespace App\Strategy;

use App\Entity\MagicShield;
use App\Entity\RapidStrike;

class SkillStrategyFactory
{
    public static function createStrategy(string $type): SkillStrategy
    {
        $strategyClass = match ($type) {
            MagicShield::TYPE => MagicShieldStrategy::class,
            RapidStrike::TYPE => RapidStrikeStrategy::class,
            default => DefaultStrategy::class
        };

        return new $strategyClass();
    }
}
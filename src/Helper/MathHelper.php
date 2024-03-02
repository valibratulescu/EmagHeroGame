<?php

namespace App\Helper;

class MathHelper
{
    public static function generateNumberWithinInterval(int $min, int $max): int
    {
        return rand($min, $max);
    }

    public static function determineWinningChance(int $luck): bool
    {
        $chance = ($luck / (100 + $luck));

        return static::generateNumberWithinInterval(0, 9999) < ($chance * 10000);
    }

    public static function round(int $number, int $decimals = 2): int
    {
        return round($number, $decimals);
    }
}
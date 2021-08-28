<?php

namespace App\Utils;

class MathUtils
{
    /**
     * @param int $min
     * @param int $max
     *
     * @return int
     */
    public static function generateRandomNumber(int $min, int $max): int
    {
        return \rand($min, $max);
    }

    /**
     * @param int $luck
     *
     * @return bool
     */
    public static function checkWinChance(int $luck): bool
    {
        $chance = ($luck / (100 + $luck));

        return \rand(0, 9999) < ($chance * 10000);
    }

    /**
     * @param int|float $number
     *
     * @return int
     */
    public static function round($number): int
    {
        return \round($number);
    }
}

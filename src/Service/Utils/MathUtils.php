<?php

namespace App\Service\Utils;

class MathUtils
{
    /**
     * @param int $min
     * @param int $max
     *
     * @return int
     */
    public function generateRandomNumber(int $min, int $max): int
    {
        return \rand($min, $max);
    }

    /**
     * @param int $luck
     *
     * @return bool
     */
    public function checkWinChance(int $luck): bool
    {
        $chance = ($luck / (100 + $luck));

        return \rand(0, 9999) < ($chance * 10000);
    }

    /**
     * @param int|float $number
     *
     * @return int
     */
    public function round($number): int
    {
        return \round($number);
    }
}

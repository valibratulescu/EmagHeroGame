<?php

namespace App\Service\Utils;

class MathUtils
{
    public function generateRandomNumber(int $min, int $max): int
    {
        return \rand($min, $max);
    }

    public function checkWinChance(int $luck): bool
    {
        $chance = ($luck / (100 + $luck));

        return \rand(0, 9999) < ($chance * 10000);
    }
}

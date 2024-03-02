<?php

namespace App\Strategy;

class DefaultStrategy extends SkillStrategy
{
    public function activate(int $damage): int {
        return $damage;
    }
}
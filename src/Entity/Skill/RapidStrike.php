<?php

namespace App\Entity\Skill;

use App\Entity\SkillInterface;

class RapidStrike implements SkillInterface
{
    public function activate(int $damage): int
    {
        return $damage * 2;
    }
}

<?php

namespace App\Entity\Skill;

use App\Entity\SkillInterface;

class RapidStrike implements SkillInterface
{
    /**
     * @inheritdoc
     */
    public function activate(int $damage): int
    {
        return $damage * 2;
    }
}

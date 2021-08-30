<?php

namespace App\Entity\Skill;

use App\Entity\SkillInterface;

class MagicShield implements SkillInterface
{
    /**
     * @inheritdoc
     */
    public function activate(int $damage): int
    {
        return \round($damage / 2);
    }
}

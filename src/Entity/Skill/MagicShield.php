<?php

namespace App\Entity\Skill;

use App\Entity\Skill;
use App\Utils\MathUtils;

class MagicShield extends Skill
{
    /**
     * @inheritdoc
     */
    public function activate(int $damage): int
    {
        return MathUtils::round($damage / 2);
    }
}

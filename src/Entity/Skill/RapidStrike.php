<?php

namespace App\Entity\Skill;

use App\Entity\Skill;

class RapidStrike extends Skill
{
    /**
     * @inheritdoc
     */
    public function activate(int $damage): int
    {
        return $damage * 2;
    }
}

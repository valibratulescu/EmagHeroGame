<?php

namespace Emagia\Hero\Skills;

use Emagia\Hero\Handlers\Skill;

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

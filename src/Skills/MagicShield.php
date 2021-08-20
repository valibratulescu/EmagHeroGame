<?php

namespace Emagia\Hero\Skills;

use Emagia\Hero\Handlers\Skill;
use Emagia\Hero\Utils\MathUtils;

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

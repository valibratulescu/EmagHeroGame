<?php

namespace Emagia\Hero\Interfaces;

interface SkillInterface
{
    /**
     * @param int $damage
     *
     * @return int
     */
    public function activate(int $damage): int;
}

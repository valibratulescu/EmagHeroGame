<?php

namespace App\Entity;

interface SkillInterface
{
    /**
     * @param int $damage
     *
     * @return int
     */
    public function activate(int $damage): int;
}

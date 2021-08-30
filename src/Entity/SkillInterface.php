<?php

namespace App\Entity;

interface SkillInterface
{
    public function activate(int $damage): int;
}

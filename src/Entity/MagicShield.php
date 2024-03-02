<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class MagicShield extends Skill
{
    public const string NAME = "Magic Shield";
    public const string TYPE = "magic_shield";
    public const int LUCK = 20;
}
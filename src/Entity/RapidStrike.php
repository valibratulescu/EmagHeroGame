<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class RapidStrike extends Skill
{
    public const string NAME = "Rapid Strike";
    public const string TYPE = "rapid_strike";
    public const int LUCK = 10;
}
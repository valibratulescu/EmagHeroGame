<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Hero extends Player
{
    public const string NAME = "Orderus";
    public const string TYPE = "hero";

    public const int HEALTH_MIN = 70;
    public const int HEALTH_MAX = 100;

    public const int STRENGTH_MIN = 70;
    public const int STRENGTH_MAX = 80;

    public const int DEFENCE_MIN = 45;
    public const int DEFENCE_MAX = 55;

    public const int SPEED_MIN = 40;
    public const int SPEED_MAX = 50;

    public const int LUCK_MIN = 10;
    public const int LUCK_MAX = 30;
}
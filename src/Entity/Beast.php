<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Beast extends Player
{
    public const string TYPE = "beast";

    public const int HEALTH_MIN = 60;
    public const int HEALTH_MAX = 90;

    public const int STRENGTH_MIN = 60;
    public const int STRENGTH_MAX = 90;

    public const int DEFENCE_MIN = 40;
    public const int DEFENCE_MAX = 60;

    public const int SPEED_MIN = 40;
    public const int SPEED_MAX = 60;

    public const int LUCK_MIN = 25;
    public const int LUCK_MAX = 40;
}
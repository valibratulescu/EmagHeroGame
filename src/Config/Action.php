<?php

namespace App\Config;

enum Action: string
{
    case ATTACK = "ATTACK";
    case DEFEND = "DEFEND";
    case HOLD = "HOLD";
}

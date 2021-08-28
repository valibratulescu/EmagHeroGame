<?php

namespace App\Command;

class BeastCommand extends PlayerCommand
{
    protected static $defaultName = "app:beast-player";

    protected $playerType = "beast";
}

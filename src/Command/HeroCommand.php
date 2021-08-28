<?php

namespace App\Command;

class HeroCommand extends PlayerCommand
{
    protected static $defaultName = "app:hero-player";

    protected $playerType = "hero";
}

<?php

namespace App\Command;

class HeroCommand extends PlayerCommand
{
    protected static $defaultName = "app:hero-player";

    protected string $playerType = "hero";
}

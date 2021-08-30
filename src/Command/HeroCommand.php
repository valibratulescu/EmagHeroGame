<?php

namespace App\Command;

class HeroCommand extends PlayerCommand
{
    /**
     * @var string
     */
    protected static $defaultName = "app:hero-player";

    /**
     * @var string
     */
    protected $playerType = "hero";
}

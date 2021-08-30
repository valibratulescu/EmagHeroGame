<?php

namespace App\Command;

class BeastCommand extends PlayerCommand
{
    /**
     * @var string
     */
    protected static $defaultName = "app:beast-player";

    /**
     * @var string
     */
    protected $playerType = "beast";
}

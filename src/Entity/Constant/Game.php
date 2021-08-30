<?php

namespace App\Entity\Constant;

class Game
{
    /**
     * Max number of attacks that can occur between the players.
     *
     * @var int
     */
    const MAX_TURNS = 20;

    /**
     * Delay in seconds between the fights.
     *
     * @var int
     */
    const DELAY_BETWEEN_ATTACKS = 1.5;

    /**
     * @var string
     */
    const NO_WINNER = "NO WINNER";
}

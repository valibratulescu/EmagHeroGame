<?php

namespace App\Entity;

class Game
{
    /**
     * The winner name
     *
     * @var string
     */
    private $winner = null;

    /**
     * True if no one won due to the max number of turns reached
     *
     * @var bool
     */
    private $draw = false;

    /**
     * @return void
     */
    public function setDraw(): void
    {
        $this->draw = true;
    }

    /**
     * @param string $winner
     *
     * @return void
     */
    public function setWinner(string $winner): void
    {
        $this->winner = $winner;
    }

    /**
     * @return bool
     */
    public function getWinner(): string
    {
        return $this->winner;
    }

    /**
     * @return bool
     */
    public function isDrawGame(): bool
    {
        return $this->draw;
    }
}

<?php

namespace App\Entity;

class Game
{
    private string $winnerName;

    private bool $draw = false;

    public function setDraw(): void
    {
        $this->draw = true;
    }

    public function setWinner(string $winner): void
    {
        $this->winnerName = $winner;
    }

    public function getWinner(): string
    {
        return $this->winnerName;
    }

    public function isDrawGame(): bool
    {
        return $this->draw;
    }
}

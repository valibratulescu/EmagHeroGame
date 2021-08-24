<?php

namespace Tests\Emagia\Hero\Game;

use Emagia\Hero\Managers\GameManager;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @var GameManager
     */
    protected $game;

    protected function setUp()
    {
        $this->game = new GameManager();
    }

    public function testPlayers()
    {
        $this->game->initPlayers();

        self::assertCount(2, $this->game->getPlayers(), "There are not enough players ready to join the game");

        foreach ($this->game->getPlayers() as $player) {
            self::assertTrue($player->getStatValue("health") > 0, "Player {$player->getName()} is still in game");
        }
    }
}

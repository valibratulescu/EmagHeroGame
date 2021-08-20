<?php

namespace Emagia\Hero\Managers;

use Emagia\Hero\Factory\PlayerFactory;
use Emagia\Hero\Handlers\Player;
use Emagia\Hero\Managers\CLIManager;
use Emagia\Hero\Metadata\PlayerMetadata;
use Exception;

class GameManager
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
    const DELAY_BETWEEN_ATTACKS = 3;

    /**
     * List of players
     *
     * @var Player[]
     */
    private $players = [];

    /**
     * @var CLIManager
     */
    private $cliManager = [];

    /**
     * Stores the number of turns between the players
     *
     * @var int
     */
    private $countTurns = 0;

    public function __construct()
    {
        $this->cliManager = CLIManager::getInstance();
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function play(): void
    {
        try {
            $this->initPlayers();
            $this->sortPlayers();
            $this->presentPlayers();
            $this->prepareToJoin();

            while (true) {
                if ($this->countTurns === self::MAX_TURNS) {
                    $this->log("Unfortunately, our hero could not defeat the beast.");

                    break;
                }

                $gameOver = $this->fight();

                if ($gameOver === true) {
                    break;
                }

                $this->changePlayersTurn();

                $this->countTurns++;
            }
        } catch (\Throwable $th) {
            $this->log($th->getMessage());
        }

        $this->cliManager->destroy();
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    private function initPlayers(): void
    {
        $this->log("Initializing players...");

        foreach (PlayerMetadata::PLAYERS as $meta) {
            $this->players[] = PlayerFactory::createPlayer($meta);
        }

        if (count($this->players) === 0) {
            throw new \Exception("There are no players ready to join the game.\r\n");
        }

        $this->log("Done initializing players.");
    }

    /**
     * Sets the players order based on the speed or luck.
     * This will decide who will strike first.
     *
     * @return void
     */
    private function sortPlayers(): void
    {
        usort($this->players, function ($player1, $player2) {
            $stats1 = $player1->getStats(false);
            $stats2 = $player2->getStats(false);

            if ($stats1["speed"] < $stats2["speed"]) {
                return true;
            }

            return $stats1["luck"] < $stats2["luck"];
        });
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    private function presentPlayers(): void
    {
        $this->log("\r\nPresenting players...");

        foreach ($this->players as $player) {
            $this->log("\r\n======{$player->getName()}======\r\n");

            foreach ($player->getStats(false) as $attribute => $value) {
                $this->log("{$attribute} => {$value}");
            }
        }

        $this->log("\r\nDone presenting players.");
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    private function prepareToJoin(): void
    {
        $this->log("Players are warming up...");
        $this->delay();
    }

    /**
     * Begins the fight between players.
     * After the attack the players switch roles.
     * The attacker defends and the defender attacks.
     *
     * @return bool
     *
     * @throws Exception
     */
    private function fight(): bool
    {
        $this->logHeader();

        /** @var Player $attacker */
        $attacker = reset($this->players);

        /** @var Player $defender */
        $defender = end($this->players);

        /** Set the proper roles */
        $attacker->setRoleAttacker();
        $defender->setRoleDefender();

        $attackerName = $attacker->getName();
        $defenderName = $defender->getName();

        $this->log("{$attackerName} is ready to strike!");
        $this->delay();

        $outcome = $attacker->attack($defender);

        if ($outcome["success"] === true) {
            $this->log("{$attackerName} hits the target and deals {$outcome["damageDone"]} damage");

            /** If the defender has been defeated */
            if (\array_key_exists("defeat", $outcome) && $outcome["defeat"] === true) {
                $this->log("{$attackerName} won. {$defenderName} has been defeated!");

                return true;
            }

            /** If the defender still has HP left */
            $this->log("{$defenderName} has {$outcome["remainingHealth"]} HP left");

            return false;
        }

        /** If the attacker misses his target */
        $this->log("{$attackerName} misses the target. {$defenderName} got lucky this time");

        return false;
    }

    /**
     * @return void
     */
    private function changePlayersTurn(): void
    {
        $this->players = \array_reverse($this->players);
    }

    /**
     * @return void
     */
    private function delay(): void
    {
        \sleep(self::DELAY_BETWEEN_ATTACKS);
    }

    /**
     * @param string $message
     *
     * @return void
     *
     * @throws Exception
     */
    private function log(string $message): void
    {
        $this->cliManager->write($message);
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    private function logHeader(): void
    {
        $this->cliManager->writeHeader();
    }
}

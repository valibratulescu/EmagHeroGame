<?php

namespace App\Service;

use App\Entity\Constant\Game;
use App\Entity\Constant\Player;
use App\Entity\Game as EntityGame;
use App\Entity\Player as EntityPlayer;
use Symfony\Component\Console\Output\OutputInterface;

class GameManager
{
    /**
     * List of players
     *
     * @var EntityPlayer[]
     */
    private $players = [];

    /**
     * @var OutputInterface
     */
    private $output = [];

    /**
     * Stores the number of turns between the players
     *
     * @var int
     */
    private $countTurns = 0;

    /**
     * @var array
     */
    private $playersMeta = null;

    /**
     * @var PlayerManager
     */
    private $playerManager = null;

    /**
     * @var EntityGame
     */
    private $game = null;

    public function __construct(PlayerManager $playerManager)
    {
        $this->playerManager = $playerManager;
    }

    /**
     * @param OutputInterface $output
     *
     * @return void
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param EntityGame $game
     *
     * @return void
     */
    public function setEntityGame(EntityGame $game)
    {
        $this->game = $game;
    }

    /**
     * @param string $heroName
     * @param string $beastName
     *
     * @return void
     */
    public function initPlayersMeta(string $heroName, string $beastName): void
    {
        $this->playersMeta = [
            array_merge(["name" => $heroName], Player::HERO),
            array_merge(["name" => $beastName], Player::BEAST),
        ];
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
                if ($this->countTurns === Game::MAX_TURNS) {
                    $this->game->setDraw();
                    $this->game->setWinner(Game::NO_WINNER);
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
            $this->log("Game crashed");
            $this->log("===> {$th->getMessage()} <===");
        }
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function initPlayers(): void
    {
        $this->log("Initializing players...");

        foreach ($this->playersMeta as $meta) {
            $this->players[] = $this->playerManager->createPlayer($meta);
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
            if ($player1->getSpeed() < $player2->getSpeed()) {
                return true;
            }

            return $player1->getLuck() < $player2->getLuck();
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

            foreach ($player->getStats() as $attribute => $value) {
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
        $this->log("==========");

        /** @var EntityPlayer $attacker */
        $attacker = reset($this->players);

        /** @var EntityPlayer $defender */
        $defender = end($this->players);

        /** Set the proper roles */
        $attacker->setRoleAttacker();
        $defender->setRoleDefender();

        $attackerName = $attacker->getName();
        $defenderName = $defender->getName();

        $this->log("{$attackerName} is ready to strike!");
        $this->delay();
        $this->log("{$attacker->getName()} strength is {$attacker->getStrength()}");
        $this->log("{$defender->getName()} defence is {$defender->getDefence()}");

        $outcome = $this->playerManager->attack($attacker, $defender);

        if ($outcome["success"] === true) {
            $this->log("{$attackerName} hits the target and deals {$outcome["damageDone"]} damage");

            /** If the defender has been defeated */
            if (\array_key_exists("defeat", $outcome) && $outcome["defeat"] === true) {
                $this->game->setWinner($attackerName);
                $this->log("{$attackerName} won. {$defenderName} has been defeated!");

                return true;
            }

            /** If the defender still has HP left */
            $this->log("{$defenderName} has {$outcome["remainingHealth"]} HP left");

            return false;
        }

        /** If the attacker misses his target */
        $this->log("{$attackerName} misses the target. {$defenderName} got lucky this time");
        $this->log("{$defenderName} has {$outcome["remainingHealth"]} HP left");

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
        \sleep(Game::DELAY_BETWEEN_ATTACKS);
    }

    /**
     * @param array|string $message
     *
     * @return void
     *
     * @throws Exception
     */
    private function log($message): void
    {
        $this->output->writeln($message);
    }
}

<?php

namespace App\Service;

use App\Entity\Constant\Player;
use App\Entity\Player as EntityPlayer;
use App\Factory\PlayerFactory;
use Symfony\Component\Console\Output\OutputInterface;

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
    const DELAY_BETWEEN_ATTACKS = 1.5;

    /**
     * @var string
     */
    const NO_WINNER = "NO WINNER";

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
     * @var array
     */
    private $playersMeta = null;

    /**
     * @param OutputInterface $output
     *
     * @return void
     */
    public function initCommandLine(OutputInterface $output)
    {
        $this->output = $output;
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
                if ($this->countTurns === self::MAX_TURNS) {
                    $this->setDraw();
                    $this->setWinner(self::NO_WINNER);
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
            $this->players[] = PlayerFactory::createPlayer($meta);
        }

        if (count($this->players) === 0) {
            throw new \Exception("There are no players ready to join the game.\r\n");
        }

        $this->log("Done initializing players.");
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return void
     */
    public function setDraw(): void
    {
        $this->draw = true;
    }

    /**
     * @return bool
     */
    public function isDrawGame(): bool
    {
        return $this->draw;
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
        $this->log("{$attacker->getName()} strength is {$attacker->getStatValue("strength")}");
        $this->log("{$defender->getName()} defence is {$defender->getStatValue("strength")}");

        $outcome = $attacker->attack($defender);

        if ($outcome["success"] === true) {
            $this->log("{$attackerName} hits the target and deals {$outcome["damageDone"]} damage");

            /** If the defender has been defeated */
            if (\array_key_exists("defeat", $outcome) && $outcome["defeat"] === true) {
                $this->setWinner($attackerName);
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
        \sleep(self::DELAY_BETWEEN_ATTACKS);
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

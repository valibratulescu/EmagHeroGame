<?php

namespace App\Service;

use App\Entity\Player;
use App\Service\Utils\MathUtils;
use Exception;

class PlayerManager
{
    /**
     * @var SkillManager
     */
    private $skillManager = null;

    /**
     * @var MathUtils
     */
    private $mathUtils = null;

    public function __construct(SkillManager $skillManager, MathUtils $mathUtils)
    {
        $this->skillManager = $skillManager;
        $this->mathUtils    = $mathUtils;
    }

    /**
     * @param array $info
     *
     * @return Player
     *
     * @throws Exception
     */
    public function createPlayer(array $info): Player
    {
        $name = $info["name"];

        $stats  = array_key_exists("stats", $info) ? $this->createStats($info["stats"]) : [];
        $skills = array_key_exists("skills", $info) ? $this->skillManager->createSkills($info["skills"]) : [];

        return new Player($name, $stats, $skills);
    }

    /**
     * Initializes player stats based on their min-max range.
     *
     * @param array $stats
     *
     * @return array
     */
    public function createStats(array $stats): array
    {
        $data = [];

        foreach ($stats as $property => $item) {
            $data[$property] = $this->mathUtils->generateRandomNumber($item["min"], $item["max"]);
        }

        return $data;
    }

    /**
     *
     * @param Player $attacker
     * @param Player $defender
     *
     * @return array
     *
     * @throws Exception
     */
    public function attack(Player $attacker, Player $defender): array
    {
        $health = $defender->getHealth();

        /** Check if the defender can dodge the hit comming from the attacker */
        if ($this->isLucky($defender)) {
            return [
                "success"         => false,
                "targetMissed"    => true,
                "remainingHealth" => $health,
            ];
        }

        /** Calculates the damage dealt by the attacker */
        $damage = $this->calculateDamage($attacker, $defender);

        /** Ensure the damage dealt cannot exceed the remaining defender health */
        if ($damage > $health) {
            $damage = $health;
        }

        $health -= $damage;

        if ($health === 0) {
            return [
                "success"    => true,
                "defeat"     => true,
                "damageDone" => $damage,
            ];
        }

        $defender->setHealth($health);

        return [
            "success"         => true,
            "damageDone"      => $damage,
            "remainingHealth" => $health,
            "triggeredSkills" => [],
        ];
    }

    /**
     * Checks if the current player gets lucky and manages to bounce the hit comming from the attacker.
     *
     * @param Player $player
     *
     * @return bool
     */
    public function isLucky(Player $player): bool
    {
        $luck = \intval($player->getLuck());

        return $this->mathUtils->checkWinChance($luck);
    }

    /**
     * @param Player $attacker
     * @param Player $defender
     *
     * @return int
     *
     * @throws Exception
     */
    public function calculateDamage(Player $attacker, Player $defender): int
    {
        $strength = $attacker->getStrength();
        $defence  = $defender->getDefence();

        $damage = $strength - $defence;

        $damage = $this->activateSkills($attacker, $damage);
        $damage = $this->activateSkills($defender, $damage);

        return $damage;
    }

    /**
     * @param Player $player
     * @param int $damage
     *
     * @return int
     *
     * @throws Exception
     */
    public function activateSkills(Player $player, int $damage): int
    {
        foreach ($player->getSkills($player->getRole()) as $skill) {
            if ($this->skillManager->canActivate($skill) === true) {
                $damage = $this->skillManager->activate($skill, $damage);

                echo "Skill {$skill->getLabel()} activated for {$player->getName()}\r\n";
            }
        }

        return $damage;
    }
}

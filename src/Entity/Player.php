<?php

namespace App\Entity;

use App\Factory\SkillFactory;
use App\Utils\MathUtils;
use Exception;

class Player
{
    /**
     * @var string
     */
    const ROLE_ATTACKER = "attack";

    /**
     * @var string
     */
    const ROLE_DEFENDER = "defence";

    /**
     * @var string
     */
    private $name = null;

    /**
     * @var array
     */
    private $stats = [];

    /**
     * @var Skill[]
     */
    private $skills = [];

    /**
     * @var string
     */
    private $role = null;

    /**
     * @var CLIManager
     */
    private $cliManager = [];

    public function __construct(string $name, array $stats, ?array $skills = null)
    {
        $this->name   = $name;
        $this->stats  = $stats;
        $this->skills = $skills;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param bool $asJSON
     *
     * @return string|array|null
     */
    public function getStats(bool $asJSON = true)
    {
        if ($asJSON === true) {
            $res = @json_encode($this->stats, JSON_PRETTY_PRINT);

            if ($res === false) {
                return null;
            }

            return $res;
        }

        return $this->stats;
    }

    /**
     * @param string|null $role
     *
     * @return Skill[]
     */
    public function getSkills(string $role = null): array
    {
        if (empty($this->skills)) {
            return [];
        }

        return \is_string($role) ? $this->skills[$role] : $this->skills;
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    public function getStatValue(string $property)
    {
        return $this->stats[$property];
    }

    /**
     * @param string $property
     * @param mixed $value
     *
     * @return mixed
     */
    public function setStatValue(string $property, $value)
    {
        return $this->stats[$property] = $value;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return void
     */
    public function setRoleAttacker(): void
    {
        $this->role = self::ROLE_ATTACKER;
    }

    /**
     * @return void
     */
    public function setRoleDefender(): void
    {
        $this->role = self::ROLE_DEFENDER;
    }

    /**
     * @param array $skills
     *
     * @return void
     *
     * @throws Exception
     */
    public function addSkills(array $skills, string $role): void
    {
        $this->skills[$role] = $this->skills[$role] ?? [];

        foreach ($skills as $skillName) {
            $this->skills[$role][] = SkillFactory::createSkill($skillName);
        }
    }

    /**
     * @param array $skills
     *
     * @return void
     */
    public function setSkills(array $skills): void
    {
        $this->skills = $skills;
    }

    /**
     * @param Player $defender
     *
     * @return array
     */
    public function attack(Player $defender): array
    {
        $health = $defender->getStatValue("health");

        /** Check if the defender can dodge the hit comming from the attacker */
        if ($defender->isLucky()) {
            return [
                "success"         => false,
                "targetMissed"    => true,
                "remainingHealth" => $health,
            ];
        }

        /** Calculates the damage dealt by the attacker */
        $damage = $this->calculateDamage($defender);

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

        $defender->setStatValue("health", $health);

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
     * @return bool
     */
    private function isLucky(): bool
    {
        $luck = \intval($this->getStatValue("luck"));

        return MathUtils::checkWinChance($luck);
    }

    /**
     * @param Player $defender
     *
     * @return int
     *
     * @throws Exception
     */
    private function calculateDamage(Player $defender): int
    {
        $strength = $this->getStatValue("strength");
        $defence  = $this->getStatValue("defence");

        $damage = $strength - $defence;

        $damage = $this->activateSkills($damage);
        $damage = $defender->activateSkills($damage);

        return $damage;
    }

    /**
     * @param int $damage
     *
     * @return int
     *
     * @throws Exception
     */
    private function activateSkills(int $damage): int
    {
        foreach ($this->getSkills($this->getRole()) as $skill) {
            if ($skill->canActivate() === true) {
                $damage = $skill->activate($damage);

                $this->log("Skill {$skill->getLabel()} activated for {$this->getName()}");
            }
        }

        return $damage;
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
        echo "{$message}\r\n";
    }
}

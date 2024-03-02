<?php

namespace App\Service;

use App\Config\Action;
use App\Entity\Hero;
use App\Entity\Beast;
use App\Entity\MagicShield;
use App\Entity\Player;
use App\Entity\RapidStrike;
use App\Entity\Skill;
use App\Exception\BeastMissingException;
use App\Exception\HeroMissingException;
use App\Helper\MathHelper;
use App\Strategy\SkillContext;
use App\Strategy\SkillStrategyFactory;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Lock\LockFactory;

class GameService
{
    private const int MAX_TURNS = 20;
    private const int TIME_BETWEEN_STRIKES = 2;
    private const string LOCK_KEY = "hero-game-fight";

    private ?Hero $hero = null;
    private ?Beast $beast = null;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $em,
        private readonly LockFactory $lock
    ) {
    }

    public function summonHero(): void
    {
        $this->hero = (new Hero())
            ->setName(Hero::NAME)
            ->setType(Hero::TYPE)
            ->setHealth(MathHelper::generateNumberWithinInterval(Hero::HEALTH_MIN, Hero::HEALTH_MAX))
            ->setStrength(MathHelper::generateNumberWithinInterval(Hero::STRENGTH_MIN, Hero::STRENGTH_MAX))
            ->setDefence(MathHelper::generateNumberWithinInterval(Hero::DEFENCE_MIN, Hero::DEFENCE_MAX))
            ->setSpeed(MathHelper::generateNumberWithinInterval(Hero::SPEED_MIN, Hero::SPEED_MAX))
            ->setLuck(MathHelper::generateNumberWithinInterval(Hero::LUCK_MIN, Hero::LUCK_MAX));

        $this->initSkills();

        $this->logger->info("{$this->hero->getName()} has been summoned. He's ready to protect Emagia with his skills");
        $this->logger->info((string)$this->hero);
    }

    public function summonBeast(string $name): void
    {
        $this->beast = (new Beast())
            ->setName($name)
            ->setType(Beast::TYPE)
            ->setHealth(MathHelper::generateNumberWithinInterval(Beast::HEALTH_MIN, Beast::HEALTH_MAX))
            ->setStrength(MathHelper::generateNumberWithinInterval(Beast::STRENGTH_MIN, Beast::STRENGTH_MAX))
            ->setDefence(MathHelper::generateNumberWithinInterval(Beast::DEFENCE_MIN, Beast::DEFENCE_MAX))
            ->setSpeed(MathHelper::generateNumberWithinInterval(Beast::SPEED_MIN, Beast::SPEED_MAX))
            ->setLuck(MathHelper::generateNumberWithinInterval(Beast::LUCK_MIN, Beast::LUCK_MAX));

        $this->logger->info("{$this->beast->getName()} has been summoned. He's ready to fight our hero");
        $this->logger->info((string)$this->beast);
    }

    /**
     * @throws BeastMissingException
     * @throws HeroMissingException
     */
    public function checkIfPlayersAreReady(): void
    {
        if (!$this->hero instanceof Hero) {
            throw new HeroMissingException();
        }

        if (!$this->beast instanceof Beast) {
            throw new BeastMissingException();
        }

        $this->logger->info("Players are ready to fight. The battle shall begin.");
    }

    public function determinePlayerRoles(): array
    {
        $players = [$this->hero, $this->beast];

        usort($players, function (Player $player1, Player $player2) {
            if ($player1->getSpeed() < $player2->getSpeed()) {
                return true;
            }

            return $player1->getLuck() < $player2->getLuck();
        });

        $this->setPlayerRoles($players);

        return $players;
    }

    public function switchPlayerRoles(array $players): array
    {
        $players = array_reverse($players);

        $this->setPlayerRoles($players);

        return $players;
    }

    public function fight(Player $attacker, Player $defender): void
    {
        $lock = $this->lock->createLock(static::LOCK_KEY);

        if (!$lock->acquire()) {
            return;
        }

        $this->logger->info(PHP_EOL);

        if ($this->canTheDefenderDodgeTheStrike($defender)) {
            $this->logger->info("{$defender->getName()} manages to dodge the attack from {$attacker->getName()}");
        } else {
            $damage = $this->initializesTheStrike($attacker, $defender);

            $this->logger->info(sprintf("{$attacker->getName()} strikes for %d damage", $damage));
            $this->logger->info(sprintf("{$defender->getName()}'s remaining health is %d", $defender->getHealth()));
        }

        $lock->release();
    }

    public function isGameOver(Player $defender): bool
    {
        $gameOver = $defender->getHealth() === 0;

        if ($gameOver) {
            $this->logger->info("{$defender->getName()} has been defeated.");
        }

        return $gameOver;
    }

    public function isGameDraw(int $rounds, Player $attacker, Player $defender): bool
    {
        $draw = static::MAX_TURNS === $rounds;

        if ($draw) {
            $this->logger->info("The battle ended. There were no winners.");
            $this->logger->info("This was a tough fight between {$attacker->getName()} and {$defender->getName()}");
            $this->logger->info("Can't wait for the next round.");
        }

        return $draw;
    }

    public function canTheDefenderDodgeTheStrike(Player $defender): bool
    {
        return MathHelper::determineWinningChance($defender->getLuck());
    }

    public function initializesTheStrike(Player $attacker, Player $defender): int
    {
        $damage = $attacker->getStrength() - $defender->getDefence();

        $damage = $this->activateSkills($damage, $attacker, $defender);

        $remainingHealth = $defender->getHealth() - $damage;

        if ($remainingHealth < 0) {
            $remainingHealth = 0;
        }

        $defender->setHealth($remainingHealth);

        return $damage;
    }

    public function activateSkills(int $damage, Player $attacker, Player $defender): int
    {
        $damage = $this->triggerSkills($damage, $attacker);

        return $this->triggerSkills($damage, $defender);
    }

    public function prepareForTheNextStrike(): void
    {
        sleep(static::TIME_BETWEEN_STRIKES);
    }

    public function engagePlayers(): void
    {
        $this->em->persist($this->hero);
        $this->em->persist($this->beast);
        $this->em->flush();
    }

    public function letThePlayersRest(): void
    {
        $this->em->remove($this->hero);
        $this->em->remove($this->beast);
        $this->em->flush();
    }

    private function initSkills(): void
    {
        $rapidStrike = (new RapidStrike())
            ->setName(RapidStrike::NAME)
            ->setAction(Action::ATTACK)
            ->setType(RapidStrike::TYPE);

        $magicShield = (new MagicShield())
            ->setName(MagicShield::NAME)
            ->setAction(Action::DEFEND)
            ->setType(MagicShield::TYPE);

        $this->hero->addSkill($rapidStrike);
        $this->hero->addSkill($magicShield);
    }

    private function setPlayerRoles(array $players): void
    {
        list($attacker, $defender) = $players;

        $attacker->setAction(Action::ATTACK);
        $defender->setAction(Action::DEFEND);

        $this->logger->info("{$attacker->getName()} will strike now");
        $this->logger->info("Let's see if {$defender->getName()} can resist");
    }

    private function triggerSkills(int $damage, Player $player): int
    {
        /** @var Skill $skill */
        foreach ($player->filterSkillsByAction($player->getAction()->value) as $skill) {
            $strategy = SkillStrategyFactory::createStrategy($skill::TYPE);
            $context = new SkillContext($strategy);

            if ($context->canCalculateDamage()) {
                $skill->setActivated(true);
                $damage = $context->calculateDamage($damage);
                $this->logger->info(sprintf("[%s] skill activated for %s", $skill->getName(), $player->getName()));
            }
        }

        return $damage;
    }
}
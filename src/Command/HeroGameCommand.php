<?php

namespace App\Command;

use App\Exception\BeastMissingException;
use App\Exception\HeroMissingException;
use App\Service\GameService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Lock\LockFactory;

#[AsCommand(
    name: "app:hero-game",
    description: "Let the fight begin between the hero and the beast",
    aliases: [],
    hidden: false
)]
class HeroGameCommand extends Command
{
    private const string LOCK_KEY = "hero-game-command";

    public function __construct(
        private readonly GameService $gameService,
        private readonly LockFactory $lockFactory,
        ?string $name = null
    )
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $lock = $this->lockFactory->createLock(static::LOCK_KEY);

        if (!$lock->acquire()) {
            $io->warning("There is already an ongoing battle");
            return Command::INVALID;
        }

        try {
            $io->title("Welcome to the forest of Emagia!");

            $this->gameService->summonHero();
            $this->gameService->summonBeast(
                $this->getHelper("question")->ask($input, $output, $this->askForTheBeastName())
            );
            $this->gameService->checkIfPlayersAreReady();
            $this->gameService->engagePlayers();

            list($attacker, $defender) = $this->gameService->determinePlayerRoles();

            $countRounds = 0;

            while (true) {
                $this->gameService->fight($attacker, $defender);

                if (
                    $this->gameService->isGameOver($defender)
                    || $this->gameService->isGameDraw($countRounds, $attacker, $defender)
                ) {
                    break;
                }

                list($attacker, $defender) = $this->gameService->switchPlayerRoles([$attacker, $defender]);

                $countRounds++;

                $this->gameService->prepareForTheNextStrike();
            }

            return Command::SUCCESS;
        } catch (HeroMissingException|BeastMissingException $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        } finally {
            $lock->release();
            $this->gameService->letThePlayersRest();
        }
    }

    protected function askForTheBeastName(): Question
    {
        $question = new Question("Pick the monster that wants to conquer Emagia: ");

        $question->setValidator(function ($answer) {
            $answer = trim((string)$answer);

            if (empty($answer)) {
                throw new BeastMissingException();
            }

            return $answer;
        });

        return $question;
    }
}
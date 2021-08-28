<?php

namespace App\Command;

use App\Service\GameManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GameCommand extends Command
{
    protected static $defaultName = "app:hero-game";

    private $gameManager;

    public function __construct(GameManager $gameManager)
    {
        $this->gameManager = $gameManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription("Play hero game")
             ->setHelp("This command allows you to play the hero game...");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            "Welcome to the holy ground",
            "Let the fight begin",
            "============",
        ]);

        $output->writeln("Preparing players...");

        $hero  = $this->executePlayerCommand($input, $output, "app:hero-player");
        $beast = $this->executePlayerCommand($input, $output, "app:beast-player");

        $output->writeln("Players are ready");
        $output->writeln("The battle is going to be between {$hero} and {$beast}");
        $output->writeln("============");

        $this->gameManager->initCommandLine($output);
        $this->gameManager->initPlayersMeta($hero, $beast);
        $this->gameManager->play();

        return Command::SUCCESS;
    }

    protected function executePlayerCommand(InputInterface $input, OutputInterface $output, string $commandName): string
    {
        $command = $this->getApplication()->find($commandName);
        $command->run($input, $output);

        return $command->playerName;
    }
}

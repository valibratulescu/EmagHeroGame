<?php

namespace App\Command;

use App\Entity\Game;
use App\Service\GameManager;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GameCommand extends Command
{
    protected static $defaultName = "app:hero-game";

    private GameManager $gameManager;

    public function __construct(GameManager $gameManager)
    {
        $this->gameManager = $gameManager;

        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setDescription("Play hero game")
            ->setHelp("This command allows you to play the hero game...");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws CommandNotFoundException
     * @throws Exception
     */
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

        $this->gameManager->setOutput($output);
        $this->gameManager->setEntityGame(new Game());
        $this->gameManager->initPlayersMeta($hero, $beast);
        $this->gameManager->play();

        return Command::SUCCESS;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param string $commandName
     *
     * @return string
     *
     * @throws CommandNotFoundException
     * @throws Exception
     */
    protected function executePlayerCommand(InputInterface $input, OutputInterface $output, string $commandName): string
    {
        $command = $this->getApplication()->find($commandName);
        $command->run($input, $output);

        return $command->playerName;
    }
}

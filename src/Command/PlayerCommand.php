<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class PlayerCommand extends Command
{
    protected static $defaultName = "app:player";

    protected $playerType = "";

    public $playerName = "";

    protected function configure(): void
    {
        $this->setDescription("Creates the {$this->playerType} player")
             ->setHelp("This command allows you to create the {$this->playerType} player...");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper("question");

        $question = new Question("Please enter the {$this->playerType} name: ", false);

        $question->setValidator(function ($answer) {
            if (empty($answer)) {
                throw new \RuntimeException(
                    "Name cannot be empty. Please add a valid name"
                );
            }

            if (is_string($answer) === false) {
                throw new \RuntimeException(
                    "Invalid name format"
                );
            }

            if (strlen($answer) < 3) {
                throw new \RuntimeException(
                    "Name is too short. It must have at least 3 characters"
                );
            }

            return $answer;
        });

        $this->playerName = $helper->ask($input, $output, $question);

        return Command::SUCCESS;
    }
}

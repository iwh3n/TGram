<?php

namespace Iwh3n\Tgram\Commands;

use Iwh3n\Tgram\ConfigManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('init')
            ->setDescription('Initializing');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cm = new ConfigManager();

        if ($cm->isConfigFile()) {
            $io->writeln('<fg=red>[ERROR]</> The configuration file has already been created.');
            return Command::FAILURE;
        }

        $path = $cm->createConfigFile();

        $io->writeln("<fg=green>[OK]</> The configuration file in <options=underscore,bold>$path</> was successfully created.");

        return Command::SUCCESS;
    }
}

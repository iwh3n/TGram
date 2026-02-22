<?php

namespace Iwh3n\Tgram\Console\Commands\Init;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Iwh3n\Tgram\Config\ConfigManager;
use Iwh3n\Tgram\Console\Ui\Style;

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
        $io = new Style($input, $output);

        try {
            $configManager = new ConfigManager();

            if ($configManager->isConfigFile()) {
                $io->writeln('<fg=red>[ERROR]</> The configuration file has already been created.');
                return Command::FAILURE;
            }

            $path = $configManager->createConfigFile();

            $io->writeln("<fg=green>[OK]</> The configuration file in <options=underscore,bold>$path</> was successfully created.");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
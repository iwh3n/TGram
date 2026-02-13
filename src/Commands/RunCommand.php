<?php

namespace Iwh3n\Tgram\Commands;

use Iwh3n\Tgram\ConfigManager;
use Iwh3n\Tgram\UpdateHandler;
use Iwh3n\Tgram\UpdateManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RunCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('run')
            ->setDescription('Receive updates and send to entry point.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cm = new ConfigManager();
        $isConfig = $cm->isConfigFile();
        $config = $isConfig ? $cm->getConfigFile() : false;

        if (!$isConfig or !$config) {
            $io->writeln("<fg=red>[ERROR]</> Configuration file not found.");
            return Command::FAILURE;
        }

        if (isset($config['bot']) and isset($config['bot']['token']) and isset($config['bot']['entry_point'])) {
            $uh = new UpdateHandler(new UpdateManager($config['bot']['token']));

            $io->writeln("<fg=green>[OK]</> Running...");

            $uh->handle($config['bot']['entry_point']);
        }

        return Command::SUCCESS;
    }
}

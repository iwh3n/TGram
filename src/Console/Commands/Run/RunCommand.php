<?php

namespace Iwh3n\Tgram\Console\Commands\Run;

use Iwh3n\Tgram\Updat\CheckingUpdate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Iwh3n\Tgram\Update\GetUpdates;
use Iwh3n\Tgram\Update\SendUpdate;
use Iwh3n\Tgram\Config\ConfigManager;
use Iwh3n\Tgram\Console\Ui\Style;
use function is_array;

class RunCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('run')
            ->setDescription('Receive updates and send to entry point');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new Style($input, $output);

        try {
            $configManager = new ConfigManager();
            if (!$configManager->isConfigFile()) {
                $io->error('Configuration file not found.');
                return Command::FAILURE;
            }

            $config = $configManager->getConfigFile();
            if (!is_array($config) || empty($config)) {
                $io->error('Configuration file is empty or invalid.');
                return Command::FAILURE;
            }

            $update = new GetUpdates($config['bot']['token']);
            $checker = new CheckingUpdate($config['allow_updates']);
            $sendUpdate = new SendUpdate($io, $update, $checker);

            $io->success('Running...');
            $sendUpdate->handle($config['bot']['entry_point']);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $io->error('Exception: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
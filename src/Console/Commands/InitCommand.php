<?php

namespace Tgram\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tgram\Config\YamlConfigurationManager;
use Tgram\Console\Style\Style;

class InitCommand extends Command
{
    public function __construct(
        private YamlConfigurationManager $yamlConfigurationManager
    ) {
        parent::__construct();
    }

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

            if ($this->yamlConfigurationManager->isConfigFile()) {
                $io->error('The configuration file has already been created.');
                return Command::FAILURE;
            }

            $path = $this->yamlConfigurationManager->createConfigFile();

            $io->success("The configuration file in <options=underscore,bold>$path</> was successfully created.");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
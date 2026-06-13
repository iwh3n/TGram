<?php

namespace Tgram\Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Command\Command;

class ConsoleApplication extends Application
{
    public function __construct(
        private Finder $finder,
        private ContainerInterface $di
    ) {
        parent::__construct("TGram", "3.0.0 (stable)");
    }

    public function registerCommands(): void
    {
        foreach ($this->getCommands() as $commandClass) {

            if (!class_exists($commandClass)) {
                continue;
            }

            if (!is_subclass_of($commandClass, Command::class)) {
                continue;
            }

            $command = $this->di->get((string) $commandClass);

            $this->addCommand($command);
        }
    }

    private function getCommands(): array
    {
        $commands = [];

        $files = $this->finder
            ->files()
            ->in(__DIR__ . '/Commands')
            ->name('*Command.php');

        foreach ($files as $file) {

            $className = 'Tgram\\Console\\Commands\\' .
                $file->getBasename('.php');

            $commands[] = $className;
        }

        return $commands;
    }
}
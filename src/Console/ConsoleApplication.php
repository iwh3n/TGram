<?php

namespace Iwh3n\Tgram\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Command\Command;

class ConsoleApplication extends Application
{
    private Finder $finder;

    public function __construct()
    {
        parent::__construct("TGram", "2.0.0");
        $this->finder = new Finder();
    }

    public function registerCommands(): void
    {
        $commands = $this->getCommands();
        foreach ($commands as $command) {
            if (class_exists($command) and is_subclass_of($command, Command::class)) {
                $this->addCommand(new $command);
            }
        }
    }

    private function getCommands(): array
    {
        $commands = [];

        $files = $this->finder->files()->in(__DIR__ . "/Commands")->name('*Command.php');

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $className = "Iwh3n\\Tgram\\Console\\Commands\\" . str_replace(["/", ".php"], ["\\", ""], $relativePath);
            $commands[] = $className;
        }

        return $commands;
    }
}
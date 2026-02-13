<?php

namespace Iwh3n\Tgram;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Finder\Finder;

class ConsoleApp
{
    private Application $app;
    private Finder $finder;

    public function __construct()
    {
        $this->app = new Application("TGram", "1.0.0");
        $this->finder = new Finder();
    }

    public function run(): void
    {
        $commands = $this->getCommands();
        foreach ($commands as $command) {
            if (class_exists($command) and is_subclass_of($command, Command::class)) {
                $this->app->addCommand(new $command);
            }
        }

        $this->app->run();
    }

    private function getCommands(): array
    {
        $commands = [];

        $files = $this->finder->files()->in(__DIR__ . "/Commands")->name('*Command.php');

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $className = "Iwh3n\\Tgram\\Commands\\" . str_replace(["/", ".php"], ["\\", ""], $relativePath);
            array_push($commands, $className);
        }

        return $commands;
    }
}

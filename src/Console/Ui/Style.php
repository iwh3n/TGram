<?php

namespace Iwh3n\Tgram\Console\Ui;

use Symfony\Component\Console\Style\SymfonyStyle;

class Style extends SymfonyStyle
{
    public function success($message): void
    {
        parent::writeln("<fg=green>[OK]</> $message");
    }

    public function warning($message): void
    {
        parent::writeln("<fg=yellow>[WARN]</> $message");
    }

    public function error($message): void
    {
        parent::writeln("<fg=red>[ERROR]</> $message");
    }

    public function info($message): void
    {
        parent::writeln("<fg=blue>[INFO]</> $message");
    }

    public function title(string $message): void
    {
        parent::write("<options=bold;fg=magenta>›› $message</>");
    }

    public function note(string|array $message): void
    {
        parent::writeln("    <fg=blue>-</> $message");
    }
}

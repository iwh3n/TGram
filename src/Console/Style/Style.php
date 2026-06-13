<?php

namespace Tgram\Console\Style;

use Symfony\Component\Console\Style\SymfonyStyle;

class Style extends SymfonyStyle
{
    public function success(string|array $message): void
    {
        parent::writeln("<fg=green>[OK]</> $message");
    }

    public function warning(string|array $message): void
    {
        parent::writeln("<fg=yellow>[WARN]</> $message");
    }

    public function error(string|array $message): void
    {
        parent::writeln("<fg=red>[ERROR]</> $message");
    }

    public function info(string|array $message): void
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

    public function logRequest(bool $status, int $seconds, ?string $message = null): void
    {
        $time = date("Y/m/d H:i:s");
        $statusText = $status ? '<fg=green>SUCCESS</>' : '<fg=red>FAILURE</>';

        if ($message) {
            $text = "[$time] $statusText -- $message (in {$seconds}ms)";
        }
        $text = "[$time] $statusText (in {$seconds}ms)";

        parent::writeln($text);
    }

    
}
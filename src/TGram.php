<?php

namespace TGram;

use Tgram\Console\ConsoleApplication;

class TGram {
    public function __construct(
        private ConsoleApplication $consoleApplication
    ) {}

    public function load() {
        $this->consoleApplication->registerCommands();
        $this->consoleApplication->run();
    }
}
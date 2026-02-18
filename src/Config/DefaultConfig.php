<?php

namespace Iwh3n\Tgram\Config;

class DefaultConfig
{
    public static function yaml(): string
    {
        return <<<YAML
bot:
    token: "TELEGRAM BOT TOKEN"
    entry_point: "TELEGRAM BOT ENTRY POINT"
YAML;
    }
}

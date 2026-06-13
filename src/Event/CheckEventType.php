<?php

namespace Tgram\Event;

use Tgram\Config\YamlDefaultConfig;

class CheckEventType
{
    public function __construct(
        private array $update,
        private array $allow_updates,
        private YAMLDefaultConfig $config
    ) {
    }

    public function getEventType(): bool|string
    {
        foreach ($this->config->getArray()['tgram']['allow_updates'] as $type => $value) {
            if (isset($this->update[$type])) {
                return $type;
            }
        }

        return false;
    }

    public function isAllowed(): bool
    {
        foreach ($this->allow_updates as $type => $enabled) {
            if (isset($update[$type])) {
                return (bool) $enabled;
            }
        }

        return false;
    }
    
    public function getEvent(): array
    {
        return $this->update;
    }
}
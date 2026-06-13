<?php

namespace Iwh3n\Tgram\Update;

class CheckingUpdate
{
    public function __construct(
        private array $allow_updates
    ) {}

    public function isAllowed($update): bool
    {
        foreach ($this->allow_updates as $type => $enabled) {
            if (isset($update[$type])) {
                return (bool) $enabled;
            }
        }

        return false;
    }
}
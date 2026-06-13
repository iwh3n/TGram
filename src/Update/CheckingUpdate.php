<?php

namespace Iwh3n\Tgram\Updat;

class CheckingUpdate
{
    public function __construct(
        private array $update,
        private array $allow_updates
    ) {}

    public function isAllowed(): bool
    {
        foreach ($this->allow_updates as $type => $enabled) {
            if (isset($this->update[$type])) {
                return (bool) $enabled;
            }
        }

        return false;
    }
}
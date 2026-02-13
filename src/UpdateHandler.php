<?php

namespace Iwh3n\Tgram;

use Iwh3n\Tgram\UpdateManager;

class UpdateHandler
{
    public function __construct(
        private UpdateManager $updateManager
    ) {
    }

    public function handle(string $entryPoint): void
    {
        pcntl_async_signals(true);
        $stop = false;

        pcntl_signal(SIGINT, function () use (&$stop): void {
            if ($stop)
                return;
            echo PHP_EOL . "Stopping..." . PHP_EOL;
            $stop = true;
        });

        do {
            $update = $this->updateManager->getUpdate();
            if (empty($update)) {
                usleep(200_000);
                continue;
            }

            $this->sendUpdate($entryPoint, $update);
        } while (!$stop);
    }

    private function sendUpdate(string $url, array $update): void
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($update));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_exec($ch);

        $error = curl_error($ch);

        if ($error) {
            echo "Failed to send update: " . curl_error($ch) . "\n";
        }
    }
}
<?php

namespace Iwh3n\Tgram\Update;

use Iwh3n\Tgram\Console\Ui\Style;

class SendUpdate
{
    public function __construct
    (
        private Style $io,
        private GetUpdates $update
    ) {
    }

    public function handle(string $entryPoint): void
    {
        pcntl_async_signals(true);
        $stop = false;

        pcntl_signal(SIGINT, function () use (&$stop): void {
            if ($stop)
                return;
            $stop = true;
            $this->io->success(PHP_EOL . 'Stopping...'. PHP_EOL);
        });

        do {
            $update = $this->update->getUpdate();
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

        $start = microtime(true);
        curl_exec($ch);
        $duration = microtime(true) - $start;

        $error = curl_error($ch);

        $this->io->request(!$error, round($duration, 3));
    }
}
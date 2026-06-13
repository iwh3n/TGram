<?php

namespace Tgram\Event;

class GetEvent
{
    private array $updateQueue = [];

    public function __construct(
        private string $token,
        private int $timeout = 30,
        private ?int $offset = null
    ) {
    }

    public function getEvent(): ?array
    {
        if (empty($this->updateQueue)) {
            $this->fetchUpdates();
        }

        if (empty($this->updateQueue)) {
            return null;
        }

        $update = array_shift($this->updateQueue);

        $this->offset = $update['update_id'] + 1;

        return $update;
    }

    private function fetchUpdates(): void
    {
        $url = "https://api.telegram.org/bot{$this->token}/getUpdates";
        $params = [
            'timeout' => $this->timeout,
            'offset' => $this->offset,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url?" . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (!$response) {
            return;
        }

        $data = json_decode($response, true);
        if (!isset($data['ok']) || !$data['ok'] || empty($data['result'])) {
            return;
        }

        $this->updateQueue = $data['result'];
    }
}
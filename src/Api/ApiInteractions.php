<?php

namespace LaMoore\Tg\Api;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

trait ApiInteractions
{
    public function sendRequest(string $method, array $data = []): mixed
    {
        $baseUrl = Str::of($this->base_url)->append('bot', $this->bot_token, '/');
        $client = new Client([
            'base_uri' => (string) $baseUrl,
            'timeout'  => 3
        ]);

        $response = $client->request('POST', $method, $data);
        $response = json_decode($response->getBody(), true);

        if (!$response['ok']) {
            throw new Exception($response['description'], $response['error_code']);
        }

        return $response['result'];
    }
}

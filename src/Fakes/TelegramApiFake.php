<?php

namespace LaMoore\Tg\Fakes;

use LaMoore\Tg\TelegramApi;

class TelegramApiFake extends TelegramApi {
    protected array $methods = [];

    static function create(string $token, array $config): TelegramApiFake
    {
        $api = new static();

        $api->bot_token = $token;
        $api->debug = $config['debug'] ?? true;
        $api->base_url = $config['api_url'] ?? 'https://api.telegram.org/';

        return $api;
    }

    public function mock(string $method, callable $callback): void
    {
        $this->methods[$method] = $callback;
    }

    public function sendRequest(string $method, array $data = []): mixed
    {
        $method = $this->methods[$method];
        $response = null;

        if (is_callable($method)) {
            $response = $method($data);
        }

        if ($response === null) {
            throw new \Exception('Method error');
        }

        if (!$response['ok']) {
            throw new \Exception($response['description'], $response['error_code']);
        }

        return $response['result'];
    }
}

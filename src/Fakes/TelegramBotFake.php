<?php

namespace LaMoore\Tg\Fakes;

use LaMoore\Tg\TelegramBot;

class TelegramBotFake extends TelegramBot {
    static function create(string $token, array $config = []): static {
        $self = new static();

        $self->config = $config;
        $self->token = $token;
        $self->id = (int)explode(':', $token)[0];
        $self->api = TelegramApiFake::create($token, [
            'debug' => $config['debug'] ?? false,
            'api_url' => $config['api_url'] ?? 'https://api.telegram.org/',
        ]);

        $self->logger->log("Bot $self->id initialized");

        return $self;
    }
}

<?php

namespace LaMoore\Tg;

class TelegramBot {
    public TelegramUpdate $update;
    public TelegramApi $api;

    public function __construct(string $token) {
        $this->api = new TelegramApi([
            'token' => $token
        ]);
    }
}

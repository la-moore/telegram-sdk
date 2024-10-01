<?php

namespace LaMoore\Tg\BotModules;

use LaMoore\Tg\TelegramBot;

class BotLogger
{
    private TelegramBot $bot;

    public function __construct(TelegramBot $bot) {
        $this->bot = $bot;
    }

    public function log(string $message): void
    {
        if ($this->bot->config['debug'] ?? false) {
            echo $message . PHP_EOL;
        }
    }
}

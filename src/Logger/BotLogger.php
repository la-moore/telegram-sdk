<?php

namespace LaMoore\Tg\Logger;

use LaMoore\Tg\TelegramBot;

class BotLogger implements LoggerInterface
{
    protected TelegramBot $bot;

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

<?php

namespace LaMoore\Tg\Logger;

use LaMoore\Tg\TelegramBot;

class BotLogger implements LoggerInterface
{
    protected TelegramBot $bot;
    protected $enabled = false;

    public function __construct(TelegramBot $bot, $enabled = false) {
        $this->bot = $bot;
        $this->enabled = $enabled;
    }

    public function log(string $message): void
    {
        if ($this->enabled) {
            echo $message . PHP_EOL;
        }
    }
}

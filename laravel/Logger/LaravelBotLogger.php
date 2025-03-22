<?php

namespace LaMoore\Tg\Laravel\Logger;

use LaMoore\Tg\Logger\BotLogger;
use Illuminate\Support\Facades\Log;

class LaravelBotLogger extends BotLogger
{
    public function log(string $message): void
    {
        if ($this->enabled) {
            Log::debug($message);
        }
    }
}

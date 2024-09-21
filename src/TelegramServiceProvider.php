<?php

namespace LaMoore\Tg;

use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    public function boot()
    {
        # code...
    }

    public function register()
    {
        # code...
        $this->mergeConfigFrom(__DIR__.'/../config/telegram.php', 'telegram');
        $this->app->bind('telegram-client', fn () => new TelegramClient([
            'debug' => config('telegram.debug'),
            'token' => config('telegram.bot_token'),
        ]));
        $this->app->bind('telegram-api', fn () => new TelegramApi([
            'debug' => config('telegram.debug'),
            'token' => config('telegram.bot_token'),
            'api_url' => config('telegram.api_url'),
        ]));
    }
}

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
        $this->app->bind('telegram-bot', fn () => new TelegramBot());
        $this->app->bind('telegram-api', fn () => new TelegramApi());
    }
}

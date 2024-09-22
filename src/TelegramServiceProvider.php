<?php

namespace LaMoore\Tg;

use Illuminate\Support\ServiceProvider;
use LaMoore\Tg\Console\Commands\SetWebhook;
use LaMoore\Tg\Console\Commands\GetWebhookInfo;
use LaMoore\Tg\Console\Commands\SetCommands;
use LaMoore\Tg\Console\Commands\SetMenuButton;

class TelegramServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetWebhook::class,
                GetWebhookInfo::class,
                SetCommands::class,
                SetMenuButton::class,
            ]);
        }
    }

    public function register()
    {
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

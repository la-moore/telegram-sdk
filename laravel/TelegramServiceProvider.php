<?php

namespace LaMoore\Tg\Laravel;

use Illuminate\Support\ServiceProvider;
use LaMoore\Tg\Laravel\Console\Commands;
use LaMoore\Tg\Laravel\Facades\TelegramApi as TelegramApiFacade;
use LaMoore\Tg\Laravel\Facades\TelegramBot as TelegramBotFacade;
use LaMoore\Tg\Laravel\Logger\LaravelBotLogger;
use LaMoore\Tg\TelegramApi;
use LaMoore\Tg\TelegramBot;

class TelegramServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\SetWebhook::class,
                Commands\GetWebhookInfo::class,
                Commands\SetCommands::class,
                Commands\SetMenuButton::class,
                Commands\GetMe::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/telegram.php', 'telegram');

        $this->app->bind(TelegramBotFacade::class, fn () => TelegramBot::create(config('telegram.bot_token'), [
            'debug' => config('telegram.debug'),
            'logger' => config('telegram.logger', LaravelBotLogger::class),
        ]));
        $this->app->bind(TelegramApiFacade::class, fn () => TelegramApi::create(config('telegram.bot_token'), [
            'debug' => config('telegram.debug'),
            'api_url' => config('telegram.api_url'),
        ]));
    }
}

<?php

namespace LaMoore\Tg\Facades;

use Illuminate\Support\Facades\Facade;
use LaMoore\Tg\Resources\UpdateResource;
use LaMoore\Tg\TelegramBot as TgBot;

/**
 * @property UpdateResource update
 * @method static TgBot command(string $command, callable $callback)
 * @method static TgBot on(string $event, callable $callback)
 * @method static TgBot handleUpdate($request)
 * @method static TgBot clearListeners()
 * @method static TgBot clearCommands()
 */
class TelegramBot extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram-bot';
    }
}

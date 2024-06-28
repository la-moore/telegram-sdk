<?php

namespace LaMoore\Tg\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use LaMoore\Tg\Enums\UpdateTypes;
use LaMoore\Tg\TelegramClient as TgClient;

/**
 * @method static TgClient command(string $command, callable $callback)
 * @method static TgClient on(UpdateTypes $event, callable $callback)
 * @method static TgClient handleUpdate(Request $request)
 * @method static TgClient clearListeners()
 * @method static TgClient clearCommands()
 */
class TelegramClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram-client';
    }
}

<?php

namespace LaMoore\Tg\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use LaMoore\Tg\Enums\UpdateTypes;

/**
 * @method static void command(string $command, array|callable $callback)
 * @method static void on(UpdateTypes $event, array|callable $callback)
 * @method static void clearListeners()
 * @method static void clearCommands()
 * @method static mixed handleUpdate(Request $request)
 * @method static mixed callCommand(string $command, array $parameter = [])
 */
class TelegramClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram-client';
    }
}

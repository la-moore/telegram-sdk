<?php

namespace LaMoore\Tg\Facades;

use Illuminate\Support\Facades\Facade;
use LaMoore\Tg\Enums\UpdateTypes;

/**
 * @method static void command(string $command, array|callable $callback)
 * @method static void on(UpdateTypes $event, array|callable $callback)
 * @method static void clearListeners()
 * @method static void clearCommands()
 * @method static mixed update(array $request)
 * @method static mixed handleUpdate()
 * @method static mixed handleCommands()
 * @method static mixed handleCallbackQuery()
 * @method static mixed callCommand(string $command, array $parameter = [])
 * @method static string getToken()
 */
class TelegramClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram-client';
    }
}

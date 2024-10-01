<?php

namespace LaMoore\Tg\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use LaMoore\Tg\Enums\UpdateTypes;
use LaMoore\Tg\TelegramApi;
use LaMoore\Tg\TelegramUpdate;
use LaMoore\Tg\Chat\TelegramChat;

/**
 * @param string $token
 * @param int $id
 * @param TelegramApi $api
 * @param TelegramUpdate $update
 * @param TelegramChat $chat
 * @method static void command(string $command, array|callable $callback)
 * @method static void on(UpdateTypes $event, array|callable $callback)
 * @method static void clearListeners()
 * @method static void clearCommands()
 * @method static mixed handle(array $request)
 */
class TelegramBot extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TelegramBot::class;
    }
}

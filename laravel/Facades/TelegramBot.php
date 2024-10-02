<?php

namespace LaMoore\Tg\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use LaMoore\Tg\BotModules\BotCommands;
use LaMoore\Tg\BotModules\BotEvents;
use LaMoore\Tg\Chat\TelegramChat;
use LaMoore\Tg\Enums\UpdateTypes;
use LaMoore\Tg\Logger\BotLogger;
use LaMoore\Tg\TelegramApi;
use LaMoore\Tg\TelegramUpdate;

/**
 * @param string $token
 * @param int $id
 * @param BotCommands $commands
 * @param BotEvents $events
 * @param BotLogger $logger
 * @param TelegramApi $api
 * @param TelegramUpdate $update
 * @param TelegramChat $chat
 * @method static void command(string $command, array|callable $callback)
 * @method static void on(UpdateTypes $event, array|callable $callback)
 * @method static mixed handle(array $request)
 */
class TelegramBot extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TelegramBot::class;
    }
}

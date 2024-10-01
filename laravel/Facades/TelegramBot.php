<?php

namespace LaMoore\Tg\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use LaMoore\Tg\BotModules\BotCommands;
use LaMoore\Tg\BotModules\BotEvents;
use LaMoore\Tg\BotModules\BotLogger;
use LaMoore\Tg\Enums\UpdateTypes;
use LaMoore\Tg\TelegramApi;
use LaMoore\Tg\TelegramUpdate;
use LaMoore\Tg\Chat\TelegramChat;

/**
 * @param string $token
 * @param int $id
 * @param BotCommands $commands
 * @param BotEvents $events
 * @param BotLogger $logger
 * @param TelegramApi $api
 * @param TelegramUpdate $update
 * @param TelegramChat $chat
 * @method static void handleCommand(string $command, array|callable $callback)
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

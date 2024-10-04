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
 * @method static void command(string $command, array|callable $callback)
 * @method static void on(UpdateTypes $event, array|callable $callback)
 * @method static void handle(array $request)
 * @method static void init(array $request)
 * @method static void run()
 *
 * @method static string getToken()
 * @method static string getId()
 * @method static TelegramApi getApi()
 * @method static TelegramUpdate getUpdate()
 * @method static TelegramChat|null getChat()
 * @method static BotCommands getCommands()
 * @method static BotEvents getEvents()
 * @method static BotLogger getLogger()
 */
class TelegramBot extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TelegramBot::class;
    }
}

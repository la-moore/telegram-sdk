<?php

namespace LaMoore\Tg\Facades;

use Illuminate\Support\Facades\Facade;
use LaMoore\Tg\Resources\UpdateResource;

/**
 * @property UpdateResource update
 */
class TelegramBot extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram-bot';
    }
}

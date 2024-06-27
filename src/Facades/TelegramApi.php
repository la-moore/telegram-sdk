<?php

namespace LaMoore\Tg\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \LaMoore\Tg\Resources\UserResource getMe()
 * @method static \LaMoore\Tg\Resources\BotNameResource getMyName()
 * @method static \LaMoore\Tg\Resources\BotDescriptionResource getMyDescription()
 * @method static \LaMoore\Tg\Resources\BotShortDescriptionResource getMyShortDescription()
 * @method static \LaMoore\Tg\Resources\UserProfilePhotosResource getUserProfilePhotos(int $user_id, int $offset = 0, int $limit = 100)
 * @method static array sendMessage(array $data)
 * @method static boolean setWebhook(array $data)
 * @method static boolean editMessageReplyMarkup(array $data)
 * @method static array getWebhookInfo()
 */
class TelegramApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram-api';
    }
}

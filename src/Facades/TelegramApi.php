<?php

namespace LaMoore\Tg\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getMe()
 * @method static array getMyName()
 * @method static array getMyDescription()
 * @method static array getMyShortDescription()
 * @method static array getUserProfilePhotos(int $user_id, int $offset = 0, int $limit = 100)
 * @method static array sendMessage(array $data)
 * @method static boolean setWebhook(array $data)
 * @method static array editMessageReplyMarkup(array $data)
 * @method static array editMessageText(array $data)
 * @method static array getWebhookInfo()
 * @method static array sendInvoice(array $data)
 * @method static array createInvoiceLink(array $data)
 * @method static array answerShippingQuery(array $data)
 * @method static array answerPreCheckoutQuery(array $data)
 * @method static array refundStarPayment(array $data)
 * @method static array setChatMenuButton(array $data)
 */
class TelegramApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram-api';
    }
}

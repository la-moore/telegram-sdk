<?php

namespace LaMoore\Tg;

use LaMoore\Tg\Api\ApiInteractions;
use LaMoore\Tg\Api\ApiMethods;
use LaMoore\Tg\Api\ApiPayments;
use LaMoore\Tg\Api\ApiWebhooksMethods;

class TelegramApi
{
    use ApiInteractions;
    use ApiMethods;
    use ApiPayments;
    use ApiWebhooksMethods;

    static public string $base_url;
    static public string $bot_token;
}

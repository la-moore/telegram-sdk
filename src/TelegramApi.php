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

    public string $bot_token;
    public string $base_url;

    static function create(string $token, array $config): TelegramApi
    {
        $api = new static();

        $api->bot_token = $token;
        $api->base_url = $config['api_url'] ?? 'https://api.telegram.org/';

        return $api;
    }
}

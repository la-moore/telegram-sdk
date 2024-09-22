<?php

namespace LaMoore\Tg;

use LaMoore\Tg\Api\ApiInteractions;
use LaMoore\Tg\Api\ApiMethods;
use LaMoore\Tg\Api\ApiPayments;
use LaMoore\Tg\Api\ApiWebhooksMethods;

class TelegramApi
{
    public bool $debug;
    public string $bot_token;
    public string $base_url;

    public function __construct(array $config)
    {
        $this->debug = $config['debug'] ?? true;
        $this->bot_token = $config['token'] ?? '';
        $this->base_url = $config['api_url'] ?? 'https://api.telegram.org/';
    }

    use ApiInteractions;
    use ApiMethods;
    use ApiPayments;
    use ApiWebhooksMethods;
}

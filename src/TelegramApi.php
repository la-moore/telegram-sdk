<?php

namespace LaMoore\Tg;

use LaMoore\Tg\Client\TelegramInteractions;
use LaMoore\Tg\Client\TelegramMethods;
use LaMoore\Tg\Client\TelegramWebhooksMethods;

class TelegramApi
{
    use TelegramInteractions;
    use TelegramMethods;
    use TelegramWebhooksMethods;
}

<?php

namespace LaMoore\Tg\Client;

trait TelegramWebhooksMethods
{
    public function setWebhook(array $data): bool
    {
        $data = $this->sendRequest('/setWebhook', $data);

        return $data;
    }

    public function getWebhookInfo(): array
    {
        $data = $this->sendRequest('/getWebhookInfo');

        return $data;
    }
}

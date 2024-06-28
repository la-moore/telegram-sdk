<?php

namespace LaMoore\Tg\Api;

trait ApiPayments
{
    public function sendInvoice(array $data): array
    {
        $data = $this->sendRequest('/sendInvoice', $data);

        return $data;
    }

    public function createInvoiceLink(array $data): array
    {
        $data = $this->sendRequest('/createInvoiceLink', $data);

        return $data;
    }

    public function answerShippingQuery(array $data): array
    {
        $data = $this->sendRequest('/answerShippingQuery', $data);

        return $data;
    }

    public function answerPreCheckoutQuery(array $data): array
    {
        $data = $this->sendRequest('/answerPreCheckoutQuery', $data);

        return $data;
    }

    public function refundStarPayment(array $data): array
    {
        $data = $this->sendRequest('/refundStarPayment', $data);

        return $data;
    }
}

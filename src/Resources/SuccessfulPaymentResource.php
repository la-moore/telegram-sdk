<?php
namespace LaMoore\Tg\Resources;

class SuccessfulPaymentResource extends BaseResource
{
    public string $currency;
    public int $total_amount;
    public string $invoice_payload;
    public ?string $shipping_option_id = null;
    public ?OrderInfoResource $order_info = null;
    public string $telegram_payment_charge_id;
    public string $provider_payment_charge_id;
}

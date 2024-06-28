<?php
namespace LaMoore\Tg\Resources;

class PreCheckoutQueryResource extends BaseResource
{
    public string $id;
    public UserResource $from;
    public string $currency;
    public int $total_amount;
    public string $invoice_payload;
    public ?string $shipping_option_id = null;
    public ?OrderInfoResource $order_info = null;
}

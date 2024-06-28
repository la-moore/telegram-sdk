<?php
namespace LaMoore\Tg\Resources;

class UpdateResource extends BaseResource
{
    public int $update_id;
    public ?MessageResource $message = null;
    public ?MessageResource $edited_message = null;
    public ?MessageResource $channel_post = null;
    public ?MessageResource $edited_channel_post = null;
    public ?MessageResource $edited_business_message = null;
    public ?CallbackQueryResource $callback_query = null;
    public ?ShippingQueryResource $shipping_query = null;
    public ?PreCheckoutQueryResource $pre_checkout_query = null;
    public ?SuccessfulPaymentResource $successful_payment = null;
}

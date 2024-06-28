<?php
namespace LaMoore\Tg\Resources;

class ShippingQueryResource extends BaseResource
{
    public string $id;
    public UserResource $from;
    public string $invoice_payload;
    public ShippingAddressResource $shipping_address;
}

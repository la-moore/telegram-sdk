<?php
namespace LaMoore\Tg\Resources;

class OrderInfoResource extends BaseResource
{
    public ?string $name = null;
    public ?string $phone_number = null;
    public ?string $email = null;
    public ?ShippingAddressResource $shipping_address = null;
}

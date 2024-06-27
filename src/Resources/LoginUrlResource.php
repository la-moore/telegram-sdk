<?php
namespace LaMoore\Tg\Resources;

class LoginUrlResource extends BaseResource
{
    public string $url;
    public ?string $forward_text = null;
    public ?string $bot_username = null;
    public ?string $request_write_access = null;
}

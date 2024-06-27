<?php
namespace LaMoore\Tg\Resources;

class MessageEntityResource extends BaseResource
{
    public string $type;
    public int $offset;
    public int $length;
    public ?string $url = null;
    public ?UserResource $user = null;
    public ?string $language = null;
    public ?string $custom_emoji_id = null;
}

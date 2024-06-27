<?php

namespace LaMoore\Tg\Client\DTO;

use LaMoore\Tg\Resources\BaseResource;
use LaMoore\Tg\Resources\MessageEntityResource;
use LaMoore\Tg\Resources\LinkPreviewOptionsResource;
use LaMoore\Tg\Resources\ReplyParametersResource;
use LaMoore\Tg\Resources\InlineKeyboardMarkupResource;
use Illuminate\Support\Collection;
use Sunrise\Hydrator\Annotation\Subtype;

class SendMessageDto extends BaseResource
{
    public int $chat_id;
    public string $text;
    public ?string $business_connection_id = null;
    public ?int $message_thread_id = null;
    public ?string $parse_mode = null;
    public ?LinkPreviewOptionsResource $link_preview_options = null;
    public ?bool $disable_notification = null;
    public ?bool $protect_content = null;
    public ?string $message_effect_id = null;
    public ?ReplyParametersResource $reply_parameters = null;
    public ?InlineKeyboardMarkupResource $reply_markup = null;

    #[Subtype(MessageEntityResource::class)]
    public ?Collection $entities = null;
}

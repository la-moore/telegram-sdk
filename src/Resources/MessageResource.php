<?php

namespace LaMoore\Tg\Resources;

use Illuminate\Support\Collection;
use Sunrise\Hydrator\Annotation\Subtype;

class MessageResource extends BaseResource
{
    public string $text;
    public int $message_id;
    public ?ChatResource $chat = null;
    public ?UserResource $from = null;
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

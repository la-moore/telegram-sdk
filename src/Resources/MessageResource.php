<?php

namespace LaMoore\Tg\Resources;

use SergiX44\Hydrator\Annotation\ArrayType;

class MessageResource extends BaseResource
{
    public int $message_id;
    public ?string $text = null;
    public ?string $caption = null;
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
    public ?MessageResource $reply_to_message = null;

    #[ArrayType(PhotoSizeResource::class)]
    public ?array $photo = null;

    #[ArrayType(MessageEntityResource::class)]
    public ?array $entities = null;
}

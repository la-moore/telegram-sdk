<?php
namespace LaMoore\Tg\Resources;

use Illuminate\Support\Collection;
use Sunrise\Hydrator\Annotation\Subtype;

class ReplyParametersResource extends BaseResource
{
    public int $message_id;
    public ?int $chat_id = null;
    public ?bool $allow_sending_without_reply = null;
    public ?string $quote = null;
    public ?string $quote_parse_mode = null;
    public ?int $quote_position = null;

    #[Subtype(MessageEntityResource::class)]
    public ?Collection $quote_entities = null;
}

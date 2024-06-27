<?php
namespace LaMoore\Tg\Resources;

class CallbackQueryResource extends BaseResource
{
    public string $id;
    public UserResource $from;
    public MessageResource $message;
    public string $chat_instance;
    public ?string $inline_message_id = null;
    public ?string $data = null;
    public ?string $game_short_name = null;
}

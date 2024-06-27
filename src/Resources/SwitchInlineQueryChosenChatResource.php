<?php
namespace LaMoore\Tg\Resources;

class SwitchInlineQueryChosenChatResource extends BaseResource
{
    public ?string $query = null;
    public ?string $allow_user_chats = null;
    public ?string $allow_bot_chats = null;
    public ?string $allow_group_chats = null;
    public ?string $allow_channel_chats = null;
}

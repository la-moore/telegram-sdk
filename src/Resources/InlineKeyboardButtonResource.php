<?php
namespace LaMoore\Tg\Resources;

class InlineKeyboardButtonResource extends BaseResource
{
    public string $text;
    public ?string $url = null;
    public ?string $callback_data = null;
    public ?WebAppInfoResource $web_app = null;
    public ?LoginUrlResource $login_url = null;
    public ?string $switch_inline_query = null;
    public ?string $switch_inline_query_current_chat = null;
    public ?SwitchInlineQueryChosenChatResource $switch_inline_query_chosen_chat = null;
    public ?CallbackGameResource $callback_game = null;
    public ?bool $pay = null;
}

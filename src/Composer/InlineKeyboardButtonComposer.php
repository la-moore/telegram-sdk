<?php

namespace LaMoore\Tg\Composer;

use LaMoore\Tg\Resources\CallbackGameResource;
use LaMoore\Tg\Resources\LoginUrlResource;
use LaMoore\Tg\Resources\SwitchInlineQueryChosenChatResource;
use LaMoore\Tg\Resources\WebAppInfoResource;

class InlineKeyboardButtonComposer extends BaseComposer {
    protected string $text;
    protected ?string $url = null;
    protected ?string $callback_data = null;
    protected ?WebAppInfoResource $web_app = null;
    protected ?LoginUrlResource $login_url = null;
    protected ?string $switch_inline_query = null;
    protected ?string $switch_inline_query_current_chat = null;
    protected ?SwitchInlineQueryChosenChatResource $switch_inline_query_chosen_chat = null;
    protected ?CallbackGameResource $callback_game = null;
    protected ?bool $pay = null;

    public function text(string $text): static {
        $this->text = $text;

        return $this;
    }

    public function url(string $url): static {
        $this->url = $url;

        return $this;
    }

    public function callback_data(string $callback_data): static {
        $this->callback_data = $callback_data;

        return $this;
    }

    public function web_app(string $url): static {
        $this->web_app = WebAppInfoResource::make([ 'url' => $url ]);

        return $this;
    }

    public function login_url(string $url, ?string $forward_text, ?string $bot_username, ?string $request_write_access): static {
        $this->login_url = LoginUrlResource::make([
            'url' => $url,
            'forward_text' => $forward_text,
            'bot_username' => $bot_username,
            'request_write_access' => $request_write_access,
        ]);

        return $this;
    }

    public function switch_inline_query(string $switch_inline_query): static {
        $this->switch_inline_query = $switch_inline_query;

        return $this;
    }

    public function switch_inline_query_current_chat(string $switch_inline_query_current_chat): static {
        $this->switch_inline_query_current_chat = $switch_inline_query_current_chat;

        return $this;
    }

    public function switch_inline_query_chosen_chat(?string $query, ?string $allow_user_chats, ?string $allow_bot_chats, ?string $allow_group_chats, ?string $allow_channel_chats): static {
        $this->switch_inline_query_chosen_chat = SwitchInlineQueryChosenChatResource::make([
            'query' => $query,
            'allow_user_chats' => $allow_user_chats,
            'allow_bot_chats' => $allow_bot_chats,
            'allow_group_chats' => $allow_group_chats,
            'allow_channel_chats' => $allow_channel_chats,
        ]);

        return $this;
    }

    public function pay(bool $pay): static {
        $this->pay = $pay;

        return $this;
    }

    public function command(string $name, array $data = []): static {
        $this->callback_data($name.'?'.http_build_query($data));

        return $this;
    }
}

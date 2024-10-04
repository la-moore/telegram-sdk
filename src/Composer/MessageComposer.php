<?php

namespace LaMoore\Tg\Composer;

use LaMoore\Tg\Resources\LinkPreviewOptionsResource;
use LaMoore\Tg\Resources\ReplyParametersResource;

class MessageComposer extends BaseComposer {
    protected int $chat_id;
    protected string $text;
    protected ?string $business_connection_id = null;
    protected ?int $message_thread_id = null;
    protected ?string $parse_mode = null;
    protected ?LinkPreviewOptionsResource $link_preview_options = null;
    protected ?bool $disable_notification = null;
    protected ?bool $protect_content = null;
    protected ?string $message_effect_id = null;
    protected ?ReplyParametersResource $reply_parameters = null;
    protected ?InlineKeyboardComposer $reply_markup = null;

    public function chat_id(int $chat_id): static
    {
        $this->chat_id = $chat_id;

        return $this;
    }

    public function text(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function html(string $text): static
    {
        $this->parse_mode = 'HTML';
        $this->text = $text;

        return $this;
    }

    public function markdown(string $text): static
    {
        $this->parse_mode = 'Markdown';
        $this->text = $text;

        return $this;
    }

    public function markdownV2(string $text): static
    {
        $this->parse_mode = 'MarkdownV2';
        $this->text = $text;

        return $this;
    }

    public function parse_mode(string $parse_mode): static
    {
        $this->parse_mode = $parse_mode;

        return $this;
    }

    public function keyboard(InlineKeyboardComposer $keyboard): static
    {
        $this->reply_markup = $keyboard;

        return $this;
    }

    public function disable_notification(bool $disable_notification): static
    {
        $this->disable_notification = $disable_notification;

        return $this;
    }

    public function message_effect_id(string $message_effect_id): static
    {
        $this->message_effect_id = $message_effect_id;

        return $this;
    }

    public function reply(string $message_id): static
    {
        $this->reply_parameters = ReplyParametersResource::make([
            'message_id' => $message_id
        ]);

        return $this;
    }
}

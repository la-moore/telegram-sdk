<?php

namespace LaMoore\Tg\Chat;

use LaMoore\Tg\Composer\MessageComposer;

class TelegramChatMessage extends MessageComposer {
    protected ?TelegramChat $chat;

    public function chat(TelegramChat $chat) {
        $this->chat = $chat;

        return $this;
    }

    public function send() {
        return $this->chat->sendMessage($this);
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        unset($data['chat']);

        return $data;
    }
}
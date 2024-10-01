<?php

namespace LaMoore\Tg\Chat;

use LaMoore\Tg\TelegramBot;
use LaMoore\Tg\Composer\MessageComposer;

class TelegramChat {
    protected TelegramBot $bot;

    public static function create(TelegramBot $bot): static {
        $self = new static();

        $self->bot = $bot;

        return $self;
    }

    public function message(string $text) {
        return TelegramChatMessage::make()
            ->chat($this)
            ->text($text);
    }

    public function sendMessage(MessageComposer $message) {
        return $this->bot->api->sendMessage(array_merge(
            $message->toArray(),
            ['chat_id' => $this->bot->update->getChat()->id],
        ));
    }
}
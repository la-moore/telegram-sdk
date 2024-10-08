<?php

namespace LaMoore\Tg\Chat;

use LaMoore\Tg\TelegramBot;
use LaMoore\Tg\Composer\MessageComposer;

class TelegramChat {
    public TelegramBot $bot;

    public function __construct(TelegramBot $bot) {
        $this->bot = $bot;
    }

    public function editMessageKeyboard(int $message_id, MessageComposer $message): array
    {
        return $this->bot->api->editMessageReplyMarkup(array_merge(
            $message->toArray(),
            [
                'chat_id' => $this->bot->update->getChat()->id,
                'message_id' => $message_id
            ]
        ));
    }

    public function editMessage(int $message_id, MessageComposer $message): array
    {
        return $this->bot->api->editMessageText(array_merge(
            $message->toArray(),
            [
                'chat_id' => $this->bot->update->getChat()->id,
                'message_id' => $message_id
            ]
        ));
    }

    public function message(string $text): TelegramChatMessage
    {
        return TelegramChatMessage::make()
            ->chat($this)
            ->text($text);
    }

    public function sendMessage(MessageComposer $message)
    {
        return $this->bot->api->sendMessage(array_merge(
            $message->toArray(),
            ['chat_id' => $this->bot->update->getChat()->id],
        ));
    }
}
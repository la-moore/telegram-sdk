<?php

namespace LaMoore\Tg\Chat;

use LaMoore\Tg\TelegramBot;
use LaMoore\Tg\Composer\MessageComposer;
use LaMoore\Tg\Resources\ChatResource;

class TelegramChat extends ChatResource {
    public ?TelegramBot $bot = null;

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
<?php

namespace LaMoore\Tg\Request;

use LaMoore\Tg\Composer\MessageComposer;
use LaMoore\Tg\Facades\TelegramApi;

trait RequestMethods {
    public function sendMessage(MessageComposer $message): array
    {
        return TelegramApi::sendMessage(array_merge(
            ['chat_id' => $this->getMessage()->chat->id],
            $message->toArray()
        ));
    }

    public function editMessageKeyboard(int $message_id, MessageComposer $message): array
    {
        return TelegramApi::editMessageReplyMarkup(array_merge(
            [
                'chat_id' => $this->getMessage()->chat->id,
                'message_id' => $message_id
            ],
            $message->toArray()
        ));
    }

    public function editMessageText(int $message_id, MessageComposer $message): array
    {
        return TelegramApi::editMessageText(array_merge(
            [
                'chat_id' => $this->getMessage()->chat->id,
                'message_id' => $message_id
            ],
            $message->toArray()
        ));
    }
}

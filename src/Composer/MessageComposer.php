<?php

namespace LaMoore\Tg\Composer;

use LaMoore\Tg\Facades\TelegramApi;
use LaMoore\Tg\Client\DTO\SendMessageDto;
use LaMoore\Tg\Resources\ReplyParametersResource;
use LaMoore\Tg\TelegramBot;

class MessageComposer extends SendMessageDto {
    private TelegramBot $tg;

    public function __construct(TelegramBot $tg) {
        $this->tg = $tg;
        $this->chat_id = $this->tg->getMessage()->chat->id;
    }

    public function send(): array{
        return TelegramApi::sendMessage($this->toArray());
    }

    public function replayTo(int $message_id): array{
        $this->reply_parameters = ReplyParametersResource::make([
            'message_id' => $message_id
        ]);
        return TelegramApi::sendMessage($this->toArray());
    }
}

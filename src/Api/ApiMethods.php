<?php

namespace LaMoore\Tg\Api;

trait ApiMethods
{
    public function getMe(): array
    {
        $data = $this->sendRequest('getMe');

        return $data;
    }

    public function getMyName(): array
    {
        $data = $this->sendRequest('getMyName');

        return $data;
    }

    public function getMyDescription(): array
    {
        $data = $this->sendRequest('getMyDescription');

        return $data;
    }

    public function getMyShortDescription(): array
    {
        $data = $this->sendRequest('getMyShortDescription');

        return $data;
    }

    public function getUserProfilePhotos(int $user_id, int $offset = 0, int $limit = 100): array
    {
        $data = $this->sendRequest('getUserProfilePhotos');

        return $data;
    }

    public function sendMessage(array $data): array
    {
        $data = $this->sendRequest('sendMessage', $data);

        return $data;
    }

    public function editMessageReplyMarkup(array $data): array
    {
        $data = $this->sendRequest('editMessageReplyMarkup', $data);

        return $data;
    }

    public function editMessageText(array $data): array
    {
        $data = $this->sendRequest('editMessageText', $data);

        return $data;
    }

    public function getFile(array $data): array
    {
        $data = $this->sendRequest('getFile', $data);

        return $data;
    }

    public function setChatMenuButton(array $data): bool
    {
        $data = $this->sendRequest('setChatMenuButton', $data);

        return $data;
    }

    public function setMyCommands(array $data): bool
    {
        $data = $this->sendRequest('setMyCommands', $data);

        return $data;
    }

    public function getMyCommands(array $data): bool
    {
        $data = $this->sendRequest('getMyCommands', $data);

        return $data;
    }
}

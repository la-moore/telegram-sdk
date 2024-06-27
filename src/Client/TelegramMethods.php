<?php

namespace LaMoore\Tg\Client;

use LaMoore\Tg\Resources\UserResource;
use LaMoore\Tg\Resources\BotNameResource;
use LaMoore\Tg\Resources\BotDescriptionResource;
use LaMoore\Tg\Resources\BotShortDescriptionResource;
use LaMoore\Tg\Resources\UserProfilePhotosResource;
use LaMoore\Tg\Client\DTO\SendMessageDto;

trait TelegramMethods
{
    public function getMe(): UserResource
    {
        $data = $this->sendRequest('/getMe');

        return UserResource::fromArray($data);
    }

    public function getMyName(): BotNameResource
    {
        $data = $this->sendRequest('/getMyName');

        return BotNameResource::fromArray($data);
    }

    public function getMyDescription(): BotDescriptionResource
    {
        $data = $this->sendRequest('/getMyDescription');

        return BotDescriptionResource::fromArray($data);
    }

    public function getMyShortDescription(): BotShortDescriptionResource
    {
        $data = $this->sendRequest('/getMyShortDescription');

        return BotShortDescriptionResource::fromArray($data);
    }

    public function getUserProfilePhotos(int $user_id, int $offset = 0, int $limit = 100): UserProfilePhotosResource
    {
        $data = $this->sendRequest('/getUserProfilePhotos');

        return UserProfilePhotosResource::fromArray($data);
    }

    public function sendMessage(array $data): array
    {
        $data = $this->sendRequest('/sendMessage', $data);

        return $data;
    }

    public function editMessageReplyMarkup(array $data): array
    {
        $data = $this->sendRequest('/editMessageReplyMarkup', $data);

        return $data;
    }
}

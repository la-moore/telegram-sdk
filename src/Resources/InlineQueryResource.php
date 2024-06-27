<?php
namespace LaMoore\Tg\Resources;

class InlineQueryResource extends BaseResource
{
    public string $id;
    public UserResource $from;
    public string $query;
    public string $offset;
    public ?string $chat_type = null;
    public ?LocationResource $location = null;
}

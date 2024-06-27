<?php
namespace LaMoore\Tg\Resources;

class ChatResource extends BaseResource
{
    public int $id;
    public string $type;
    public ?string $title = null;
    public ?string $first_name = null;
    public ?string $last_name = null;
    public ?string $username = null;
    public ?bool $is_forum = null;
}

<?php
namespace LaMoore\Tg\Resources;

class UserResource extends BaseResource
{
    public int $id;
    public bool $is_bot;
    public string $first_name;
    public ?string $last_name = null;
    public ?string $username = null;
    public ?string $language_code = null;
    public ?bool $is_premium = null;
    public ?bool $added_to_attachment_menu = null;
    public ?bool $can_join_groups = null;
    public ?bool $can_read_all_group_messages = null;
    public ?bool $supports_inline_queries = null;
    public ?bool $can_connect_to_business = null;
}

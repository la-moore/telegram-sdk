<?php
namespace LaMoore\Tg\Resources;

class LinkPreviewOptionsResource extends BaseResource
{
    public ?bool $is_disabled = null;
    public ?string $url = null;
    public ?bool $prefer_small_media = null;
    public ?bool $prefer_large_media = null;
    public ?bool $show_above_text = null;
}

<?php
namespace LaMoore\Tg\Resources;

class FileResource extends BaseResource
{
    public string $file_id;
    public string $file_unique_id;
    public ?int $file_size = null;
    public ?string $file_path = null;
}

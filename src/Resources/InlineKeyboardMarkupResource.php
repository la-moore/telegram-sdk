<?php
namespace LaMoore\Tg\Resources;

use SergiX44\Hydrator\Annotation\ArrayType;

class InlineKeyboardMarkupResource extends BaseResource
{
    #[ArrayType(InlineKeyboardButtonResource::class, depth: 2)]
    public ?array $inline_keyboard = null;

    public function toArray(): string
    {
        if (isset($this->inline_keyboard)) {
            $inline_keyboard = array_map(function ($row) {
                return array_map(fn ($item) => $item->toArray(),$row);
            }, $this->inline_keyboard);

            return json_encode([
                'inline_keyboard' => $inline_keyboard
            ]);
        }

        return json_encode([]);
    }
}

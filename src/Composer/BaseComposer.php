<?php

namespace LaMoore\Tg\Composer;

use Illuminate\Contracts\Support\Arrayable;
use LaMoore\Tg\Resources\BaseResource;

class BaseComposer {
    public static function make (): static {
        return new static();
    }

    public function toArray(): array
    {
        $data = [...get_object_vars($this)];

        return collect($data)
            ->map(function (mixed $value) {
                if ($value instanceof Arrayable) {
                    return $value->toArray();
                }

                if ($value instanceof BaseComposer) {
                    return $value->toArray();
                }

                if ($value instanceof BaseResource) {
                    return $value->toArray();
                }

                return $value;
            })
            ->whereNotNull()
            ->toArray();
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}

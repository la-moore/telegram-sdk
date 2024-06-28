<?php

namespace LaMoore\Tg\Composer;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use LaMoore\Tg\Resources\BaseResource;

class BaseComposer {
    public static function make (): static {
        return new static();
    }

    public function getParamsCollection(): Collection {
        return collect(get_object_vars($this));
    }

    public function toArray(): array
    {
        return $this->getParamsCollection()
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

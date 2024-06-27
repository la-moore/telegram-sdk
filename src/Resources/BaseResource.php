<?php
namespace LaMoore\Tg\Resources;

use SergiX44\Hydrator\Hydrator;
use Illuminate\Contracts\Support\Arrayable;

class BaseResource implements Arrayable
{
    private array $_extra = [];

    public function __set(string $name, mixed $value): void
    {
        $this->_extra[$name] = $value;
    }

    public function __get(string $key): mixed
    {
        return $this->_extra[$key] ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->_extra[$name]);
    }

    public static function make(array $data = []): static
    {
        $hydrator = new Hydrator();

        return $hydrator->hydrate(static::class, $data);
    }

    public function toArray(): array|string
    {
        $data = [...get_object_vars($this)];
//        $data = [...get_object_vars($this), ...$this->_extra];

        return collect($data)
            ->map(function (mixed $value, string $key) {
                if (str_starts_with($key, '_')) {
                    return null;
                }

                if ($value instanceof Arrayable) {
                    return $value->toArray();
                }

                return $value;
            })
            ->whereNotNull()
            ->toArray();
    }
}

<?php

namespace LaMoore\Tg\Client;

use Closure;
use LaMoore\Tg\Enums\UpdateTypes;

trait ClientListeners
{
    static private array $listeners = [];

    public static function on(UpdateTypes $event, callable $callback): void
    {
        if (!isset(self::$listeners[$event->value])) {
            self::$listeners[$event->value] = [];
        }

        self::$listeners[$event->value][] = $callback;
    }

    public static function clearListeners(UpdateTypes $event = null): void
    {
        if ($event === null) {
            self::$listeners = [];
            return;
        }

        unset(self::$listeners[$event->value]);
    }

    protected function hasListener(string $name): bool {
        return isset(self::$listeners[$name]);
    }

    public function emit(UpdateTypes $event, mixed $parameter = null): void
    {
        if ($this->hasListener($event->value)) {
            $listeners = self::$listeners[$event->value];

            foreach ($listeners as $listener) {
                $listener($this->update, $parameter);
            }
        }
    }
}

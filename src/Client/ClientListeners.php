<?php

namespace LaMoore\Tg\Client;

use Closure;
use LaMoore\Tg\Enums\UpdateTypes;

trait ClientListeners
{
    static private array $listeners = [];

    public static function on(UpdateTypes $event, array|callable $callback): void
    {
        if (!isset(self::$listeners[$event->value])) {
            self::$listeners[$event->value] = [];
        }

        self::$listeners[$event->value][] = $callback;
    }

    public function clearListeners(): void
    {
        self::$listeners = [];
    }

    protected function hasListener(string $name): bool {
        return isset(self::$listeners[$name]);
    }

    public function emit(UpdateTypes $event, mixed $parameter = null): void
    {
        if ($this->hasListener($event->value)) {
            $listeners = self::$listeners[$event->value];

            foreach ($listeners as $listener) {
                if ($listener instanceof Closure) {
                    $listener($this->request, $parameter);
                } else if (is_array($listener)) {
                    if (class_exists($listener[0])) {
                        $action = $listener[1];

                        (new $listener[0])->$action($this->request, $parameter);
                    }
                }
            }
        }
    }
}

<?php

namespace LaMoore\Tg\Client;

use Illuminate\Support\Str;
use LaMoore\Tg\Enums\UpdateTypes;

trait ClientListeners
{
    static private array $listeners = [];

    public function on(string $event, callable $callback): void
    {
        if (!isset(self::$listeners[$event])) {
            self::$listeners[$event] = [];
        }

        self::$listeners[$event][] = $callback;
    }

    public function clearListeners(): void
    {
        self::$listeners = [];
    }

    protected function handleCallbackQueryActions(): void
    {
        $updateType = $this->request->getUpdateType();

        if ($updateType === UpdateTypes::CallbackQuery) {
            $data = parse_url($this->request->update->callback_query->data);
            $command = Str::of($data['path'])->after('/');

            if ($this->hasCommand($command)) {
                parse_str($data['query'], $query);

                $this->tryToExecuteCommand((string) $command, $query);
            }
        }
    }

    protected function hasListener(string $name): bool {
        return isset(self::$listeners[$name]);
    }

    protected function tryToExecuteListener(string $event, mixed $parameter = null): void
    {
        if ($this->hasListener($event)) {
            $listeners = self::$listeners[$event];

            foreach ($listeners as $listener) {
                $listener($this->request, $parameter);
            }
        }
    }
}

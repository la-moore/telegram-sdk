<?php

namespace LaMoore\Tg\Client;

use Closure;

trait ClientCommands
{
    static private array $commands = [];

    public function command(string $command, array|callable $callback): void
    {
        self::$commands[$command] = $callback;
    }

    public function clearCommands(): void
    {
        self::$commands = [];
    }

    protected function hasCommand(string $name): bool {
        return isset(self::$commands[$name]);
    }

    protected function tryToExecuteCommand(string $command, array $parameter = []): void
    {
        if ($this->hasCommand($command)) {
            $callback = self::$commands[$command];

            if ($callback instanceof Closure) {
                $callback($this->request, $parameter);
            } else if (is_array($callback)) {
                if (class_exists($callback[0])) {
                    $action = $callback[1];

                    (new $callback[0])->$action($this->request, $parameter);
                }
            }
        }
    }
}

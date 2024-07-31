<?php

namespace LaMoore\Tg\Client;

use Closure;
use Exception;

trait ClientCommands
{
    static private array $commands = [];

    public static function command(string $command, array|callable $callback): void
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

    public function callCommand(string $command, array $parameter = []): mixed
    {
        if (!$this->hasCommand($command)) {
            throw new Exception('Command not found [' . $command, ']');
        }

        $callback = self::$commands[$command];

        if ($callback instanceof Closure) {
            return $callback($this->request, $parameter);
        } else if (is_array($callback)) {
            if (class_exists($callback[0])) {
                $action = $callback[1];

                return (new $callback[0])->$action($this->request, $parameter);
            }
        }

        return null;
    }
}

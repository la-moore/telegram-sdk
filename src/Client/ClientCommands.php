<?php

namespace LaMoore\Tg\Client;

use Closure;
use Exception;

trait ClientCommands
{
    static private array $commands = [];

    public static function command(string $command, callable $callback): void
    {
        self::$commands[$command] = $callback;
    }

    public static function clearCommands(): void
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

        return $callback($this->update, $parameter);
    }
}

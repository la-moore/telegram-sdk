<?php

namespace LaMoore\Tg\Client;

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

    protected function handleCommands(): void
    {
        $commands = $this->request->getCommands();

        foreach ($commands as $command) {
            $this->tryToExecuteCommand($command['name'], [ 'message' => $command['parameter'] ]);
        }
    }

    protected function hasCommand(string $name): bool {
        return isset(self::$commands[$name]);
    }

    protected function tryToExecuteCommand(string $command, array $parameter = []): void
    {
        if ($this->hasCommand($command)) {
            $callback = self::$commands[$command];
            $callback($this->request, $parameter);
        }
    }
}

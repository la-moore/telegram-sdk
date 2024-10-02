<?php

namespace LaMoore\Tg\BotModules;

use Exception;
use Illuminate\Support\Str;
use LaMoore\Tg\TelegramBot;
use LaMoore\Tg\Enums\UpdateTypes;

class BotCommands
{
    private TelegramBot $bot;
    private array $commands = [];

    public function __construct(TelegramBot $bot) {
        $this->bot = $bot;
    }

    public function command(string $command, callable $callback): void
    {
        $this->commands[$command] = $callback;
    }

    public function clearCommands(): void
    {
        $this->commands = [];
    }

    public function hasCommand(string $name): bool {
        return array_key_exists($name, $this->commands);
    }

    public function callCommand(string $command, array $parameter = []): mixed
    {
        $this->bot->logger->log("Call command [$command] with parameter: " . json_encode($parameter));

        if (!$this->hasCommand($command)) {
            $this->bot->logger->log("Command: [$command] not found");
            throw new Exception("Command not found [$command]");
        }

        $this->bot->logger->log("Start command: $command");
        $callback = $this->commands[$command];
        $this->bot->logger->log("Finish command: $command");

        return $callback($this->bot, $parameter);
    }

    public function handleCommands(): void
    {
        $commands = $this->bot->update->getCommands();

        foreach ($commands as $command) {
            $this->bot->logger->log("Handle command: $command");
            $this->callCommand($command['name'], [ 'message' => $command['parameter'] ]);
        }
    }

    public function handleCallbackQueryActions(): void
    {
        $updateType = $this->bot->update->getType();

        if ($updateType === UpdateTypes::CallbackQuery) {
            $data = parse_url($this->bot->update->data->callback_query->data);
            $command = (string) Str::of($data['path'])->after('/');

            parse_str($data['query'], $query);

            $this->bot->logger->log("Handle callback query action: $command");
            $this->callCommand($command, $query);
        }
    }
}

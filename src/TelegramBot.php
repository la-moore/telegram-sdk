<?php

namespace LaMoore\Tg;

use LaMoore\Tg\BotModules\BotCommands;
use LaMoore\Tg\BotModules\BotEvents;
use LaMoore\Tg\BotModules\BotLogger;
use LaMoore\Tg\Chat\TelegramChat;
use LaMoore\Tg\Enums\UpdateTypes;

class TelegramBot {
    public string $token;
    public int $id;
    public array $config;

    public BotCommands $commands;
    public BotEvents $events;
    public BotLogger $logger;

    public TelegramApi $api;
    public TelegramUpdate $update;
    public ?TelegramChat $chat;

    public function __construct() {
        $this->logger = new BotLogger($this);
        $this->commands = new BotCommands($this);
        $this->events = new BotEvents($this);
    }

    static function create(string $token, array $config = []): static
    {
        $self = new static();

        $self->token = $token;
        $self->config = $config;
        $self->id = (int)explode(':', $token)[0];
        $self->api = TelegramApi::create($token, [
            'debug' => $config['debug'] ?? false,
            'api_url' => $config['api_url'] ?? 'https://api.telegram.org/',
        ]);

        $self->logger->log("Bot $self->id initialized");

        return $self;
    }

    public function handle(array $update): void
    {
        $this->logger->log("Received update: " . json_encode($update, JSON_PRETTY_PRINT));

        $this->update = TelegramUpdate::create($update);
        $this->chat = TelegramChat::create($this);

        $this->events->handleEvents();
        $this->commands->handleCommands();
    }

    public function handleCommand(string $command, callable $callback): void
    {
        $this->commands->command($command, $callback);
    }

    public function on(UpdateTypes $event, callable $callback): void
    {
        $this->events->on($event, $callback);
    }
}

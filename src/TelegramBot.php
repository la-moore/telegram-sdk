<?php

namespace LaMoore\Tg;

use LaMoore\Tg\BotModules\BotCommands;
use LaMoore\Tg\BotModules\BotEvents;
use LaMoore\Tg\Chat\TelegramChat;
use LaMoore\Tg\Enums\UpdateTypes;
use LaMoore\Tg\Logger\BotLogger;
use LaMoore\Tg\Logger\LoggerInterface;

class TelegramBot {
    public int $id;
    public string $token;
    public array $config;

    public BotCommands $commands;
    public BotEvents $events;
    public LoggerInterface $logger;

    public TelegramApi $api;
    public TelegramUpdate $update;
    public ?TelegramChat $chat;

    public function __construct() {
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

        $logger = $config['logger'] ?? BotLogger::class;
        $self->logger = new $logger($self);
        $self->logger->log("Bot $self->id initialized");

        return $self;
    }

    public function init(array $update): void
    {
        $this->logger->log("Received update: " . json_encode($update, JSON_PRETTY_PRINT));

        $this->update = TelegramUpdate::create($update);

        $this->chat = new TelegramChat($this);
    }

    public function run(): void
    {
        $this->events->handleEvents();
        $this->commands->handleCommands();
        $this->commands->handleCallbackQueryActions();
    }

    public function handle(array $update): void
    {
        $this->init($update);
        $this->run();
    }


    public function command(string $command, callable $callback): void
    {
        $this->commands->command($command, $callback);
    }

    public function on(UpdateTypes $event, callable $callback): void
    {
        $this->events->on($event, $callback);
    }


    public function getToken(): string
    {
        return $this->token;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getApi(): TelegramApi
    {
        return $this->api;
    }

    public function getUpdate(): TelegramUpdate
    {
        return $this->update;
    }

    public function getChat(): ?TelegramChat
    {
        return $this->chat;
    }

    public function getCommands(): BotCommands
    {
        return $this->commands;
    }

    public function getEvents(): BotEvents
    {
        return $this->events;
    }
}

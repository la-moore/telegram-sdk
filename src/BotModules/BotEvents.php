<?php

namespace LaMoore\Tg\BotModules;

use LaMoore\Tg\Enums\UpdateTypes;
use LaMoore\Tg\TelegramBot;

class BotEvents
{
    private TelegramBot $bot;
    static private array $listeners = [];

    public function __construct(TelegramBot $bot) {
        $this->bot = $bot;
    }

    public function on(UpdateTypes $event, callable $callback): void
    {
        if (!isset(self::$listeners[$event->value])) {
            self::$listeners[$event->value] = [];
        }

        self::$listeners[$event->value][] = $callback;
    }

    public function clearListeners(UpdateTypes $event = null): void
    {
        if ($event === null) {
            self::$listeners = [];
            return;
        }

        unset(self::$listeners[$event->value]);
    }

    public function hasListener(string $name): bool {
        return isset(self::$listeners[$name]);
    }

    public function emit(UpdateTypes $event, array $parameter = []): void
    {
        $this->bot->logger->log("Emitting event [$event->value] with parameter: " . json_encode($parameter));

        if ($this->hasListener($event->value)) {
            $listeners = self::$listeners[$event->value];

            foreach ($listeners as $listener) {
                $listener($this->bot->update, $parameter);
            }
        }
    }

    public function handleEvents(): void
    {
        $this->emit(UpdateTypes::Update);
        $this->emit($this->bot->update->getType());
    }
}

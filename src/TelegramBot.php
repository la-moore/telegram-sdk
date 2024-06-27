<?php

namespace LaMoore\Tg;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LaMoore\Tg\Composer\MessageComposer;
use LaMoore\Tg\Resources\MessageResource;
use LaMoore\Tg\Resources\UpdateResource;

class TelegramBot {
    public UpdateResource $update;

    static private array $commands = [];
    static private array $listeners = [];

    public function getMessage(): MessageResource {
        if ($this->update->callback_query) {
            return $this->update->callback_query?->message;
        }

        return $this->update->message;
    }

    public function compose(): MessageComposer {
        return new MessageComposer($this);
    }

    public function command(string $command, callable $callback): void
    {
        self::$commands[$command] = $callback;
    }

    public function on(string $event, callable $callback): void
    {
        if (!isset(self::$listeners[$event])) {
            self::$listeners[$event] = [];
        }

        self::$listeners[$event][] = $callback;
    }

    /**
     * @throws Exception
     */
    public function handleUpdate(Request $request): void
    {
        Log::info(json_encode($request->all()));

        $this->update = UpdateResource::make($request->all());

        $this->tryToExecuteListener('update');

        $this->handleCommands();
        $this->handleCallbackQueryActions();
    }

    public function handleCommands(): void
    {
        $commands = $this->getMessage()->entities?->filter(fn ($entity) => $entity->type === 'bot_command') ?? [];

        foreach ($commands as $command) {
            $this->tryToExecuteListener('command');

            $text = Str::of($this->getMessage()->text);
            $commandName = (string) $text->substr($command->offset, $command->length)
                ->after('/');
            $parameter = (string) $text->after(' ');

            $this->tryToExecuteCommand($commandName, [ 'message' => $parameter ]);
        }
    }

    public function handleCallbackQueryActions(): void
    {
        if ($this->update->callback_query) {
            $data = parse_url($this->update->callback_query->data);
            $command = Str::of($data['path'])->after('/');
            parse_str($data['query'], $query);

            $this->tryToExecuteCommand((string) $command, $query);
        }
    }

    public function clearListeners(): void
    {
        self::$listeners = [];
    }

    public function clearCommands(): void
    {
        self::$commands = [];
    }

    private function tryToExecuteCommand(string $command, array $parameter = []): void
    {
        if (isset(self::$commands[$command])) {
            $callback = self::$commands[$command];
            $callback($this, $parameter);
        }
    }

    private function tryToExecuteListener(string $event, mixed $parameter = null): void
    {
        if (isset(self::$listeners[$event])) {
            $listeners = self::$listeners[$event];

            foreach ($listeners as $listener) {
                $listener($this, $parameter);
            }
        }
    }
}

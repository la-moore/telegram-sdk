<?php

namespace LaMoore\Tg;

use Exception;
use Illuminate\Support\Str;
use LaMoore\Tg\Client\ClientCommands;
use LaMoore\Tg\Client\ClientListeners;
use LaMoore\Tg\Enums\UpdateTypes;

class TelegramClient {
    use ClientCommands;
    use ClientListeners;

    public TelegramUpdate $update;

    public bool $debug;
    public string $token;

    public function __construct(array $config)
    {
        $this->debug = $config['debug'] ?? true;
        $this->token = $config['token'] ?? '';
    }

    public function getToken() {
        return $this->token;
    }

    public function onUpdate(callable $callback): void
    {
        $this->on(UpdateTypes::Update, $callback);
    }

    public function onMessage(callable $callback): void{
        $this->on(UpdateTypes::Message, $callback);
    }

    public function onCommand(string $command, callable $callback): void{
        $this->command($command, $callback);
    }


    /**
     * @throws Exception
     */
    public function update(array $update): void
    {
        $this->update = TelegramUpdate::make($update);
    }

    public function handleUpdate(): void
    {
        try {
            $this->emit(UpdateTypes::Update);

            $this->emit($this->update->getType());
        } catch (Exception $exception) {
            $this->emit(UpdateTypes::Error, $exception);

            throw $exception;
        }
    }

    public function handleCommands(): void
    {
        $commands = $this->update->getCommands();

        foreach ($commands as $command) {
            $this->callCommand($command['name'], [ 'message' => $command['parameter'] ]);
        }
    }

    public function handleActions(): void
    {
        $updateType = $this->update->getType();

        if ($updateType === UpdateTypes::CallbackQuery) {
            $data = parse_url($this->update->update->callback_query->data);
            $command = Str::of($data['path'])->after('/');

            if ($this->hasCommand($command)) {
                parse_str($data['query'], $query);

                $this->callCommand((string) $command, $query);
            }
        }
    }
}

<?php

namespace LaMoore\Tg;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LaMoore\Tg\Client\ClientCommands;
use LaMoore\Tg\Client\ClientListeners;
use LaMoore\Tg\Enums\UpdateTypes;

class TelegramClient {
    use ClientCommands;
    use ClientListeners;

    public TelegramRequest $request;

    /**
     * @throws Exception
     */
    public function handleUpdate(Request $request): void
    {
        Log::info(json_encode($request->all()));

        $this->request = TelegramRequest::make($request->all());

        $this->emit(UpdateTypes::Update);

        $this->handleCommands();
        $this->handleCallbackQueryActions();

        $this->emit($this->request->getUpdateType());
    }

    protected function handleCommands(): void
    {
        $commands = $this->request->getCommands();

        foreach ($commands as $command) {
            $this->tryToExecuteCommand($command['name'], [ 'message' => $command['parameter'] ]);
        }
    }

    protected function handleCallbackQueryActions(): void
    {
        $updateType = $this->request->getUpdateType();

        if ($updateType === UpdateTypes::CallbackQuery) {
            $data = parse_url($this->request->update->callback_query->data);
            $command = Str::of($data['path'])->after('/');

            if ($this->hasCommand($command)) {
                parse_str($data['query'], $query);

                $this->tryToExecuteCommand((string) $command, $query);
            }
        }
    }
}

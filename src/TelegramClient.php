<?php

namespace LaMoore\Tg;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        $this->tryToExecuteListener(UpdateTypes::Update);
        $this->tryToExecuteListener($this->request->getUpdateType());

        $this->handleCommands();
        $this->handleCallbackQueryActions();
    }
}

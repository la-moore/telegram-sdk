<?php

namespace LaMoore\Tg;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LaMoore\Tg\Enums\UpdateTypes;

class TelegramController extends Controller {
    public TelegramRequest $request;

    /**
     * @throws Exception
     */
    public function handleUpdate(Request $request): void
    {
        Log::info(json_encode($request->all()));

        $this->request = TelegramRequest::make($request->all());
        $type = $this->request->getUpdateType();

        $this->handleUpdateTypeAction(UpdateTypes::Update);

        $this->handleCommands();
        $this->handleCallbackQueryActions();
        $this->handleUpdateTypeAction($type);
    }

    protected function handleCommands(): void
    {
        $commands = $this->request->getCommands();

        foreach ($commands as $command) {
            $action = $command['name'];

            if (method_exists($this, $action)) {
                $this->$action($this->request, [ 'message' => $command['parameter'] ]);
            }
        }
    }

    protected function handleUpdateTypeAction(UpdateTypes $type): void
    {
        $type = 'on_'.$type->value;

        if (method_exists($this, $type)) {
            $this->$type($this->request);
        }
    }

    protected function handleCallbackQueryActions(): void
    {
        $updateType = $this->request->getUpdateType();

        if ($updateType === UpdateTypes::CallbackQuery) {
            $data = parse_url($this->request->update->callback_query->data);
            $action = Str::of($data['path'])->after('/');

            if (is_callable($this->$action)) {
                parse_str($data['query'], $query);

                $this->$action($this->request, $query);
            }
        }
    }
}

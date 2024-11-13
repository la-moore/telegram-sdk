<?php

namespace LaMoore\Tg\Laravel\Console\Commands;

use Illuminate\Console\Command;
use LaMoore\Tg\Laravel\Facades\TelegramApi;

class SetCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:set-commands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $commands = config('telegram.commands', []);

        $data = TelegramApi::setMyCommands([
            'commands' => json_encode(array_map( fn ($command, $description) => [
                'command' => $command,
                'description' => $description
            ], array_keys($commands), array_values($commands))),
        ]);

        $this->info(json_encode($data));
    }
}

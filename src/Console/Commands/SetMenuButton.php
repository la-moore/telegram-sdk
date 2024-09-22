<?php

namespace LaMoore\Tg\Console\Commands;

use Illuminate\Console\Command;
use LaMoore\Tg\Facades\TelegramApi;

class SetMenuButton extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:set-menu-button';

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
        $button = config('telegram.chat_menu_button');

        if (!$button) {
            $this->error('No menu button found');
            $this->info('Set your menu button in config/telegram.php');
            return;
        }

        $data = TelegramApi::setChatMenuButton([
            'menu_button' => $button
        ]);

        $this->info(json_encode($data));
    }
}

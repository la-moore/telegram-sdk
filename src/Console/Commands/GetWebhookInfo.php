<?php

namespace LaMoore\Tg\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use LaMoore\Tg\Facades\TelegramApi;

class GetWebhookInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:get-webhook';

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
        $data = TelegramApi::getWebhookInfo();

        $this->info(json_encode($data));
    }
}

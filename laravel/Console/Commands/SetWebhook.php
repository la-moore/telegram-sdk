<?php

namespace LaMoore\Tg\Laravel\Console\Commands;

use Illuminate\Console\Command;
use LaMoore\Tg\Laravel\Facades\TelegramApi;

class SetWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:set-webhook';

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
        $url = config('telegram.webhook.url');

        if (!$url) {
            $this->error('Webhook URL not set');
            $this->info('You can set it in config/telegram.php');
            return;
        }

        $data = TelegramApi::setWebhook([
            'url' => $url,
            'drop_pending_updates' => config('telegram.webhook.drop_pending_updates', false)
        ]);

        $this->info($data);
    }
}

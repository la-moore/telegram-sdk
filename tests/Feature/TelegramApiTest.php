<?php

namespace LaMoore\Tg\Tests\Feature;

use LaMoore\Tg\TelegramApi;
use LaMoore\Tg\Tests\TestCase;
use LaMoore\Tg\Composer\MessageComposer;
use LaMoore\Tg\Composer\InlineKeyboardComposer;
use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;

class TelegramApiTest extends TestCase
{
    protected TelegramApi $api;

    public function setUp(): void
    {
        $this->api = new TelegramApi([
            'debug' => true,
            'token' => env('TG_BOT_TOKEN'),
        ]);
    }

    public function test_getMyName(): void
    {
        $response = $this->api->getMyName();

        $this->assertNotEmpty($response);
    }

    public function test_sendMessage(): void
    {
        $msg = MessageComposer::make()
            ->text("Test message")
            ->keyboard(
                InlineKeyboardComposer::make()
                    ->buttons([
                        InlineKeyboardButtonComposer::make()
                            ->text('Открыть')
                            ->command('set_store_feed'),
                    ])
            );

        $response = $this->api->sendMessage(array_merge(
            ['chat_id' => 679689916],
            $msg->toArray()
        ));

        $this->assertNotEmpty($response);
    }
}

<?php

namespace LaMoore\Tg\Tests\Feature;

use LaMoore\Tg\Fakes\TelegramApiFake;
use LaMoore\Tg\Tests\TestCase;

class TelegramApiTest extends TestCase
{
    protected TelegramApiFake $api;

    public function setUp(): void
    {
        $this->api = TelegramApiFake::create(env('TG_BOT_TOKEN'), [
            'debug' => true,
        ]);

        $botData = [
            'id' => 1122334455,
            'is_bot' => 1,
            'first_name' => 'Bot',
            'username' => 'test_bot',
            'can_join_groups' => 1,
            'can_read_all_group_messages' => null,
            'supports_inline_queries' => null,
            'can_connect_to_business' => null,
            'has_main_web_app' => null,
        ];

        $this->api->mock('getMe', function () use ($botData) {
            return [
                'ok' => true,
                'result' => $botData
            ];
        });

        $this->api->mock('getMyName', function () use ($botData) {
            return [
                'ok' => true,
                'result' => [
                    'name' => $botData['first_name']
                ]
            ];
        });
    }

    public function test_getMe(): void
    {
        $response = $this->api->getMe();

        $this->assertEquals(1122334455, $response['id']);
    }

    public function test_getMyName(): void
    {
        $response = $this->api->getMyName();

        $this->assertEquals('Bot', $response['name']);
    }
}

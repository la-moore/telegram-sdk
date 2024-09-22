<?php

namespace LaMoore\Tg\Tests\Feature;

use LaMoore\Tg\TelegramApi;
use LaMoore\Tg\Tests\TestCase;

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
}

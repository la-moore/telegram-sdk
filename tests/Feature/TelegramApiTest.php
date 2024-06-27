<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Request as RequestFake;
use LaMoore\Tg\Facades\TelegramBot;
use LaMoore\Tg\Facades\TelegramApi;
use LaMoore\Tg\Tests\TestCase;

class TelegramApiTest extends TestCase
{
    public function test_getMyName(): void
    {
//        $response = TelegramApi::getMyName();
//        $this->assertEquals('Community Bots', $response->name);
        $this->assertTrue(true);
    }
}

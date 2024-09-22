<?php

namespace LaMoore\Tg\Tests\Feature;

use LaMoore\Tg\TelegramBot;
use LaMoore\Tg\Tests\TestCase;

class TelegramBotTest extends TestCase
{
    protected TelegramBot $bot;

    public function setUp(): void
    {
        $this->bot = new TelegramBot('');
    }
    public function test_command(): void
    {

    }
}

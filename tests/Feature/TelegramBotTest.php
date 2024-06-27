<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Request as RequestFake;
use LaMoore\Tg\Facades\TelegramBot;
use LaMoore\Tg\Facades\TelegramApi;
use LaMoore\Tg\Tests\TestCase;

class TelegramBotTest extends TestCase
{
    public function test_command(): void
    {
        TelegramBot::command('start', function () {
            $this->assertTrue(true);
        });

        $response = RequestFake::create('/', 'GET', json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/command.json'),
            true
        ));

        TelegramBot::handleUpdate($response);
        TelegramBot::clearListeners();
        TelegramBot::clearCommands();
    }

    public function test_event(): void
    {
        TelegramBot::on('update', function () {
            $this->assertTrue(true);
        });

        $response = RequestFake::create('/', 'GET', json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/command.json'),
            true
        ));

        TelegramBot::handleUpdate($response);
        TelegramBot::clearListeners();
        TelegramBot::clearCommands();
    }

    public function test_callback_action(): void
    {
        TelegramBot::command('test', function ($tg, $data) {
            $this->assertEquals('123', $data['number']);
        });

        $response = RequestFake::create('/', 'GET', json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/callback_query.json'),
            true
        ));

        TelegramBot::handleUpdate($response);
        TelegramBot::clearListeners();
        TelegramBot::clearCommands();
    }
}

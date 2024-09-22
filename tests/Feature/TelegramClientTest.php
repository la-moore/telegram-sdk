<?php

namespace LaMoore\Tg\Tests\Feature;

use LaMoore\Tg\TelegramClient;
use LaMoore\Tg\Tests\TestCase;

class TelegramClientTest extends TestCase
{
    protected TelegramClient $client;

    public function setUp(): void
    {
        $this->client = new TelegramClient([
            'debug' => true,
            'token' => env('TG_BOT_TOKEN'),
        ]);
    }

    public function test_token(): void
    {
        $this->assertEquals(env('TG_BOT_TOKEN'), $this->client->getToken());
    }

    public function test_debug(): void
    {
        $this->assertTrue($this->client->debug);
    }

    public function test_handle(): void
    {
        $update = json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/message.json'),
            true
        );

        $this->client->onUpdate(function () {
            $this->assertTrue(true);
        });

        $this->client->handleUpdate($update);

        TelegramClient::clearListeners();
        TelegramClient::clearCommands();
    }

    public function test_message(): void
    {
        $update = json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/message.json'),
            true
        );

        $this->client->onMessage(function () {
            $this->assertTrue(true);
        });

        $this->client->handleUpdate($update);

        TelegramClient::clearListeners();
        TelegramClient::clearCommands();
    }

    public function test_command(): void
    {
        $update = json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/command.json'),
            true
        );

        $this->client->onCommand('start', function () {
            $this->assertTrue(true);
        });

        $this->client->handleUpdate($update);
        $this->client->handleCommands();

        TelegramClient::clearListeners();
        TelegramClient::clearCommands();
    }

    public function test_actions(): void
    {
        $update = json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/callback_query.json'),
            true
        );

        $this->client->onCommand('test', function () {
            $this->assertTrue(true);
        });

        $this->client->handleUpdate($update);
        $this->client->handleActions();

        TelegramClient::clearListeners();
        TelegramClient::clearCommands();
    }
}

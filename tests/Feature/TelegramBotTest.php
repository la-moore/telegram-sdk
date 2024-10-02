<?php

namespace LaMoore\Tg\Tests\Feature;

use LaMoore\Tg\Fakes\TelegramBotFake;
use LaMoore\Tg\Enums\UpdateTypes;
use LaMoore\Tg\Tests\TestCase;

class TelegramBotTest extends TestCase
{
    protected string $token;
    protected TelegramBotFake $bot;

    public function setUp(): void
    {
        error_reporting(E_ALL);

        $this->token = '1122334455:ABC-DEF1234ghIkl-zyx57W2v1u123ew11';
        $this->bot = TelegramBotFake::create($this->token, [ 'debug' => false ]);

        $this->bot->api->mock('getMe', function () {
            return [
                'ok' => true,
                'result' => [
                    'id' => 1122334455,
                    'is_bot' => 1,
                    'first_name' => 'Bot',
                    'username' => 'test_bot',
                    'can_join_groups' => 1,
                    'can_read_all_group_messages' => null,
                    'supports_inline_queries' => null,
                    'can_connect_to_business' => null,
                    'has_main_web_app' => null,
                ]
            ];
        });

        $this->bot->api->mock('sendMessage', function (array $data) {
            return [
                'ok' => true,
                'result' => $data
            ];
        });
    }

    public function tearDown(): void {
        $this->bot->commands->clearCommands();
        $this->bot->events->clearListeners();
    }


    public function test_api_config(): void
    {
        $apiUrl = 'http://localhost:8181/';
        $bot = TelegramBotFake::create('55444332211:ABC-DEF1234ghIkl-zyx57W2v1u123ew11', [
            'api_url' => $apiUrl,
            'debug' => true
        ]);

        $this->assertEquals($apiUrl, $bot->api->base_url);
        $this->assertTrue($bot->config['debug']);
    }

    public function test_api_getMe(): void
    {
        $response = $this->bot->api->sendRequest('getMe');

        $this->assertEquals($this->bot->id, $response['id']);
    }


    public function test_bootstrap(): void
    {
        $this->assertEquals($this->token, $this->bot->token);
        $this->assertNotEmpty($this->bot->id);
    }

    public function test_command(): void
    {
        $update = json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/command.json'),
            true
        );

        $this->bot->command('start', function () {
            $this->assertTrue(true);
        });

        $this->bot->handle($update);
    }

    public function test_events(): void
    {
        $update = json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/message.json'),
            true
        );

        $this->bot->on(UpdateTypes::Message, function () {
            $this->assertTrue(true);
        });

        $this->bot->handle($update);
    }

    public function test_send_message(): void
    {
        $update = json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/command.json'),
            true
        );

        $this->bot->command('start', function (TelegramBotFake $bot) {
            $data = $bot->chat->message('Hello')->send();

            $this->assertEquals('Hello', $data['text']);
        });

        $this->bot->handle($update);
    }


    public function test_callback_query(): void
    {
        $update = json_decode(
            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/callback_query.json'),
            true
        );

        $this->bot->command('test', function () {
            $this->assertTrue(true);
        });

        $this->bot->handle($update);
    }
}

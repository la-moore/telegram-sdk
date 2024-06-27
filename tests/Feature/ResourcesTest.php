<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Request as RequestFake;
use LaMoore\Tg\TelegramBot as TgBot;
use LaMoore\Tg\Facades\TelegramBot;
use LaMoore\Tg\Tests\TestCase;
use LaMoore\Tg\Client\DTO\SendMessageDto;

class ResourcesTest extends TestCase
{
    public function test_resource_message(): void
    {
        $msg = SendMessageDto::make([
            'text' => 'test message',
            'chat_id' => 123132,
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        ['text' => 'button', 'url' => '...'],
                        [
                            'text' => 'button 1',
                            'web_app' => [ 'url' => '...' ],
                        ],
                    ]
                ]
            ]
        ]);

        print_r($msg->toArray());
    }

//    public function test_resource_message(): void
//    {
//        $response = RequestFake::create('/', 'GET', json_decode(
//            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/command.json'),
//            true
//        ));
//
//        TelegramBot::on('update', function (TgBot $tg) {
//            $this->assertEquals('/start',  $tg->getMessage()->text);
//        });
//
//        TelegramBot::handleUpdate($response);
//        TelegramBot::clearListeners();
//        TelegramBot::clearCommands();
//    }
}

<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Request as RequestFake;
use LaMoore\Tg\TelegramRequest;
use LaMoore\Tg\Facades\TelegramClient;
use LaMoore\Tg\Tests\TestCase;
use LaMoore\Tg\Composer\MessageComposer;
use LaMoore\Tg\Composer\InlineKeyboardComposer;
use LaMoore\Tg\Enums\UpdateTypes;
use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;
use LaMoore\Tg\Composer\InvoiceComposer;
use LaMoore\Tg\Composer\LabeledPriceComposer;

class ResourcesTest extends TestCase
{
    public function test_resource_message(): void
    {
        $invoice = InvoiceComposer::make()
            ->title('100 токенов')
            ->description('GPT токены')
            ->currency('XTR')
            ->payload([
                "payment_id" => 12313
            ])
            ->prices([
                LabeledPriceComposer::make()
                    ->label('Цена')
                    ->amount(123)
            ]);

        print_r($invoice->toArray());

//        $updateData = json_decode(
//            file_get_contents(__DIR__.'/..'.'/..'.'/storage/app/examples/message.json'),
//            true
//        );
//        $response = RequestFake::create('/', 'GET', $updateData);
//
//        TelegramClient::on(UpdateTypes::Update, function (TelegramRequest $request) {
//            $keyboard = InlineKeyboardComposer::make()
//                ->row([
//                    InlineKeyboardButtonComposer::make()->text('button')->web_app('/...')
//                ])
//                ->chunk([
//                    InlineKeyboardButtonComposer::make()->text('button')->url('/...'),
//                    InlineKeyboardButtonComposer::make()->text('button')->callback_data('data'),
//                ], 2)
//                ->buttons([
//                    InlineKeyboardButtonComposer::make()->text('button')->command('paginate', ['p'=>1])
//                ]);
//            $message = MessageComposer::make()
//                ->chat_id(123132)
//                ->text('test message')
//                ->keyboard($keyboard);
//
//            print_r(
//                $request->sendMessage($message)
//            );
//        });
//
//        TelegramClient::handleUpdate($response);
    }
}

<?php

namespace LaMoore\Tg\Tests\Feature;

use LaMoore\Tg\Composer\MessageComposer;
use LaMoore\Tg\Composer\InlineKeyboard\InlineKeyboardLightPaginatorComposer;
use LaMoore\Tg\Composer\InlineKeyboard\InlineKeyboardPaginatorComposer;
use LaMoore\Tg\Composer\InlineKeyboard\InlineKeyboardTabsComposer;
use LaMoore\Tg\Composer\InlineKeyboardComposer;
use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;
use LaMoore\Tg\Composer\InvoiceComposer;
use LaMoore\Tg\Composer\LabeledPriceComposer;
use LaMoore\Tg\Tests\TestCase;

class ComposerTest extends TestCase
{
    public function test_invoice(): void
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

        $this->assertEquals('100 токенов', $invoice->toArray()['title']);
        $this->assertGreaterThan(0, $invoice->toArray()['prices']);
        $this->assertJson('{"payment_id":12313}', $invoice->toArray()['payload']);
    }


    public function test_message(): void
    {
        $message = MessageComposer::make()
            ->chat_id(123)
            ->reply(321)
            ->text('Test');

        $this->assertEquals('Test', $message->toArray()['text']);
        $this->assertEquals(123, $message->toArray()['chat_id']);
        $this->assertEquals(321, $message->toArray()['reply_parameters']['message_id']);
    }

    public function test_message_parse_mode(): void
    {
        $message = MessageComposer::make()
            ->html('Test');

        $this->assertEquals('Test', $message->toArray()['text']);
        $this->assertEquals('HTML', $message->toArray()['parse_mode']);

        $message = MessageComposer::make()
            ->markdown('Test');

        $this->assertEquals('Test', $message->toArray()['text']);
        $this->assertEquals('Markdown', $message->toArray()['parse_mode']);

        $message = MessageComposer::make()
            ->markdownV2('Test');

        $this->assertEquals('Test', $message->toArray()['text']);
        $this->assertEquals('MarkdownV2', $message->toArray()['parse_mode']);
    }


    public function test_keyboard(): void
    {
        $buttons = array_map(function ($i) {
            return InlineKeyboardButtonComposer::make()
                ->text($i)->command($i);
        }, array_keys(array_fill(0, 20, null)));
        $keyboard = InlineKeyboardComposer::make()
            ->buttons($buttons);

        $this->assertCount(20, $keyboard->toArray()['inline_keyboard']);
    }

    public function test_keyboard_pagination(): void
    {
        $buttons = array_map(function ($i) {
            return InlineKeyboardButtonComposer::make()
                ->text($i)->command($i);
        }, array_keys(array_fill(0, 15, null)));
        $keyboard = InlineKeyboardComposer::make()
            ->paginate($buttons, 1, 12);

        $this->assertCount(12, $keyboard->toArray()['inline_keyboard']);

        $keyboard = InlineKeyboardComposer::make()
            ->paginate($buttons, 2);

        $this->assertCount(5, $keyboard->toArray()['inline_keyboard']);
        $this->assertEquals(10, $keyboard->toArray()['inline_keyboard'][0][0]['text']);
    }

    public function test_keyboard_each(): void
    {
        $buttons = array_map(function ($i) {
            return InlineKeyboardButtonComposer::make()
                ->text($i)->command($i);
        }, array_keys(array_fill(0, 2, null)));
        $keyboard = InlineKeyboardComposer::make()->buttons($buttons);

        $keyboard->eachButton(function (InlineKeyboardButtonComposer $button, int $index) {
            $this->assertEquals($index, $button->text);
        });
    }

    public function test_keyboard_chunk(): void
    {
        $buttons = array_map(function ($i) {
            return InlineKeyboardButtonComposer::make()
                ->text($i)->command($i);
        }, array_keys(array_fill(0, 10, null)));
        $keyboard = InlineKeyboardComposer::make()
            ->chunk($buttons, 5);

        $this->assertCount(2, $keyboard->toArray()['inline_keyboard']);
        $this->assertCount(5, $keyboard->toArray()['inline_keyboard'][0]);
    }


    public function test_keyboard_light_paginator(): void
    {
        $buttons = array_map(function ($i) {
            return InlineKeyboardButtonComposer::make()
                ->text($i)->command($i);
        }, array_keys(array_fill(0, 2, null)));
        $keyboard = InlineKeyboardLightPaginatorComposer::make()
            ->buttons($buttons)
            ->page(1)
            ->page_param('p')
            ->count(100)
            ->command('test');

        $this->assertCount(1, end($keyboard->toArray()['inline_keyboard']));

        $keyboard->page(5);

        $this->assertCount(2, end($keyboard->toArray()['inline_keyboard']));

        $keyboard->page(10);

        $this->assertCount(1, end($keyboard->toArray()['inline_keyboard']));

        $keyboard->labels([ 'previous' => 'Back' ]);

        $this->assertEquals('Back', end($keyboard->toArray()['inline_keyboard'])[0]['text']);
        $this->assertEquals('test?p=9', end($keyboard->toArray()['inline_keyboard'])[0]['callback_data']);

        $keyboard->extra_params([ 'msg' => 1 ]);

        $this->assertEquals('test?msg=1&p=9', end($keyboard->toArray()['inline_keyboard'])[0]['callback_data']);
    }

    public function test_keyboard_paginator(): void
    {
        $buttons = array_map(function ($i) {
            return InlineKeyboardButtonComposer::make()
                ->text($i)->command($i);
        }, array_keys(array_fill(0, 2, null)));
        $keyboard = InlineKeyboardPaginatorComposer::make()
            ->buttons($buttons)
            ->page(1)
            ->page_param('p')
            ->count(100)
            ->command('test');

        $this->assertCount(3, end($keyboard->toArray()['inline_keyboard']));
        $this->assertEquals('test?p=1', end($keyboard->toArray()['inline_keyboard'])[0]['callback_data']);
        $this->assertEquals('test?p=2', end($keyboard->toArray()['inline_keyboard'])[1]['callback_data']);
        $this->assertEquals('test?p=10', end($keyboard->toArray()['inline_keyboard'])[2]['callback_data']);

        $keyboard->page(2);

        $this->assertCount(4, end($keyboard->toArray()['inline_keyboard']));
        $this->assertEquals('test?p=1', end($keyboard->toArray()['inline_keyboard'])[0]['callback_data']);
        $this->assertEquals('test?p=2', end($keyboard->toArray()['inline_keyboard'])[1]['callback_data']);
        $this->assertEquals('test?p=3', end($keyboard->toArray()['inline_keyboard'])[2]['callback_data']);
        $this->assertEquals('test?p=10', end($keyboard->toArray()['inline_keyboard'])[3]['callback_data']);

        $keyboard->page(5);

        $this->assertCount(5, end($keyboard->toArray()['inline_keyboard']));
        $this->assertEquals('test?p=1', end($keyboard->toArray()['inline_keyboard'])[0]['callback_data']);
        $this->assertEquals('test?p=4', end($keyboard->toArray()['inline_keyboard'])[1]['callback_data']);
        $this->assertEquals('test?p=5', end($keyboard->toArray()['inline_keyboard'])[2]['callback_data']);
        $this->assertEquals('test?p=6', end($keyboard->toArray()['inline_keyboard'])[3]['callback_data']);
        $this->assertEquals('test?p=10', end($keyboard->toArray()['inline_keyboard'])[4]['callback_data']);

        $keyboard->page(9);

        $this->assertCount(4, end($keyboard->toArray()['inline_keyboard']));
        $this->assertEquals('test?p=1', end($keyboard->toArray()['inline_keyboard'])[0]['callback_data']);
        $this->assertEquals('test?p=8', end($keyboard->toArray()['inline_keyboard'])[1]['callback_data']);
        $this->assertEquals('test?p=9', end($keyboard->toArray()['inline_keyboard'])[2]['callback_data']);
        $this->assertEquals('test?p=10', end($keyboard->toArray()['inline_keyboard'])[3]['callback_data']);

        $keyboard->page(10);

        $this->assertCount(3, end($keyboard->toArray()['inline_keyboard']));
        $this->assertEquals('test?p=1', end($keyboard->toArray()['inline_keyboard'])[0]['callback_data']);
        $this->assertEquals('test?p=9', end($keyboard->toArray()['inline_keyboard'])[1]['callback_data']);
        $this->assertEquals('test?p=10', end($keyboard->toArray()['inline_keyboard'])[2]['callback_data']);
    }


    public function test_keyboard_tabs(): void
    {
        $keyboard = InlineKeyboardTabsComposer::make()
            ->tabs([
                'First' => array_map(function ($i) {
                    return InlineKeyboardButtonComposer::make()
                        ->text($i)->command($i);
                }, array_keys(array_fill(0, 2, null))),
                'Second' => array_map(function ($i) {
                    return InlineKeyboardButtonComposer::make()
                        ->text($i)->command($i);
                }, array_keys(array_fill(0, 3, null)))
            ])
            ->tab(0)
            ->page_param('t')
            ->command('test');

        $this->assertCount(3, $keyboard->toArray()['inline_keyboard']);
        $this->assertEquals('- First -', end($keyboard->toArray()['inline_keyboard'])[0]['text']);
        $this->assertEquals('test?t=0', end($keyboard->toArray()['inline_keyboard'])[0]['callback_data']);
        $this->assertEquals('test?t=1', end($keyboard->toArray()['inline_keyboard'])[1]['callback_data']);

        $keyboard->tab(1);

        $this->assertCount(4, $keyboard->toArray()['inline_keyboard']);
        $this->assertEquals('First', end($keyboard->toArray()['inline_keyboard'])[0]['text']);
    }
}

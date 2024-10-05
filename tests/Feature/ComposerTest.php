<?php

namespace LaMoore\Tg\Tests\Feature;

use LaMoore\Tg\Composer\MessageComposer;
use LaMoore\Tg\Composer\InlineKeyboardNavigation\InlineKeyboardLightPaginatorComposer;
use LaMoore\Tg\Composer\InlineKeyboardNavigation\InlineKeyboardPaginatorComposer;
use LaMoore\Tg\Composer\InlineKeyboardNavigation\InlineKeyboardTabsComposer;
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


    public function test_keyboard_navigation_light_paginator(): void
    {
        $keyboard = InlineKeyboardLightPaginatorComposer::make()
            ->page(1)
            ->parameter('p')
            ->count(100)
            ->command('test');

        $this->assertCount(1, $keyboard->toArray());

        $keyboard->page(5);

        $this->assertCount(2, $keyboard->toArray());

        $keyboard->page(10);

        $this->assertCount(1, $keyboard->toArray());

        $keyboard->labels([ 'previous' => 'Back' ]);

        $this->assertEquals('Back', $keyboard->toArray()[0]['text']);
        $this->assertEquals('test?p=9', $keyboard->toArray()[0]['callback_data']);

        $keyboard->command('test', [ 'msg' => 1 ]);

        $this->assertEquals('test?msg=1&p=9', $keyboard->toArray()[0]['callback_data']);
    }

    public function test_keyboard_navigation_paginator(): void
    {
        $keyboard = InlineKeyboardPaginatorComposer::make()
            ->page(1)
            ->parameter('p')
            ->count(100)
            ->command('test');

        $this->assertCount(3, $keyboard->toArray());
        $this->assertEquals('test?p=1', $keyboard->toArray()[0]['callback_data']);
        $this->assertEquals('test?p=2', $keyboard->toArray()[1]['callback_data']);
        $this->assertEquals('test?p=10', $keyboard->toArray()[2]['callback_data']);

        $keyboard->page(2);

        $this->assertCount(4, $keyboard->toArray());
        $this->assertEquals('test?p=1', $keyboard->toArray()[0]['callback_data']);
        $this->assertEquals('test?p=2', $keyboard->toArray()[1]['callback_data']);
        $this->assertEquals('test?p=3', $keyboard->toArray()[2]['callback_data']);
        $this->assertEquals('test?p=10', $keyboard->toArray()[3]['callback_data']);

        $keyboard->page(5);

        $this->assertCount(5, $keyboard->toArray());
        $this->assertEquals('test?p=1', $keyboard->toArray()[0]['callback_data']);
        $this->assertEquals('test?p=4', $keyboard->toArray()[1]['callback_data']);
        $this->assertEquals('test?p=5', $keyboard->toArray()[2]['callback_data']);
        $this->assertEquals('test?p=6', $keyboard->toArray()[3]['callback_data']);
        $this->assertEquals('test?p=10', $keyboard->toArray()[4]['callback_data']);

        $keyboard->page(9);

        $this->assertCount(4, $keyboard->toArray());
        $this->assertEquals('test?p=1', $keyboard->toArray()[0]['callback_data']);
        $this->assertEquals('test?p=8', $keyboard->toArray()[1]['callback_data']);
        $this->assertEquals('test?p=9', $keyboard->toArray()[2]['callback_data']);
        $this->assertEquals('test?p=10', $keyboard->toArray()[3]['callback_data']);

        $keyboard->page(10);

        $this->assertCount(3, $keyboard->toArray());
        $this->assertEquals('test?p=1', $keyboard->toArray()[0]['callback_data']);
        $this->assertEquals('test?p=9', $keyboard->toArray()[1]['callback_data']);
        $this->assertEquals('test?p=10', $keyboard->toArray()[2]['callback_data']);
    }


    public function test_keyboard_navigation_tabs(): void
    {
        $keyboard = InlineKeyboardTabsComposer::make()
            ->tabs(['First', 'Second', 'Third'])
            ->selected(0)
            ->parameter('t')
            ->selectedLabel('> $label <')
            ->command('test', ['msg' => 1]);

        $this->assertCount(3, $keyboard->toArray());
        $this->assertEquals('> First <', $keyboard->toArray()[0]['text']);

        $keyboard->selected(1);

        $this->assertCount(3, $keyboard->toArray());
        $this->assertEquals('First', $keyboard->toArray()[0]['text']);
        $this->assertEquals('> Second <', $keyboard->toArray()[1]['text']);
    }
}

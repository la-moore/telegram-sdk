<?php

namespace LaMoore\Tg\Tests\Feature;

use LaMoore\Tg\Composer\InvoiceComposer;
use LaMoore\Tg\Composer\LabeledPriceComposer;
use LaMoore\Tg\Tests\TestCase;

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

        $this->assertEquals('100 токенов', $invoice->toArray()['title']);
        $this->assertGreaterThan(0, $invoice->toArray()['prices']);
        $this->assertJson('{"payment_id":12313}', $invoice->toArray()['payload']);
    }
}

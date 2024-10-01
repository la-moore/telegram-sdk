<?php

namespace LaMoore\Tg\Tests;

use LaMoore\Tg\Laravel\TelegramServiceProvider;
use Orchestra\Testbench\TestCase as BaseCase;

class TestCase extends BaseCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            TelegramServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }

    protected function af($app)
    {
        // perform environment setup
    }
}
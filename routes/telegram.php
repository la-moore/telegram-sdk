<?php

use Telegram\Facades\Telegram;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

Route::post('/'.Config::get('telegram.bot_token').'/webhook', [Telegram::class, 'handleUpdate']);

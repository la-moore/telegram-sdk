<?php

namespace LaMoore\Tg\Api;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait ApiInteractions
{
    public function sendRequest(string $method, array $data = []): mixed
    {
        $request = Http::asJson();
        $base_url = config('telegram.api_url');
        $bot_token = config('telegram.bot_token');

        $baseUrl = Str::of($base_url)->append('bot', $bot_token);

        $request = $request->baseUrl($baseUrl)
            ->timeout(30);

        $response = $request->post($method, $data)->json();

        if (!$response['ok']) {
            throw new Exception($response['description'], $response['error_code']);
        }

        return $response['result'];
    }
}

<?php

return [
    "api_url" => env('TG_API_URL', 'https://api.telegram.org/'),
    "bot_token" => env('TG_BOT_TOKEN'),
    "webhook" => [
        "url" => "",
        "drop_pending_updates" => true
    ],
    "chat_menu_button" => [
        "type" => "commands",
    ],
    "commands" => []
];

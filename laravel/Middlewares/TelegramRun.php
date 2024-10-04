<?php

namespace LaMoore\Tg\Laravel\Middlewares;

use Illuminate\Http\Request;
use LaMoore\Tg\Laravel\Facades\TelegramBot;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class TelegramRun
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        TelegramBot::run();

        return $next($request);
    }
}

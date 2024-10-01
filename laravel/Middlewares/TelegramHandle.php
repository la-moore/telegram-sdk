<?php

namespace LaMoore\Tg\Laravel\Middlewares;

use Illuminate\Http\Request;
use LaMoore\Tg\Laravel\Facades\TelegramBot;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class TelegramHandle
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        TelegramBot::handle($request->all());

        return $next($request);
    }
}

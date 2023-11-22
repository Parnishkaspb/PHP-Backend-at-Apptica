<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class Logs
{
    public function handle($request, Closure $next)
    {
        Log::info('Request Logged', ['url' => $request->url(), 'request' => $request->all()]);
        return $next($request);
    }
}
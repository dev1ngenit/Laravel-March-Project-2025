<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ClerkService;

class ClerkAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        $clerk = new ClerkService();

        if (!$clerk->isUserAuthenticated($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

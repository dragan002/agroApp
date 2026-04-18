<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureFarmer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !auth()->user()->isFarmer()) {
            return response()->json(['message' => 'Forbidden. Farmer access required.'], 403);
        }

        return $next($request);
    }
}

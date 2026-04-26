<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureFarmerOnboarding
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->isFarmer()) {
            return response()->json(['message' => 'Forbidden. Farmer access required.'], 403);
        }

        if ($user->onboarding_step === null) {
            return response()->json(['message' => 'Onboarding je već završen.'], 403);
        }

        return $next($request);
    }
}

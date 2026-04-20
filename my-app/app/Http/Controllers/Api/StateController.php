<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use App\Enums\City;
use App\Enums\ProductCategory;
use Illuminate\Http\JsonResponse;

class StateController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->user();

        $farmers = FarmerProfile::active()
            ->with([
                'photos' => fn($q) => $q->orderBy('position')->limit(1),
                'user'   => fn($q) => $q->withCount(['products as products_count' => fn($q2) => $q2->where('is_active', true)]),
            ])
            ->limit(20)
            ->get()
            ->map(fn($fp) => $fp->toCardArray())
            ->values()
            ->all();

        return response()->json([
            'auth'       => $user ? $user->load('farmerProfile.photos')->toApiArray() : null,
            'farmers'    => $farmers,
            'categories' => ProductCategory::all(),
            'cities'     => City::all(),
        ]);
    }
}

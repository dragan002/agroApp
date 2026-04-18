<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q'        => 'nullable|string|max:100',
            'category' => 'nullable|string|in:' . implode(',', \App\Enums\ProductCategory::VALUES),
            'location' => 'nullable|string|max:100',
            'freshOnly'=> 'nullable|in:0,1,true,false',
        ]);

        $q         = $request->query('q');
        $category  = $request->query('category');
        $location  = $request->query('location');
        $freshOnly = $request->boolean('freshOnly');

        // Search farmers
        $farmerQuery = FarmerProfile::active()->with([
            'user',
            'photos' => fn($pq) => $pq->orderBy('position')->limit(1),
        ]);

        if ($q) {
            $farmerQuery->searchName($q);
        }

        if ($location) {
            $farmerQuery->inLocation($location);
        }

        $farmers = $farmerQuery->limit(10)->get()
            ->map(fn($fp) => $fp->toCardArray())
            ->values()
            ->all();

        // Search products
        $productQuery = Product::active()->with([
            'photos'               => fn($pq) => $pq->orderBy('position')->limit(1),
            'user.farmerProfile',
        ]);

        if ($q) {
            $productQuery->search($q);
        }

        if ($category) {
            $productQuery->byCategory($category);
        }

        if ($freshOnly) {
            $productQuery->freshToday();
        }

        $products = $productQuery->limit(20)->get()
            ->map(fn($p) => $p->toCardArray())
            ->values()
            ->all();

        return response()->json([
            'farmers'  => $farmers,
            'products' => $products,
        ]);
    }
}

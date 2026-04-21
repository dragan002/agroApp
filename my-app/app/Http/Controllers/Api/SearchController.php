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
            'city'     => 'nullable|string|in:' . implode(',', \App\Enums\City::VALUES),
            'freshOnly'=> 'nullable|in:0,1,true,false',
        ]);

        $q         = $request->query('q');
        $category  = $request->query('category');
        $city      = $request->query('city');
        $freshOnly = $request->boolean('freshOnly');

        // Search farmers
        $farmerQuery = FarmerProfile::active()->with([
            'user'   => fn($uq) => $uq->withCount('products'),
            'photos' => fn($pq) => $pq->orderBy('position')->limit(1),
        ]);

        if ($q) {
            $farmerQuery->searchName($q);
        }

        if ($city) {
            $farmerQuery->inCity($city);
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

        if ($city) {
            $productQuery->inCity($city);
        }

        $productsPaginated = $productQuery->paginate(100);
        $products = $productsPaginated->map(fn($p) => $p->toCardArray())->values()->all();

        return response()->json([
            'farmers'      => $farmers,
            'products'     => $products,
            'productTotal' => $productsPaginated->total(),
        ]);
    }
}

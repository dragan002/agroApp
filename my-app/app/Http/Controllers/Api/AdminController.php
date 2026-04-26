<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use App\Models\Product;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function farmers(): JsonResponse
    {
        $farmers = FarmerProfile::with([
            'user' => fn($q) => $q->withCount(['products as products_count' => fn($q2) => $q2->where('is_active', true)]),
            'photos' => fn($q) => $q->orderBy('position')->limit(1),
        ])
        ->orderByDesc('created_at')
        ->get()
        ->map(fn($fp) => [
            'id'           => $fp->id,
            'userId'       => $fp->user_id,
            'farmName'     => $fp->farm_name,
            'location'     => $fp->address ? "{$fp->address}, {$fp->city}" : $fp->city,
            'isActive'     => $fp->is_active,
            'createdAt'    => $fp->created_at?->toDateString(),
            'productCount' => $fp->user->products_count ?? 0,
            'coverPhoto'   => $fp->photos->isNotEmpty() ? $fp->photos->first()->toApiArray() : null,
            'user'         => $fp->user ? [
                'id'    => $fp->user->id,
                'name'  => $fp->user->name,
                'email' => $fp->user->email,
                'phone' => $fp->user->phone,
            ] : null,
        ])
        ->values()
        ->all();

        return response()->json($farmers);
    }

    public function approveFarmer(int $id): JsonResponse
    {
        $profile = FarmerProfile::findOrFail($id);
        $profile->update(['is_active' => true]);

        return response()->json(['id' => $profile->id, 'isActive' => true]);
    }

    public function rejectFarmer(int $id): JsonResponse
    {
        $profile = FarmerProfile::findOrFail($id);
        $profile->update(['is_active' => false]);

        return response()->json(['id' => $profile->id, 'isActive' => false]);
    }

    public function products(): JsonResponse
    {
        $products = Product::with([
            'photos'               => fn($q) => $q->orderBy('position')->limit(1),
            'user.farmerProfile',
        ])
        ->orderByDesc('created_at')
        ->get()
        ->map(fn($p) => array_merge($p->toCardArray(), [
            'isActive' => $p->is_active,
        ]))
        ->values()
        ->all();

        return response()->json($products);
    }

    public function deleteProduct(int $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        foreach ($product->photos as $photo) {
            Storage::disk()->delete($photo->path);
            $photo->delete();
        }

        $product->delete();

        return response()->json(['message' => 'Proizvod trajno obrisan.']);
    }
}

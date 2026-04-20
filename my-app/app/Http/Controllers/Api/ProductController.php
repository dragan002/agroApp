<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Product;
use App\Enums\City;
use App\Enums\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::active()
            ->with([
                'photos'               => fn($q) => $q->orderBy('position')->limit(1),
                'user.farmerProfile',
            ]);

        if ($search = $request->query('search')) {
            $query->search($search);
        }

        if ($category = $request->query('category')) {
            $query->byCategory($category);
        }

        if ($request->boolean('freshOnly')) {
            $query->freshToday();
        }

        if ($city = $request->query('city')) {
            $query->inCity($city);
        }

        $paginated = $query->paginate(20);

        return response()->json([
            'data' => $paginated->map(fn($p) => $p->toCardArray())->values()->all(),
            'meta' => [
                'currentPage' => $paginated->currentPage(),
                'lastPage'    => $paginated->lastPage(),
                'total'       => $paginated->total(),
            ],
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $product = Product::active()->with([
            'photos',
            'user.farmerProfile.photos',
        ])->findOrFail($id);

        return response()->json($product->toApiArray());
    }

    public function myProducts(Request $request): JsonResponse
    {
        $products = $request->user()
            ->products()
            ->with(['photos'])
            ->get()
            ->map(fn($p) => $p->toApiArray())
            ->values()
            ->all();

        return response()->json($products);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|in:' . implode(',', ProductCategory::VALUES),
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:2000',
            'priceUnit'   => 'nullable|string|max:20',
            'freshToday'  => 'nullable|boolean',
            'photos'      => 'nullable|array|max:5',
            'photos.*'    => 'mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $user    = $request->user();
        $product = $user->products()->create([
            'name'        => $data['name'],
            'category'    => $data['category'],
            'price'       => $data['price'],
            'description' => $data['description'] ?? null,
            'price_unit'  => $data['priceUnit'] ?? null,
            'fresh_today' => $data['freshToday'] ?? false,
            'is_active'   => true,
        ]);

        if ($request->hasFile('photos')) {
            $position = 0;
            foreach ($request->file('photos') as $file) {
                $path = $file->store("products/{$user->id}");
                $product->photos()->create([
                    'path'     => $path,
                    'position' => $position++,
                ]);
            }
        }

        return response()->json($product->fresh()->load('photos')->toApiArray(), 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Nemate dozvolu za ovu akciju.'], 403);
        }

        $data = $request->validate([
            'name'        => 'nullable|string|max:255',
            'category'    => 'nullable|string|in:' . implode(',', ProductCategory::VALUES),
            'price'       => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:2000',
            'priceUnit'   => 'nullable|string|max:20',
            'freshToday'  => 'nullable|boolean',
        ]);

        $updateData = array_filter([
            'name'        => $data['name'] ?? null,
            'category'    => $data['category'] ?? null,
            'price'       => $data['price'] ?? null,
            'description' => $data['description'] ?? null,
            'price_unit'  => $data['priceUnit'] ?? null,
            'fresh_today' => isset($data['freshToday']) ? $data['freshToday'] : null,
        ], fn($v) => $v !== null);

        $product->update($updateData);

        return response()->json($product->fresh()->load('photos')->toApiArray());
    }

    public function toggleFresh(Request $request, int $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Nemate dozvolu za ovu akciju.'], 403);
        }

        $product->update(['fresh_today' => !$product->fresh_today]);
        $product->refresh();

        return response()->json([
            'id'         => $product->id,
            'freshToday' => $product->fresh_today,
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Nemate dozvolu za ovu akciju.'], 403);
        }

        $product->update(['is_active' => false]);

        return response()->json(['message' => 'Proizvod je obrisan.']);
    }

    public function deletePhoto(Request $request, int $id, int $photoId): JsonResponse
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Nemate dozvolu za ovu akciju.'], 403);
        }

        $photo = Photo::where('id', $photoId)
            ->where('photoable_type', Product::class)
            ->where('photoable_id', $product->id)
            ->firstOrFail();

        Storage::disk()->delete($photo->path);
        $photo->delete();

        return response()->json(['message' => 'Fotografija je obrisana.']);
    }
}

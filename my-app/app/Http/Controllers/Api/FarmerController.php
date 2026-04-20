<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FarmerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = FarmerProfile::active()->with([
            'photos' => fn($q) => $q->orderBy('position')->limit(1),
            'user'   => fn($q) => $q->withCount(['products as products_count' => fn($q2) => $q2->where('is_active', true)]),
        ]);

        if ($search = $request->query('search')) {
            $query->searchName($search);
        }

        if ($city = $request->query('city')) {
            $query->inCity($city);
        }

        $paginated = $query->paginate(20);

        return response()->json([
            'data' => $paginated->map(fn($fp) => $fp->toCardArray())->values()->all(),
            'meta' => [
                'currentPage' => $paginated->currentPage(),
                'lastPage'    => $paginated->lastPage(),
                'total'       => $paginated->total(),
            ],
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $profile = FarmerProfile::active()->with([
            'user',
            'photos',
            'user.products' => fn($q) => $q->active()->with(
                ['photos' => fn($pq) => $pq->orderBy('position')->limit(1)]
            ),
        ])->findOrFail($id);

        return response()->json($profile->toApiArray());
    }

    public function update(Request $request): JsonResponse
    {
        $user    = $request->user();
        $profile = $user->farmerProfile;

        if (!$profile) {
            return response()->json(['message' => 'Profil nije pronađen.'], 404);
        }

        $data = $request->validate([
            'farmName'    => 'nullable|string|max:255',
            'city'        => 'nullable|string|in:' . implode(',', \App\Enums\City::VALUES),
            'address'     => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'avatar'      => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $updateData = array_filter([
            'farm_name'   => $data['farmName'] ?? null,
            'city'        => $data['city'] ?? null,
            'address'     => $data['address'] ?? null,
            'description' => $data['description'] ?? null,
        ], fn($v) => $v !== null);

        if ($request->hasFile('avatar')) {
            if ($profile->avatar_path) {
                Storage::disk('public')->delete($profile->avatar_path);
            }
            $updateData['avatar_path'] = $request->file('avatar')->store("farmers/{$user->id}", 'public');
        }

        $profile->update($updateData);

        return response()->json($profile->fresh()->load('photos')->toApiArray());
    }

    public function addPhotos(Request $request): JsonResponse
    {
        $request->validate([
            'photos'   => 'required|array',
            'photos.*' => 'mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $user    = $request->user();
        $profile = $user->farmerProfile;

        if (!$profile) {
            return response()->json(['message' => 'Profil nije pronađen.'], 404);
        }

        $currentCount = $profile->photos()->count();

        if ($currentCount >= 30) {
            return response()->json(['message' => 'Dostigli ste maksimalan broj fotografija (30).'], 422);
        }

        $newPhotos = [];
        foreach ($request->file('photos') as $file) {
            if ($currentCount >= 30) break;
            $path = $file->store("farmers/{$user->id}", 'public');
            $photo = $profile->photos()->create([
                'path'     => $path,
                'position' => $currentCount,
            ]);
            $newPhotos[] = $photo->toApiArray();
            $currentCount++;
        }

        return response()->json($newPhotos);
    }

    public function deletePhoto(Request $request, int $photoId): JsonResponse
    {
        $user    = $request->user();
        $profile = $user->farmerProfile;

        if (!$profile) {
            return response()->json(['message' => 'Profil nije pronađen.'], 404);
        }

        $photo = Photo::where('id', $photoId)
            ->where('photoable_type', FarmerProfile::class)
            ->where('photoable_id', $profile->id)
            ->firstOrFail();

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return response()->json(['message' => 'Fotografija je obrisana.']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
{
    public function step2(Request $request): JsonResponse
    {
        $data = $request->validate([
            'phone'    => ['required', 'string', 'max:30', 'regex:/^[+\d\s\-().]+$/'],
            'viber'    => ['nullable', 'string', 'max:30', 'regex:/^[+\d\s\-().]+$/'],
            'whatsapp' => ['nullable', 'string', 'max:30', 'regex:/^[+\d\s\-().]+$/'],
        ]);

        $user = $request->user();
        $user->update([
            'phone'           => $data['phone'],
            'viber'           => $data['viber'] ?? null,
            'whatsapp'        => $data['whatsapp'] ?? null,
            'onboarding_step' => 2,
        ]);

        return response()->json($user->fresh()->toApiArray());
    }

    public function step3(Request $request): JsonResponse
    {
        $data = $request->validate([
            'farmName'    => 'required|string|max:255',
            'city'        => 'required|string|in:' . implode(',', \App\Enums\City::VALUES),
            'address'     => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
        ]);

        $user = $request->user();

        $profile = $user->farmerProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'farm_name'   => $data['farmName'],
                'city'        => $data['city'],
                'address'     => $data['address'] ?? null,
                'description' => $data['description'] ?? null,
                'is_active'   => false,
            ]
        );

        $user->update(['onboarding_step' => 3]);

        return response()->json($user->fresh()->load('farmerProfile')->toApiArray());
    }

    public function step4(Request $request): JsonResponse
    {
        $request->validate([
            'photos'   => 'nullable|array|max:30',
            'photos.*' => 'mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $user    = $request->user();
        $profile = $user->farmerProfile;

        if (!$profile) {
            return response()->json(['message' => 'Profil farmera nije pronađen.'], 422);
        }

        $currentCount = $profile->photos()->count();
        $newPhotos    = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                if ($currentCount >= 30) {
                    break;
                }
                $path = $file->store("farmers/{$user->id}");
                $photo = $profile->photos()->create([
                    'path'     => $path,
                    'position' => $currentCount,
                ]);
                $newPhotos[] = $photo->toApiArray();
                $currentCount++;
            }
        }

        $user->update(['onboarding_step' => 4]);

        return response()->json([
            'photos'        => $newPhotos,
            'farmerProfile' => $profile->fresh()->load('photos')->toApiArray(),
        ]);
    }

    public function complete(Request $request): JsonResponse
    {
        $user    = $request->user();
        $profile = $user->farmerProfile;

        if (!$profile) {
            return response()->json(['message' => 'Profil farmera nije pronađen. Molimo završite korak 3.'], 422);
        }

        $profile->update(['is_active' => true]);
        $user->update(['onboarding_step' => null]);

        return response()->json($user->fresh()->load('farmerProfile.photos')->toApiArray());
    }
}

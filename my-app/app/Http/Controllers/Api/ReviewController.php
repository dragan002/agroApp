<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ReviewController extends Controller
{
    public function index(int $id)
    {
        $farmer = FarmerProfile::active()->findOrFail($id);
        $reviews = $farmer->reviews()->select(['id', 'reviewer_name', 'body', 'rating', 'created_at'])->get();

        return response()->json([
            'reviews' => $reviews,
            'avg'     => $reviews->avg('rating'),
            'count'   => $reviews->count(),
        ]);
    }

    public function store(Request $request, int $id)
    {
        $farmer = FarmerProfile::active()->findOrFail($id);

        $ip = $request->ip();
        $key = 'review:' . $id . ':' . hash('sha256', $ip);

        if (RateLimiter::tooManyAttempts($key, 1)) {
            return response()->json(['message' => 'Možete ostaviti jednu recenziju po farmi u 24 sata.'], 429);
        }

        $validated = $request->validate([
            'reviewer_name' => 'required|string|min:2|max:60',
            'body'          => 'required|string|min:10|max:500',
            'rating'        => 'required|integer|min:1|max:5',
        ]);

        $review = $farmer->reviews()->create([
            ...$validated,
            'ip_hash' => hash('sha256', $ip),
        ]);

        RateLimiter::hit($key, 86400);

        return response()->json([
            'review' => $review->only(['id', 'reviewer_name', 'body', 'rating', 'created_at']),
        ], 201);
    }

    public function adminIndex()
    {
        $reviews = Review::with('farmer:id,farm_name')
            ->latest()
            ->get()
            ->map(fn($r) => [
                'id'            => $r->id,
                'reviewerName'  => $r->reviewer_name,
                'body'          => $r->body,
                'rating'        => $r->rating,
                'farmName'      => $r->farmer?->farm_name,
                'farmerId'      => $r->farmer_id,
                'createdAt'     => $r->created_at->toDateString(),
            ]);

        return response()->json(['reviews' => $reviews]);
    }

    public function destroy(int $id)
    {
        Review::findOrFail($id)->delete();
        return response()->json(['ok' => true]);
    }
}

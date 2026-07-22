<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function getReviews($productId)
    {
        $product = Product::findOrFail($productId);
        $reviews = Review::where('product_id', $productId)
            ->with('user:id,name,avatar')
            ->latest()
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'user_name' => $r->user->name ?? 'Pembeli Proats',
                    'user_avatar' => $r->user->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80',
                    'rating' => $r->rating,
                    'comment' => $r->comment,
                    'time_ago' => $r->created_at->diffForHumans(),
                ];
            });

        $avgRating = Review::where('product_id', $productId)->avg('rating');
        $ratingCount = Review::where('product_id', $productId)->count();

        return response()->json([
            'average_rating' => round($avgRating ?: $product->rating, 1),
            'rating_count' => $ratingCount,
            'reviews' => $reviews,
        ]);
    }

    public function store(Request $request, $productId)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Silakan login terlebih dahulu untuk memberikan ulasan bintang.'], 401);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($productId);

        $review = Review::updateOrCreate(
            ['product_id' => $productId, 'user_id' => $userId],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? '',
            ]
        );

        $user = Auth::user();

        // Notify user about review confirmation
        $user->notify(new \App\Notifications\GeneralNotification(
            "Terima kasih atas Ulasan Anda!",
            "Ulasan bintang {$review->rating} untuk produk '{$product->name}' berhasil disimpan.",
            route('catalog.index'),
            'fas fa-star text-amber-500'
        ));

        // Notify admins about the new review
        $admins = \App\Models\User::where('email', 'like', '%@proats.com')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\GeneralNotification(
                "Ulasan Produk Baru Diterima",
                "Ulasan bintang {$review->rating} dari {$user->name} untuk produk '{$product->name}': " . \Illuminate\Support\Str::limit($review->comment, 40),
                route('admin.reviews.index'),
                'fas fa-star text-amber-500'
            ));
        }

        // Recalculate Product average rating
        $newAvg = Review::where('product_id', $productId)->avg('rating');
        $product->update([
            'rating' => round($newAvg, 1)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Ulasan dan bintang Anda berhasil disimpan.',
            'average_rating' => round($newAvg, 1),
        ]);
    }
}

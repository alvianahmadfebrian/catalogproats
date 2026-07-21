<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $rating = $request->query('rating');
        $search = $request->query('search');

        $query = Review::with(['product', 'user'])->latest();

        if ($rating) {
            $query->where('rating', $rating);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('product', fn($pq) => $pq->where('name', 'like', "%{$search}%"));
            });
        }

        $reviews = $query->paginate(15)->withQueryString();
        $totalReviews = Review::count();
        $avgSystemRating = round(Review::avg('rating') ?: 4.9, 1);

        return view('admin.reviews.index', compact('reviews', 'rating', 'search', 'totalReviews', 'avgSystemRating'));
    }

    public function destroy(Review $review)
    {
        $productId = $review->product_id;
        $review->delete();

        // Recalculate Product average rating
        $product = Product::find($productId);
        if ($product) {
            $newAvg = Review::where('product_id', $productId)->avg('rating');
            $product->update([
                'rating' => round($newAvg ?: 4.9, 1)
            ]);
        }

        return back()->with('success', 'Ulasan bintang berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();

        $query = Product::with('category');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->query('category') !== 'all') {
            $catSlug = $request->query('category');
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        // Badge filter (Mall / Star)
        if ($request->filled('badge')) {
            $badge = $request->query('badge');
            if ($badge === 'mall') {
                $query->where('is_mall', true);
            } elseif ($badge === 'star') {
                $query->where('is_star', true);
            }
        }

        // Rating filter
        if ($request->filled('rating')) {
            $query->where('rating', '>=', (float) $request->query('rating'));
        }

        // Min & Max Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->query('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->query('max_price'));
        }

        // Sorting
        $sort = $request->query('sort', 'popular');
        switch ($sort) {
            case 'latest':
                $query->latest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'discount':
                $query->orderBy('discount_percent', 'desc');
                break;
            case 'popular':
            default:
                $query->orderBy('sold_count', 'desc');
                break;
        }

        $products = $query->get();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'count' => $products->count(),
                'products' => $products->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->name,
                        'slug' => $p->slug,
                        'price' => $p->price,
                        'formatted_price' => $p->formatted_price,
                        'original_price' => $p->original_price,
                        'formatted_original_price' => $p->formatted_original_price,
                        'discount_percent' => $p->discount_percent,
                        'rating' => $p->rating,
                        'sold_count' => $p->sold_count,
                        'formatted_sold' => $p->formatted_sold,
                        'stock' => $p->stock,
                        'location' => $p->location,
                        'is_mall' => $p->is_mall,
                        'is_star' => $p->is_star,
                        'is_flash_sale' => $p->is_flash_sale,
                        'image_url' => $p->image_url,
                        'category_name' => $p->category->name ?? '',
                        'category_slug' => $p->category->slug ?? '',
                        'description' => $p->description,
                        'variants' => $p->variants ?? [],
                    ];
                })
            ]);
        }

        return view('catalog.index', compact(
            'categories',
            'products'
        ));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'formatted_price' => $product->formatted_price,
                'original_price' => $product->original_price,
                'formatted_original_price' => $product->formatted_original_price,
                'discount_percent' => $product->discount_percent,
                'rating' => $product->rating,
                'sold_count' => $product->sold_count,
                'formatted_sold' => $product->formatted_sold,
                'stock' => $product->stock,
                'location' => $product->location,
                'is_mall' => $product->is_mall,
                'is_star' => $product->is_star,
                'is_flash_sale' => $product->is_flash_sale,
                'image_url' => $product->image_url,
                'category_name' => $product->category->name ?? '',
                'description' => $product->description,
                'variants' => $product->variants ?? [],
            ]
        ]);
    }
}

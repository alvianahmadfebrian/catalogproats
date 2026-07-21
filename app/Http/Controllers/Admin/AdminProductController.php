<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->query('category'));
        }

        $products = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => $categories,
            'isEdit' => false
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'rating' => 'required|numeric|min:1|max:5',
            'location' => 'required|string|max:255',
            'image_url' => 'required|url',
            'description' => 'nullable|string',
            'variants_input' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);
        $validated['is_mall'] = $request->boolean('is_mall');
        $validated['is_star'] = $request->boolean('is_star');
        $validated['is_flash_sale'] = $request->boolean('is_flash_sale');

        // Parse comma-separated variants
        if (!empty($validated['variants_input'])) {
            $validated['variants'] = array_map('trim', explode(',', $validated['variants_input']));
        } else {
            $validated['variants'] = [];
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.form', [
            'product' => $product,
            'categories' => $categories,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'rating' => 'required|numeric|min:1|max:5',
            'location' => 'required|string|max:255',
            'image_url' => 'required|url',
            'description' => 'nullable|string',
            'variants_input' => 'nullable|string',
        ]);

        if ($validated['name'] !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);
        }

        $validated['is_mall'] = $request->boolean('is_mall');
        $validated['is_star'] = $request->boolean('is_star');
        $validated['is_flash_sale'] = $request->boolean('is_flash_sale');

        if (!empty($validated['variants_input'])) {
            $validated['variants'] = array_map('trim', explode(',', $validated['variants_input']));
        } else {
            $validated['variants'] = [];
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function toggleFlashSale($id)
    {
        $product = Product::findOrFail($id);
        $product->is_flash_sale = !$product->is_flash_sale;
        $product->save();

        $status = $product->is_flash_sale ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Flash Sale untuk {$product->name} berhasil {$status}!");
    }
}

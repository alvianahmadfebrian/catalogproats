<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class AdminPromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promos,code',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'min_spend' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        Promo::create([
            'code' => strtoupper(trim($request->code)),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_spend' => $request->min_spend ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.promos.index')->with('success', 'Kode Promo berhasil ditambahkan!');
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promos,code,' . $promo->id,
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'min_spend' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $promo->update([
            'code' => strtoupper(trim($request->code)),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_spend' => $request->min_spend ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : false,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.promos.index')->with('success', 'Kode Promo berhasil diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('admin.promos.index')->with('success', 'Kode Promo berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->is_active = !$promo->is_active;
        $promo->save();

        return response()->json([
            'success' => true,
            'is_active' => $promo->is_active,
            'message' => 'Status kode promo berhasil diubah.'
        ]);
    }
}

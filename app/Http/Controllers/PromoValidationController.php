<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoValidationController extends Controller
{
    public function validatePromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $code = strtoupper(trim($request->code));
        $subtotal = (float) $request->subtotal;

        $promo = Promo::where('code', $code)->first();

        if (!$promo) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode promo "' . $code . '" tidak ditemukan.'
            ], 404);
        }

        if (!$promo->is_active) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode promo "' . $code . '" saat ini sedang tidak aktif.'
            ], 422);
        }

        if ($promo->expires_at && $promo->expires_at->isPast()) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode promo "' . $code . '" sudah kadaluarsa.'
            ], 422);
        }

        if ($promo->usage_limit !== null && $promo->times_used >= $promo->usage_limit) {
            return response()->json([
                'valid' => false,
                'message' => 'Kuota pemakaian kode promo "' . $code . '" sudah habis.'
            ], 422);
        }

        if ($subtotal < $promo->min_spend) {
            return response()->json([
                'valid' => false,
                'message' => 'Minimal belanja untuk kode promo ini adalah Rp' . number_format($promo->min_spend, 0, ',', '.') . '.'
            ], 422);
        }

        $discountAmount = $promo->calculateDiscount($subtotal);

        return response()->json([
            'valid' => true,
            'code' => $promo->code,
            'discount_type' => $promo->discount_type,
            'discount_value' => $promo->discount_value,
            'calculated_discount' => $discountAmount,
            'formatted_discount' => 'Rp' . number_format($discountAmount, 0, ',', '.'),
            'message' => 'Kode promo "' . $promo->code . '" berhasil dipasang! Potongan diskon ' . ($promo->discount_type === 'percent' ? $promo->discount_value . '%' : 'Rp' . number_format($promo->discount_value, 0, ',', '.')) . '.'
        ]);
    }
}

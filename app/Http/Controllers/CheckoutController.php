<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'payment' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $items = $request->input('items');

        foreach ($items as $item) {
            $order = Order::create([
                'product_id' => $item['id'],
                'user_id' => $user->id,
                'customer_name' => $request->input('name'),
                'customer_phone' => $request->input('phone'),
                'quantity' => $item['qty'],
                'total_price' => $item['price'] * $item['qty'],
                'status' => 'pending',
            ]);

            // Notify user
            $user->notify(new GeneralNotification(
                "Pesanan #{$order->id} Berhasil Dibuat",
                "Pesanan Anda untuk produk '{$order->product->name}' sedang diproses oleh admin.",
                route('profile.index') . '#orders-tab',
                'fas fa-shopping-bag text-amber-600'
            ));

            // Notify admins
            $admins = User::where('email', 'like', '%@proats.com')->get();
            foreach ($admins as $admin) {
                $admin->notify(new GeneralNotification(
                    "Pesanan Baru #{$order->id} Diterima",
                    "Pesanan baru dari {$order->customer_name} untuk produk '{$order->product->name}'.",
                    route('admin.orders.index'),
                    'fas fa-receipt text-amber-600'
                ));
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Checkout saved successfully'
        ]);
    }
}

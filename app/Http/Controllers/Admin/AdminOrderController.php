<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Order::with('product')->latest();

        if ($status && in_array($status, ['completed', 'pending', 'cancelled'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhereHas('product', fn($pq) => $pq->where('name', 'like', "%{$search}%"));
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders', 'status', 'search'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:completed,pending,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        // Notify user about status change
        if ($order->user) {
            $statusText = $validated['status'] === 'completed' ? 'Selesai' : ($validated['status'] === 'cancelled' ? 'Dibatalkan' : 'Pending');
            $icon = $validated['status'] === 'completed' ? 'fas fa-circle-check text-emerald-600' : ($validated['status'] === 'cancelled' ? 'fas fa-circle-xmark text-red-600' : 'fas fa-clock text-amber-600');
            
            $order->user->notify(new \App\Notifications\GeneralNotification(
                "Status Pesanan #{$order->id} Diperbarui",
                "Pesanan Anda untuk '{$order->product->name}' telah diperbarui menjadi " . strtoupper($statusText),
                route('profile.index') . '#orders-tab',
                $icon
            ));
        }

        return back()->with('success', "Status pesanan #{$order->id} berhasil diperbarui ke " . strtoupper($validated['status']));
    }
}

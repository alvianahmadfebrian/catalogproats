@extends('layouts.admin')

@section('title', 'Daftar Pesanan & Order - Proats Admin CMS')
@section('page_title', 'Kelola Pesanan Pelanggan')

@section('content')
<div class="space-y-5">

    <!-- Top Bar Filter & Stats -->
    <div class="bg-white rounded-2xl p-5 border border-orange-100 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-extrabold text-gray-900">Daftar Transaksi & Order Pelanggan</h2>
            <p class="text-xs text-gray-400 mt-0.5">Kelola dan perbarui status pemesanan alat musik dari pembeli.</p>
        </div>

        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-center gap-2 text-xs">
            <input type="text" 
                   name="search" 
                   value="{{ $search }}" 
                   placeholder="Cari pembeli / produk..." 
                   class="px-3.5 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500">
            
            <select name="status" onchange="this.form.submit()" class="px-3.5 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 font-semibold text-gray-700">
                <option value="">Semua Status</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl border border-orange-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-orange-50/50 text-gray-500 font-bold uppercase tracking-wider border-b border-orange-100">
                        <th class="py-3.5 px-4">ID / Tanggal</th>
                        <th class="py-3.5 px-4">Pembeli</th>
                        <th class="py-3.5 px-4">Produk Alat Musik</th>
                        <th class="py-3.5 px-4">Qty</th>
                        <th class="py-3.5 px-4">Total Harga</th>
                        <th class="py-3.5 px-4">Status Transaksi</th>
                        <th class="py-3.5 px-4 text-right">Aksi Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($orders as $order)
                    <tr class="hover:bg-orange-50/20 transition">
                        <td class="py-3 px-4 font-mono font-bold text-gray-800">
                            #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                            <div class="text-[10px] text-gray-400 font-sans font-normal">{{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}</div>
                        </td>

                        <td class="py-3 px-4">
                            <div class="font-bold text-gray-900">{{ $order->customer_name }}</div>
                            <div class="text-[10px] text-gray-400">{{ $order->customer_phone ?: '-' }}</div>
                        </td>

                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                @if($order->product)
                                    <img src="{{ $order->product->image_url }}" class="w-8 h-8 rounded-lg object-cover border shrink-0">
                                    <span class="font-bold text-gray-800 line-clamp-1 max-w-xs">{{ $order->product->name }}</span>
                                @else
                                    <span class="text-gray-400">Produk telah dihapus</span>
                                @endif
                            </div>
                        </td>

                        <td class="py-3 px-4 font-bold text-gray-800">
                            {{ $order->quantity }} pcs
                        </td>

                        <td class="py-3 px-4 font-extrabold text-orange-600">
                            Rp{{ number_format($order->total_price, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 text-[10px] font-extrabold rounded-full inline-block uppercase tracking-wider
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td class="py-3 px-4 text-right">
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="inline-flex gap-1">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-[11px] p-1.5 border border-gray-200 rounded-lg bg-gray-50 font-bold focus:outline-none">
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-10 text-center text-gray-400">
                            Belum ada transaksi pesanan ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-orange-100">
            {{ $orders->links() }}
        </div>
    </div>

</div>
@endsection

@extends('layouts.admin')

@section('title', 'Dashboard - Proats Admin CMS')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-5">

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-4 border border-orange-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Produk</span>
                <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-box"></i></div>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-900">{{ $totalProducts }}</h3>
            <p class="text-[11px] text-gray-400 mt-0.5">item terdaftar</p>
        </div>

        <div class="bg-white rounded-xl p-4 border border-orange-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Order</span>
                <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-receipt"></i></div>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-900">{{ number_format($totalOrders) }}</h3>
            <p class="text-[11px] text-gray-400 mt-0.5">{{ $pendingOrders }} pending</p>
        </div>

        <div class="bg-white rounded-xl p-4 border border-orange-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Item Terjual</span>
                <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-cart-shopping"></i></div>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-900">{{ number_format($totalItemsSold) }}</h3>
            <p class="text-[11px] text-gray-400 mt-0.5">unit terjual</p>
        </div>

        <div class="bg-white rounded-xl p-4 border border-orange-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Stok Menipis</span>
                <div class="w-8 h-8 bg-red-100 text-red-500 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-triangle-exclamation"></i></div>
            </div>
            <h3 class="text-2xl font-extrabold text-red-600">{{ $lowStockCount }}</h3>
            <p class="text-[11px] text-gray-400 mt-0.5">perlu restock</p>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-400 rounded-xl p-5 text-white flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold text-orange-100 uppercase tracking-wider">Total Revenue (Order Selesai)</p>
            <h3 class="text-2xl font-extrabold mt-1">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-xs text-orange-100 mt-0.5">dari {{ number_format($totalOrders) }} transaksi selesai</p>
        </div>
        <div class="flex gap-2 text-xs font-bold">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-white text-orange-600 rounded-lg hover:bg-orange-50 transition">
                <i class="fas fa-plus mr-1"></i> Tambah Produk
            </a>
            <a href="{{ route('catalog.index') }}" target="_blank" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                <i class="fas fa-eye mr-1"></i> Lihat Katalog
            </a>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Monthly Sales Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-orange-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-800">Penjualan Bulanan (dari tabel orders)</h3>
                <span class="text-[11px] text-gray-400 font-semibold">{{ date('Y') }}</span>
            </div>
            <div style="height: 260px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Category Doughnut -->
        <div class="bg-white rounded-xl border border-orange-100 p-5">
            <h3 class="text-sm font-bold text-gray-800 mb-4">Revenue Per Kategori</h3>
            <div style="height: 260px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        <!-- Top Selling Products (from orders) -->
        <div class="bg-white rounded-xl border border-orange-100 p-5">
            <h3 class="text-sm font-bold text-gray-800 mb-3">Produk Terlaris (dari Order)</h3>
            <div class="space-y-3">
                @foreach($topProducts as $i => $prod)
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 bg-orange-100 text-orange-600 rounded-md flex items-center justify-center text-[11px] font-extrabold shrink-0">{{ $i + 1 }}</span>
                    <img src="{{ $prod->image_url }}" class="w-9 h-9 rounded-lg object-cover border border-gray-100 shrink-0">
                    <div class="flex-grow min-w-0">
                        <p class="text-xs font-bold text-gray-800 truncate">{{ $prod->name }}</p>
                        <p class="text-[10px] text-gray-400">{{ $prod->formatted_price }}</p>
                    </div>
                    <span class="text-[11px] font-bold text-orange-600 shrink-0">{{ number_format($prod->real_sold) }} sold</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-xl border border-orange-100 p-5">
            <h3 class="text-sm font-bold text-gray-800 mb-3">Order Terakhir</h3>
            <div class="space-y-3">
                @foreach($recentOrders as $order)
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center text-xs font-bold shrink-0
                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-600' : ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                        <i class="fas {{ $order->status === 'completed' ? 'fa-check' : ($order->status === 'pending' ? 'fa-clock' : 'fa-xmark') }}"></i>
                    </div>
                    <div class="flex-grow min-w-0">
                        <p class="text-xs font-bold text-gray-800 truncate">{{ $order->customer_name }}</p>
                        <p class="text-[10px] text-gray-400 truncate">{{ $order->product->name ?? '-' }} × {{ $order->quantity }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-[11px] font-bold text-gray-800">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-gray-400">{{ $order->created_at->format('d M') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
    // Monthly Sales - data from orders table
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlySales->pluck('month')) !!},
            datasets: [
                {
                    label: 'Revenue (Juta Rp)',
                    data: {!! json_encode($monthlySales->pluck('revenue')->map(fn($v) => round($v / 1000000, 1))) !!},
                    backgroundColor: 'rgba(249, 115, 22, 0.75)',
                    borderColor: 'rgb(249, 115, 22)',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                    yAxisID: 'y',
                },
                {
                    label: 'Jumlah Order',
                    data: {!! json_encode($monthlySales->pluck('orders')) !!},
                    type: 'line',
                    borderColor: 'rgb(251, 146, 60)',
                    backgroundColor: 'rgba(251, 146, 60, 0.1)',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    labels: { font: { size: 11, weight: '600' }, color: '#6b7280', usePointStyle: true, pointStyleWidth: 8, padding: 16 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    position: 'left',
                    grid: { color: '#f3f4f6' },
                    ticks: { font: { size: 10, weight: '600' }, color: '#9ca3af', callback: v => v + ' jt' }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    grid: { display: false },
                    ticks: { font: { size: 10, weight: '600' }, color: '#9ca3af' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: '600' }, color: '#9ca3af' }
                }
            }
        }
    });

    // Category Revenue Doughnut - data from orders table
    const catCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(catCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryStats->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode($categoryStats->pluck('total_revenue')) !!},
                backgroundColor: ['#f97316', '#fb923c', '#fdba74', '#fed7aa', '#ffedd5'],
                borderWidth: 2,
                borderColor: '#ffffff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 10, weight: '600' }, color: '#6b7280', padding: 10, usePointStyle: true, pointStyleWidth: 8 }
                },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ctx.label + ': Rp' + new Intl.NumberFormat('id-ID').format(ctx.raw);
                        }
                    }
                }
            }
        }
    });
</script>
@endsection

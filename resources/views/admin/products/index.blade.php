@extends('layouts.admin')

@section('title', 'Kelola Produk - Proats Admin CMS')
@section('page_title', 'Kelola Produk Alat Musik')

@section('content')
<div class="space-y-5">

    <!-- Top Action Bar & Filter -->
    <div class="bg-white rounded-2xl p-5 border border-orange-100 shadow-xs flex flex-wrap items-center justify-between gap-4">
        
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-center gap-3 text-xs w-full lg:w-auto">
            <!-- Search -->
            <div class="relative flex-1 min-w-[220px]">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari nama produk alat musik..." 
                       class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 font-medium">
                <i class="fas fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
            </div>

            <!-- Category Filter -->
            <select name="category" onchange="this.form.submit()" class="border border-gray-200 rounded-xl px-3.5 py-2 text-xs font-semibold focus:outline-none focus:border-orange-500 text-gray-700">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition">
                Filter
            </button>
            
            @if(request('search') || request('category'))
                <a href="{{ route('admin.products.index') }}" class="text-xs text-orange-600 hover:underline font-bold">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Produk Baru
        </a>
    </div>

    <!-- Product Table -->
    <div class="bg-white rounded-2xl shadow-xs border border-orange-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-orange-50/50 text-gray-500 font-bold uppercase tracking-wider border-b border-orange-100">
                        <th class="py-3.5 px-4">Info Produk</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Harga Katalog</th>
                        <th class="py-3.5 px-4">Stok</th>
                        <th class="py-3.5 px-4">Rating / Terjual</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($products as $prod)
                    <tr class="hover:bg-orange-50/20 transition">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" class="w-12 h-12 object-cover rounded-xl border border-gray-100 shrink-0">
                                <div>
                                    <h4 class="font-bold text-gray-900 line-clamp-1 max-w-xs">{{ $prod->name }}</h4>
                                    <span class="text-[10px] text-gray-400"><i class="fas fa-location-dot"></i> {{ $prod->location }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 bg-orange-50 text-orange-700 font-semibold rounded-md border border-orange-100">
                                {{ $prod->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-extrabold text-orange-600 text-sm">{{ $prod->formatted_price }}</div>
                            @if($prod->original_price)
                                <div class="text-[10px] text-gray-400 line-through">{{ $prod->formatted_original_price }}</div>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 font-bold rounded text-xs {{ $prod->stock < 15 ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $prod->stock }} unit
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center text-amber-500 font-bold text-xs">
                                <i class="fas fa-star mr-1"></i> {{ $prod->rating }}
                                <span class="text-gray-400 font-normal ml-1.5">({{ number_format($prod->sold_count) }} terjual)</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-right space-x-1">
                            <a href="{{ route('admin.products.edit', $prod->id) }}" class="p-2 bg-gray-100 hover:bg-orange-100 text-gray-600 hover:text-orange-600 rounded-lg transition inline-block" title="Edit">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $prod->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 rounded-lg transition" title="Hapus">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400">
                            Tidak ada produk ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-orange-100">
            {{ $products->links() }}
        </div>
    </div>

</div>
@endsection

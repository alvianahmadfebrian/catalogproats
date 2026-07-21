@extends('layouts.admin')

@section('title', 'Ulasan & Rating User - Proats Admin CMS')
@section('page_title', 'Kelola Ulasan & Rating Bintang')

@section('content')
<div class="space-y-5">

    <!-- Overview Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-orange-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Ulasan</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ number_format($totalReviews) }}</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">ulasan tersimpan</p>
            </div>
            <div class="w-10 h-10 bg-orange-100 text-orange-500 rounded-xl flex items-center justify-center text-lg">
                <i class="fas fa-comments"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-orange-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Rata-rata Rating Toko</p>
                <h3 class="text-2xl font-extrabold text-amber-500 mt-1 flex items-center gap-1">
                    <i class="fas fa-star text-xl"></i> {{ $avgSystemRating }}
                </h3>
                <p class="text-[11px] text-gray-400 mt-0.5">dari 5.0 bintang</p>
            </div>
            <div class="w-10 h-10 bg-amber-100 text-amber-500 rounded-xl flex items-center justify-center text-lg">
                <i class="fas fa-star-half-stroke"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-orange-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Modul Rating</p>
                <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">Aktif</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">user dapat memberi ulasan</p>
            </div>
            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-lg">
                <i class="fas fa-circle-check"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl p-5 border border-orange-100 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-extrabold text-gray-900">Daftar Ulasan & Rating Pembeli</h3>
            <p class="text-xs text-gray-400 mt-0.5">Pantau masukan pelanggan dan kelola ulasan bintang pada produk.</p>
        </div>

        <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex flex-wrap items-center gap-2 text-xs">
            <div class="relative">
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Cari ulasan / pembeli / produk..." 
                       class="pl-9 pr-3 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 w-64">
                <i class="fas fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
            </div>

            <select name="rating" onchange="this.form.submit()" class="px-3.5 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 font-semibold text-gray-700">
                <option value="">Semua Bintang</option>
                <option value="5" {{ $rating == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                <option value="4" {{ $rating == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Bintang)</option>
                <option value="3" {{ $rating == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 Bintang)</option>
                <option value="2" {{ $rating == '2' ? 'selected' : '' }}>⭐⭐ (2 Bintang)</option>
                <option value="1" {{ $rating == '1' ? 'selected' : '' }}>⭐ (1 Bintang)</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white rounded-2xl border border-orange-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-orange-50/50 text-gray-500 font-bold uppercase tracking-wider border-b border-orange-100">
                        <th class="py-3.5 px-4">Pembeli</th>
                        <th class="py-3.5 px-4">Produk Alat Musik</th>
                        <th class="py-3.5 px-4">Rating Bintang</th>
                        <th class="py-3.5 px-4">Ulasan Komentar</th>
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($reviews as $rev)
                    <tr class="hover:bg-orange-50/20 transition">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $rev->user->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" class="w-9 h-9 rounded-full object-cover border border-gray-200 shrink-0">
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $rev->user->name ?? 'Pembeli Proats' }}</h4>
                                    <span class="text-[10px] text-gray-400">{{ $rev->user->email ?? '-' }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-2">
                                @if($rev->product)
                                    <img src="{{ $rev->product->image_url }}" class="w-8 h-8 rounded-lg object-cover border shrink-0">
                                    <span class="font-bold text-gray-800 line-clamp-1 max-w-xs">{{ $rev->product->name }}</span>
                                @else
                                    <span class="text-gray-400">Produk dihapus</span>
                                @endif
                            </div>
                        </td>

                        <td class="py-3.5 px-4">
                            <div class="flex items-center text-amber-500 font-bold gap-1 text-sm">
                                <i class="fas fa-star"></i>
                                <span>{{ $rev->rating }}.0</span>
                            </div>
                        </td>

                        <td class="py-3.5 px-4">
                            <p class="text-gray-700 italic max-w-md line-clamp-2">"{{ $rev->comment ?: 'Tidak menulis komentar.' }}"</p>
                        </td>

                        <td class="py-3.5 px-4 text-gray-400 font-mono text-[11px]">
                            {{ $rev->created_at ? $rev->created_at->format('d M Y H:i') : '-' }}
                        </td>

                        <td class="py-3.5 px-4 text-right">
                            <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus ulasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 rounded-lg transition" title="Hapus Ulasan">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-400">
                            Belum ada ulasan bintang dari pelanggan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-orange-100">
            {{ $reviews->links() }}
        </div>
    </div>

</div>
@endsection

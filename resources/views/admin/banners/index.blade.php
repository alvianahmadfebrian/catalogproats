@extends('layouts.admin')

@section('title', 'Kelola Banner Slider - Proats Admin CMS')
@section('page_title', 'Kelola Banner & Hero Slider')

@section('content')
<div class="space-y-6">

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-2xl text-xs font-semibold flex items-center justify-between border border-emerald-200 shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-circle-check text-emerald-500 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Action Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-amber-100 shadow-xs">
        <div>
            <h2 class="font-extrabold text-base text-gray-900">Slider Hero Banner</h2>
            <p class="text-xs text-gray-500">Kelola gambar, judul, dan promo banner auto-slide yang tampil di halaman katalog utama.</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Slide Banner Baru
        </a>
    </div>

    <!-- Banner Cards Grid / Table -->
    <div class="bg-white rounded-2xl shadow-xs border border-amber-100 overflow-hidden">
        <div class="p-4 border-b border-amber-100 flex items-center justify-between">
            <h3 class="font-extrabold text-sm text-gray-900">Daftar Banner Slide ({{ $banners->count() }})</h3>
            <span class="text-xs text-amber-700 font-bold bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                Auto-Slide Aktif (5s)
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-amber-50/50 text-gray-500 font-bold uppercase tracking-wider border-b border-amber-100">
                        <th class="py-3 px-4 w-12 text-center">Urutan</th>
                        <th class="py-3 px-4">Preview & Detail Banner</th>
                        <th class="py-3 px-4">Tombol CTA</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    @forelse($banners as $banner)
                    <tr class="hover:bg-amber-50/20 transition">
                        <td class="py-3 px-4 text-center font-extrabold text-amber-700">
                            <span class="w-7 h-7 inline-flex items-center justify-center bg-amber-100 text-amber-900 rounded-lg">
                                #{{ $banner->order }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-start gap-4">
                                @if($banner->image_url)
                                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="w-32 h-16 object-cover rounded-xl border border-gray-200 shadow-xs shrink-0 bg-gray-100">
                                @else
                                    <div class="w-32 h-16 rounded-xl bg-gradient-to-r from-{{ $banner->bg_color_from ?? 'amber-400' }} to-{{ $banner->bg_color_to ?? 'amber-300' }} flex items-center justify-center text-slate-950 font-bold text-xs p-2 text-center border border-amber-300 shrink-0">
                                        <i class="fas fa-image text-amber-800/40 text-xl mr-1"></i> Styled Banner
                                    </div>
                                @endif
                                <div>
                                    @if($banner->badge_text)
                                        <span class="inline-block px-2 py-0.5 bg-slate-900 text-amber-300 font-extrabold text-[10px] uppercase tracking-wider rounded-md mb-1">
                                            {{ $banner->badge_text }}
                                        </span>
                                    @endif
                                    <h4 class="font-extrabold text-sm text-gray-900 leading-tight mb-1">{{ $banner->title }}</h4>
                                    <p class="text-[11px] text-gray-500 line-clamp-1 max-w-md">{{ $banner->subtitle ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            @if($banner->button_text)
                                <div class="space-y-1">
                                    <span class="px-2.5 py-1 bg-slate-900 text-amber-300 font-bold rounded-lg text-[11px] inline-flex items-center gap-1">
                                        <i class="fas fa-link text-[10px]"></i> {{ $banner->button_text }}
                                    </span>
                                    <p class="text-[10px] text-gray-400 truncate max-w-[150px]">{{ $banner->button_url ?? '#' }}</p>
                                </div>
                            @else
                                <span class="text-gray-400 text-[11px] italic">Tanpa Tombol</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('admin.banners.toggle', $banner->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold transition {{ $banner->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-300 hover:bg-emerald-200' : 'bg-gray-100 text-gray-500 border border-gray-300 hover:bg-gray-200' }}" title="Klik untuk menguji status">
                                    <i class="fas fa-circle text-[8px] {{ $banner->is_active ? 'text-emerald-500' : 'text-gray-400' }}"></i>
                                    {{ $banner->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-4 text-right space-x-1.5 whitespace-nowrap">
                            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-xl transition inline-flex items-center gap-1 font-bold text-xs" title="Edit Banner">
                                <i class="fas fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slide banner ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition inline-flex items-center gap-1 font-bold text-xs" title="Hapus Banner">
                                    <i class="fas fa-trash-can"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400">
                            <i class="fas fa-images text-4xl mb-2 text-gray-300 block"></i>
                            <p class="font-semibold text-xs">Belum ada slide banner.</p>
                            <a href="{{ route('admin.banners.create') }}" class="text-amber-600 font-bold hover:underline text-xs mt-1 inline-block">+ Tambah Slide Pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

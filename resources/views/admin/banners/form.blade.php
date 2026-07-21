@extends('layouts.admin')

@section('title', ($isEdit ? 'Edit Banner Slide' : 'Tambah Banner Slide') . ' - Proats Admin CMS')
@section('page_title', $isEdit ? 'Edit Banner Slide' : 'Tambah Banner Slide Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.banners.index') }}" class="text-xs font-bold text-gray-500 hover:text-amber-700 transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Banner
        </a>
    </div>

    <!-- Banner Form Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-amber-100 p-6 md:p-8">
        <h2 class="font-extrabold text-base text-gray-900 border-b border-amber-100 pb-4 mb-6 flex items-center gap-2">
            <i class="fas fa-sliders text-amber-600"></i>
            {{ $isEdit ? 'Form Edit Banner Slide #' . $banner->id : 'Form Tambah Banner Slide Baru' }}
        </h2>

        @if($errors->any())
            <div class="bg-red-50 text-red-800 p-4 rounded-xl text-xs font-semibold border border-red-200 mb-6">
                <p class="font-bold mb-1"><i class="fas fa-exclamation-triangle mr-1"></i> Terjadi kesalahan input:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $isEdit ? route('admin.banners.update', $banner->id) : route('admin.banners.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-6">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Title & Badge -->
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Teks Badge Promo <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="text" 
                               name="badge_text" 
                               value="{{ old('badge_text', $banner->badge_text) }}" 
                               placeholder="Contoh: PROMO EKSKLUSIF ALAT MUSIK" 
                               class="w-full p-3 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Judul Utama Banner <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               value="{{ old('title', $banner->title) }}" 
                               required 
                               placeholder="Contoh: Pusat Alat Musik Marching Band, Tradisional & Band" 
                               class="w-full p-3 border border-gray-200 rounded-xl text-xs font-bold text-gray-900 focus:outline-none focus:border-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Deskripsi Subtitle Promo <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea name="subtitle" 
                                  rows="3" 
                                  placeholder="Contoh: Melayani pemesanan drumband, marching band HTS, instrumen etnik tradisional..." 
                                  class="w-full p-3 border border-gray-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">{{ old('subtitle', $banner->subtitle) }}</textarea>
                    </div>
                </div>

                <!-- Button Text & Link -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Teks Tombol Aksi (CTA) <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="text" 
                           name="button_text" 
                           value="{{ old('button_text', $banner->button_text) }}" 
                           placeholder="Contoh: Jelajahi Instrumen" 
                           class="w-full p-3 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        URL Tujuan Tombol <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="text" 
                           name="button_url" 
                           value="{{ old('button_url', $banner->button_url ?? '#catalog-section') }}" 
                           placeholder="Contoh: #catalog-section atau https://..." 
                           class="w-full p-3 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-amber-500">
                </div>

                <!-- Banner Image Upload & Image URL -->
                <div class="md:col-span-2 space-y-3 bg-amber-50/40 p-4 rounded-2xl border border-amber-100">
                    <label class="block text-xs font-extrabold text-amber-900 uppercase tracking-wider">
                        Gambar / Foto Banner Slide
                    </label>
                    <p class="text-[11px] text-gray-500">Opsional: Jika foto diunggah, banner akan menampilkan foto secara penuh atau sebagai latar belakang slide.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1">Upload File Foto Banner</label>
                            <input type="file" 
                                   name="image_file" 
                                   accept="image/*"
                                   class="w-full p-2 bg-white border border-gray-200 rounded-xl text-xs text-gray-600 focus:outline-none focus:border-amber-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1">Atau Gunakan Link / URL Gambar</label>
                            <input type="url" 
                                   name="image_url" 
                                   value="{{ old('image_url', $banner->image_url) }}" 
                                   placeholder="https://images.unsplash.com/photo-..." 
                                   class="w-full p-2.5 bg-white border border-gray-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                        </div>
                    </div>

                    @if($banner->image_url)
                        <div class="pt-2">
                            <span class="text-[11px] font-bold text-gray-600 block mb-1">Preview Gambar Saat Ini:</span>
                            <img src="{{ $banner->image_url }}" alt="Preview Banner" class="h-28 w-auto object-cover rounded-xl border border-amber-200 shadow-xs">
                        </div>
                    @endif
                </div>

                <!-- Order & Active Status -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Urutan Tampil (Order) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="order" 
                           value="{{ old('order', $banner->order ?? 1) }}" 
                           min="0" 
                           required 
                           class="w-full p-3 border border-gray-200 rounded-xl text-xs font-bold focus:outline-none focus:border-amber-500">
                    <p class="text-[10px] text-gray-400 mt-1">Angka lebih kecil akan tampil lebih awal di slide (contoh: 1, 2, 3...)</p>
                </div>

                <div class="flex items-center gap-3 pt-6">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1" 
                           {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }} 
                           class="w-5 h-5 text-amber-600 rounded border-gray-300 focus:ring-amber-500">
                    <label for="is_active" class="text-xs font-bold text-gray-800 cursor-pointer">
                        Aktifkan Slide ini di Halaman Utama Catalog
                    </label>
                </div>

            </div>

            <!-- Submit Buttons -->
            <div class="border-t border-amber-100 pt-6 flex items-center justify-end gap-3">
                <a href="{{ route('admin.banners.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition flex items-center gap-2">
                    <i class="fas fa-floppy-disk"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Banner Slide' }}
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

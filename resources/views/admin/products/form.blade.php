@extends('layouts.admin')

@section('title', $isEdit ? 'Edit Produk - Proats Admin' : 'Tambah Produk Baru - Proats Admin')
@section('page_title', $isEdit ? 'Edit Produk: ' . $product->name : 'Tambah Produk Alat Musik Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-gray-500 hover:text-orange-600 flex items-center gap-1.5 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
        </a>
    </div>

    <form action="{{ $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store') }}" 
          method="POST" 
          enctype="multipart/form-data"
          x-data="{ 
              imageUrl: '{{ old('image_url', $product->image_url) }}',
              handleFileChange(e) {
                  const file = e.target.files[0];
                  if (file) {
                      this.imageUrl = URL.createObjectURL(file);
                  }
              }
          }"
          class="bg-white rounded-2xl shadow-xs border border-orange-100 p-6 md:p-8 space-y-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Left Side: Image Preview & URL -->
            <div class="space-y-4">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Foto Produk</label>
                <div class="aspect-square rounded-2xl border-2 border-dashed border-orange-200 bg-orange-50/40 overflow-hidden flex items-center justify-center relative group">
                    <template x-if="imageUrl">
                        <img :src="imageUrl" alt="Preview" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!imageUrl">
                        <div class="text-center p-4 text-gray-400">
                            <i class="fas fa-image text-4xl mb-2 text-orange-200"></i>
                            <p class="text-xs font-semibold">Preview foto produk akan muncul di sini</p>
                        </div>
                    </template>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Unggah Foto Produk</label>
                    <input type="file" 
                           name="image_file" 
                           accept="image/*"
                           @change="handleFileChange($event)"
                           {{ !$product->image_url ? 'required' : '' }}
                           class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-orange-500 font-medium file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                    <p class="text-[10px] text-gray-400 mt-1">Pilih file gambar instrumen (.jpg, .png, .jpeg, .webp, maks 2MB).</p>
                </div>
            </div>

            <!-- Right Side: Form Fields -->
            <div class="md:col-span-2 space-y-4">
                
                <!-- Product Name -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Produk Alat Musik</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $product->name) }}" 
                           required 
                           placeholder="Contoh: Snare Drum Marching Band HTS Premium" 
                           class="w-full p-3 border border-gray-200 rounded-xl text-sm font-semibold focus:outline-none focus:border-orange-500">
                </div>

                <!-- Category & Location -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" required class="w-full p-2.5 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-orange-500">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Lokasi Toko / Gudang</label>
                        <input type="text" 
                               name="location" 
                               value="{{ old('location', $product->location ?? 'Bandung') }}" 
                               required 
                               placeholder="Contoh: Bandung, Jakarta" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-orange-500">
                    </div>
                </div>

                <!-- Price & Discount -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Harga Jual (Rp)</label>
                        <input type="number" 
                               name="price" 
                               value="{{ old('price', $product->price) }}" 
                               required 
                               placeholder="3500000" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs font-extrabold text-orange-600 focus:outline-none focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Harga Coret (Rp)</label>
                        <input type="number" 
                               name="original_price" 
                               value="{{ old('original_price', $product->original_price) }}" 
                               placeholder="4200000" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Persen Diskon (%)</label>
                        <input type="number" 
                               name="discount_percent" 
                               value="{{ old('discount_percent', $product->discount_percent ?? 0) }}" 
                               min="0" max="100"
                               placeholder="15" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-orange-500">
                    </div>
                </div>

                <!-- Stock & Rating -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jumlah Stok</label>
                        <input type="number" 
                               name="stock" 
                               value="{{ old('stock', $product->stock ?? 50) }}" 
                               required 
                               placeholder="50" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-orange-500 font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Rating (1.0 - 5.0)</label>
                        <input type="number" 
                               step="0.1" 
                               name="rating" 
                               value="{{ old('rating', $product->rating ?? 4.9) }}" 
                               required 
                               placeholder="4.9" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-orange-500">
                    </div>
                </div>

                <!-- Variants Input -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Varian Produk (Pisahkan dengan koma)</label>
                    <input type="text" 
                           name="variants_input" 
                           value="{{ old('variants_input', is_array($product->variants) ? implode(', ', $product->variants) : '') }}" 
                           placeholder="Contoh: Ukuran 14 inch, Ukuran 13 inch, Warna Red Chrome" 
                           class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-orange-500">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Lengkap Produk</label>
                    <textarea name="description" rows="4" placeholder="Tuliskan keunggulan instrumen, spesifikasi bahan, dan garansi..." class="w-full p-3 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-orange-500">{{ old('description', $product->description) }}</textarea>
                </div>

            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="border-t border-orange-100 pt-5 flex items-center justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-2">
                <i class="fas fa-floppy-disk"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Produk Sekarang' }}
            </button>
        </div>

    </form>

</div>
@endsection

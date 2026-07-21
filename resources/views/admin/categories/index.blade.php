@extends('layouts.admin')

@section('title', 'Kelola Kategori - Proats Admin CMS')
@section('page_title', 'Kelola Kategori Alat Musik')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ editMode: false, formId: null, formName: '', formIcon: '' }">

    <!-- Category Form (Create / Edit) -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl p-6 border border-orange-100 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-orange-100 pb-3">
                <h3 class="font-extrabold text-sm text-gray-900" x-text="editMode ? 'Edit Kategori' : 'Tambah Kategori Baru'"></h3>
                <button x-show="editMode" @click="editMode = false; formId = null; formName = ''; formIcon = ''" class="text-xs text-orange-600 font-bold hover:underline">
                    + Tambah Baru
                </button>
            </div>

            <form :action="editMode ? '/cms-admin/categories/' + formId : '{{ route('admin.categories.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Kategori</label>
                    <input type="text" 
                           name="name" 
                           x-model="formName" 
                           required 
                           placeholder="Contoh: Marching Band" 
                           class="w-full p-2.5 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-orange-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kode Icon (FontAwesome)</label>
                    <input type="text" 
                           name="icon" 
                           x-model="formIcon" 
                           placeholder="drum, music, guitar, trumpet" 
                           class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-orange-500">
                    <p class="text-[10px] text-gray-400 mt-1">Nama ikon FontAwesome (contoh: drum, guitar, music).</p>
                </div>

                <button type="submit" class="w-full py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2">
                    <i class="fas fa-floppy-disk"></i> <span x-text="editMode ? 'Perbarui Kategori' : 'Simpan Kategori'"></span>
                </button>
            </form>
        </div>
    </div>

    <!-- Category Table -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-xs border border-orange-100 overflow-hidden">
            <div class="p-4 border-b border-orange-100 flex items-center justify-between">
                <h3 class="font-extrabold text-sm text-gray-900">Daftar Kategori Katalog</h3>
                <span class="text-xs text-orange-600 font-bold bg-orange-50 px-2.5 py-1 rounded-full border border-orange-100">{{ $categories->count() }} Kategori</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-orange-50/50 text-gray-500 font-bold uppercase tracking-wider border-b border-orange-100">
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Slug</th>
                            <th class="py-3 px-4">Jumlah Produk</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        @foreach($categories as $cat)
                        <tr class="hover:bg-orange-50/20 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3 font-bold text-gray-900">
                                    <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-sm">
                                        <i class="fas fa-{{ $cat->icon ?? 'tag' }}"></i>
                                    </div>
                                    <span>{{ $cat->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 font-mono text-gray-400 text-[11px]">
                                {{ $cat->slug }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 bg-orange-50 text-orange-700 font-bold rounded-md border border-orange-100">
                                    {{ $cat->products_count }} Produk
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right space-x-1">
                                <button @click="editMode = true; formId = {{ $cat->id }}; formName = '{{ addslashes($cat->name) }}'; formIcon = '{{ $cat->icon }}'" 
                                        class="p-1.5 bg-gray-100 hover:bg-orange-100 text-gray-600 hover:text-orange-600 rounded-md transition" 
                                        title="Edit Kategori">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kategori ini beserta produk di dalamnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 rounded-md transition" title="Hapus Kategori">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@extends('layouts.admin')

@section('title', 'Pengaturan Sistem - Proats Admin CMS')
@section('page_title', 'Pengaturan Keseluruhan Sistem')

@section('content')
<div x-data="{ activeTab: 'store' }" class="space-y-6">

    <!-- Page Header & Title Card -->
    <div class="bg-white rounded-2xl p-6 border border-orange-100 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="bg-orange-100 text-orange-600 text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-0.5 rounded-full">System Configuration</span>
            </div>
            <h1 class="text-xl font-extrabold text-gray-900">Pengaturan Keseluruhan Toko & CMS</h1>
            <p class="text-xs text-gray-500 mt-1">Atur identitas brand, informasi kontak, running banner pengumuman, modul fitur, dan akun master admin.</p>
        </div>

        <button type="submit" form="settingsForm" class="px-5 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center gap-2">
            <i class="fas fa-floppy-disk"></i> Simpan Semua Pengaturan
        </button>
    </div>

    <!-- Main Settings Layout (Left Sub-Sidebar & Right Content) -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <!-- Sub-Sidebar Navigation -->
        <div class="lg:col-span-1 bg-white rounded-2xl border border-orange-100 p-3 shadow-xs space-y-1 h-fit">
            <div class="px-3 py-2 text-[11px] font-extrabold text-gray-400 uppercase tracking-wider">
                Kategori Pengaturan
            </div>

            <button @click="activeTab = 'store'" 
                    :class="activeTab === 'store' ? 'bg-orange-500 text-white font-bold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600 font-semibold'"
                    class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs transition">
                <i class="fas fa-store w-5 text-center"></i> Profil Toko & Kontak
            </button>

            <button @click="activeTab = 'appearance'" 
                    :class="activeTab === 'appearance' ? 'bg-orange-500 text-white font-bold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600 font-semibold'"
                    class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs transition">
                <i class="fas fa-images w-5 text-center"></i> Banner & Pengumuman
            </button>

            <button @click="activeTab = 'features'" 
                    :class="activeTab === 'features' ? 'bg-orange-500 text-white font-bold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600 font-semibold'"
                    class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs transition">
                <i class="fas fa-sliders w-5 text-center"></i> Fitur & Modul Sistem
            </button>

            <button @click="activeTab = 'social'" 
                    :class="activeTab === 'social' ? 'bg-orange-500 text-white font-bold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600 font-semibold'"
                    class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs transition">
                <i class="fas fa-share-nodes w-5 text-center"></i> Media Sosial
            </button>

            <button @click="activeTab = 'account'" 
                    :class="activeTab === 'account' ? 'bg-orange-500 text-white font-bold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600 font-semibold'"
                    class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs transition">
                <i class="fas fa-user-shield w-5 text-center"></i> Akun Master Admin
            </button>
        </div>

        <!-- Right Content Forms Container -->
        <div class="lg:col-span-3">
            <form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Section 1: Store Info & Contact -->
                <div x-show="activeTab === 'store'" x-cloak class="bg-white rounded-2xl border border-orange-100 p-6 shadow-xs space-y-5">
                    <div class="border-b border-orange-100 pb-3 flex items-center gap-2">
                        <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">Profil Toko & Informasi Kontak</h3>
                            <p class="text-[11px] text-gray-400">Pengaturan nama merek, deskripsi, WhatsApp, email, dan alamat fisik toko.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Toko / E-Catalog</label>
                            <input type="text" name="store_name" value="{{ old('store_name', $settings['store_name']) }}" required class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Tagline Toko</label>
                            <input type="text" name="store_tagline" value="{{ old('store_tagline', $settings['store_tagline']) }}" required class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nomor WhatsApp CS</label>
                            <input type="text" name="store_phone" value="{{ old('store_phone', $settings['store_phone']) }}" required class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Email Layanan Pelanggan</label>
                            <input type="email" name="store_email" value="{{ old('store_email', $settings['store_email']) }}" required class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="text-xs">
                        <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Jam Operasional Toko</label>
                        <input type="text" name="store_hours" value="{{ old('store_hours', $settings['store_hours']) }}" required class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                    </div>

                    <div class="text-xs">
                        <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Fisik Toko</label>
                        <textarea name="store_address" rows="3" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">{{ old('store_address', $settings['store_address']) }}</textarea>
                    </div>
                </div>

                <!-- Section 2: Announcement Bar & Texts -->
                <div x-show="activeTab === 'appearance'" x-cloak class="bg-white rounded-2xl border border-orange-100 p-6 shadow-xs space-y-6">
                    <div class="border-b border-orange-100 pb-3 flex items-center gap-2">
                        <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">Running Text Pengumuman</h3>
                            <p class="text-[11px] text-gray-400">Pengaturan baris running text promo di bagian paling atas halaman katalog.</p>
                        </div>
                    </div>

                    <div class="text-xs space-y-3">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Teks Running Announcement Bar (Atas Header)</label>
                            <input type="text" name="announcement_bar" value="{{ old('announcement_bar', $settings['announcement_bar']) }}" required class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                            <p class="text-[10px] text-gray-400 mt-1">Teks ini akan muncul di bar running bagian paling atas situs katalog publik.</p>
                        </div>
                    </div>

                    <!-- Banner Samping Kanan (Shopee-style Promos) -->
                    <div class="border-t border-orange-100 pt-6 space-y-5">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center text-sm font-bold">
                                <i class="fas fa-images"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-gray-900">Pengaturan 2 Banner Samping Kanan</h3>
                                <p class="text-[11px] text-gray-400">Atur konten teks, gambar, dan tujuan link dari 2 banner di sebelah kanan slider utama.</p>
                            </div>
                        </div>

                        <!-- Banner Samping 1 (Top) -->
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200 space-y-4 text-xs font-semibold">
                            <h4 class="font-extrabold text-orange-600 text-xs flex items-center gap-1">
                                <span class="bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-[10px]">BANNER 1</span> Atas / Kiri
                            </h4>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Teks Badge (Kecil)</label>
                                    <input type="text" name="promo_banner_1_badge" value="{{ old('promo_banner_1_badge', $settings['promo_banner_1_badge']) }}" class="w-full p-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Judul Banner (Besar)</label>
                                    <input type="text" name="promo_banner_1_title" value="{{ old('promo_banner_1_title', $settings['promo_banner_1_title']) }}" class="w-full p-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi / Subtitle</label>
                                    <input type="text" name="promo_banner_1_subtitle" value="{{ old('promo_banner_1_subtitle', $settings['promo_banner_1_subtitle']) }}" class="w-full p-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Tautan / Link Klik</label>
                                    <input type="text" name="promo_banner_1_link" value="{{ old('promo_banner_1_link', $settings['promo_banner_1_link']) }}" placeholder="Contoh: ?category=marching-band-drumband" class="w-full p-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                                <div>
                                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Unggah Gambar Latar (Foto)</label>
                                    <input type="file" name="promo_banner_1_file" accept="image/*" class="w-full p-2 bg-white border border-gray-200 rounded-xl">
                                </div>
                                @if($settings['promo_banner_1_image'])
                                    <div>
                                        <span class="block text-[10px] text-gray-500 mb-1">Preview Gambar Saat Ini:</span>
                                        <img src="{{ $settings['promo_banner_1_image'] }}" alt="Banner 1" class="h-14 w-auto rounded-lg object-cover border border-gray-300">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Banner Samping 2 (Bottom) -->
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200 space-y-4 text-xs font-semibold">
                            <h4 class="font-extrabold text-orange-600 text-xs flex items-center gap-1">
                                <span class="bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-[10px]">BANNER 2</span> Bawah / Kanan
                            </h4>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Teks Badge (Kecil)</label>
                                    <input type="text" name="promo_banner_2_badge" value="{{ old('promo_banner_2_badge', $settings['promo_banner_2_badge']) }}" class="w-full p-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Judul Banner (Besar)</label>
                                    <input type="text" name="promo_banner_2_title" value="{{ old('promo_banner_2_title', $settings['promo_banner_2_title']) }}" class="w-full p-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi / Subtitle</label>
                                    <input type="text" name="promo_banner_2_subtitle" value="{{ old('promo_banner_2_subtitle', $settings['promo_banner_2_subtitle']) }}" class="w-full p-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Tautan / Link Klik</label>
                                    <input type="text" name="promo_banner_2_link" value="{{ old('promo_banner_2_link', $settings['promo_banner_2_link']) }}" placeholder="Contoh: ?category=alat-musik-band" class="w-full p-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                                <div>
                                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Unggah Gambar Latar (Foto)</label>
                                    <input type="file" name="promo_banner_2_file" accept="image/*" class="w-full p-2 bg-white border border-gray-200 rounded-xl">
                                </div>
                                @if($settings['promo_banner_2_image'])
                                    <div>
                                        <span class="block text-[10px] text-gray-500 mb-1">Preview Gambar Saat Ini:</span>
                                        <img src="{{ $settings['promo_banner_2_image'] }}" alt="Banner 2" class="h-14 w-auto rounded-lg object-cover border border-gray-300">
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Section 3: Feature Toggles -->
                <div x-show="activeTab === 'features'" x-cloak class="bg-white rounded-2xl border border-orange-100 p-6 shadow-xs space-y-5">
                    <div class="border-b border-orange-100 pb-3 flex items-center gap-2">
                        <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-sliders"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">Fitur & Modul Sistem</h3>
                            <p class="text-[11px] text-gray-400">Aktifkan atau nonaktifkan fitur live chat, sistem checkout, dan mode perawatan.</p>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs font-semibold">
                        <label class="flex items-center justify-between p-4 bg-orange-50/50 rounded-xl border border-orange-100 cursor-pointer">
                            <div>
                                <h4 class="font-extrabold text-gray-900">Modul Live Chat Pelanggan</h4>
                                <p class="text-[11px] text-gray-500 font-normal">Izinkan pengguna yang sudah login mengirim pesan chat ke admin.</p>
                            </div>
                            <input type="checkbox" name="enable_chat" value="1" {{ $settings['enable_chat'] == '1' ? 'checked' : '' }} class="w-5 h-5 rounded text-orange-500 focus:ring-orange-400">
                        </label>

                        <label class="flex items-center justify-between p-4 bg-orange-50/50 rounded-xl border border-orange-100 cursor-pointer">
                            <div>
                                <h4 class="font-extrabold text-gray-900">Sistem Keranjang & Checkout WhatsApp</h4>
                                <p class="text-[11px] text-gray-500 font-normal">Tampilkan tombol Tambah Ke Keranjang dan fitur checkout pesanan.</p>
                            </div>
                            <input type="checkbox" name="enable_cart" value="1" {{ $settings['enable_cart'] == '1' ? 'checked' : '' }} class="w-5 h-5 rounded text-orange-500 focus:ring-orange-400">
                        </label>

                        <label class="flex items-center justify-between p-4 bg-red-50/50 rounded-xl border border-red-100 cursor-pointer">
                            <div>
                                <h4 class="font-extrabold text-red-900">Mode Perawatan (Maintenance Mode)</h4>
                                <p class="text-[11px] text-red-700 font-normal">Tampilkan pemberitahuan pemeliharaan di situs publik.</p>
                            </div>
                            <input type="checkbox" name="maintenance_mode" value="1" {{ $settings['maintenance_mode'] == '1' ? 'checked' : '' }} class="w-5 h-5 rounded text-red-500 focus:ring-red-400">
                        </label>
                    </div>
                </div>

                <!-- Section 5: Social Media Links -->
                <div x-show="activeTab === 'social'" x-cloak class="bg-white rounded-2xl border border-orange-100 p-6 shadow-xs space-y-5">
                    <div class="border-b border-orange-100 pb-3 flex items-center gap-2">
                        <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-share-nodes"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">Tautan Media Sosial</h3>
                            <p class="text-[11px] text-gray-400">Atur tautan profil akun Facebook, Instagram, dan TikTok toko Anda.</p>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs font-semibold">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Link Facebook Profile</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-3.5 text-gray-400 text-sm">
                                    <i class="fab fa-facebook"></i>
                                </span>
                                <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}" placeholder="https://www.facebook.com/..." class="w-full pl-9 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Link Instagram Profile</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-3.5 text-gray-400 text-sm">
                                    <i class="fab fa-instagram"></i>
                                </span>
                                <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" placeholder="https://www.instagram.com/..." class="w-full pl-9 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Link TikTok Profile</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-3.5 text-gray-400 text-sm">
                                    <i class="fab fa-tiktok"></i>
                                </span>
                                <input type="url" name="social_tiktok" value="{{ old('social_tiktok', $settings['social_tiktok'] ?? '') }}" placeholder="https://www.tiktok.com/@..." class="w-full pl-9 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Master Admin Credentials -->
                <div x-show="activeTab === 'account'" x-cloak class="bg-white rounded-2xl border border-orange-100 p-6 shadow-xs space-y-5">
                    <div class="border-b border-orange-100 pb-3 flex items-center gap-2">
                        <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">Akun Master Admin CMS</h3>
                            <p class="text-[11px] text-gray-400">Perbarui username dan password login untuk masuk ke panel CMS Admin.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Username Admin Login</label>
                            <input type="text" name="admin_username" value="{{ old('admin_username', $admin->username) }}" required class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none font-bold">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Email Master Admin</label>
                            <input type="email" value="{{ $admin->email }}" disabled class="w-full p-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Password Baru (Biarkan kosong jika tak diubah)</label>
                            <input type="password" name="admin_password" placeholder="••••••••" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Konfirmasi Password Baru</label>
                            <input type="password" name="admin_password_confirmation" placeholder="••••••••" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none">
                        </div>
                    </div>
                </div>

                <div class="pt-2 text-right">
                    <button type="submit" class="px-6 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs rounded-xl shadow-md transition inline-flex items-center gap-2">
                        <i class="fas fa-floppy-disk"></i> Simpan Perubahan Pengaturan
                    </button>
                </div>

            </form>
        </div>

    </div>

</div>
@endsection

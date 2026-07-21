@extends('layouts.app')

@section('title', 'Pengaturan Profil - Proats E-Catalog')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 my-4" x-data="userProfileApp()">

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-2xl text-xs font-semibold flex items-center justify-between border border-emerald-200 shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-circle-check text-emerald-500 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="bg-red-50 text-red-800 p-4 rounded-2xl text-xs font-semibold border border-red-200 shadow-xs">
            <div class="flex items-center gap-2 mb-1.5 font-bold">
                <i class="fas fa-circle-exclamation text-red-500 text-base"></i>
                <span>Terjadi kesalahan input:</span>
            </div>
            <ul class="list-disc list-inside text-red-700 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Overview Card -->
    <div class="bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-400 rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-6">
            <img :src="selectedAvatar" 
                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80'"
                 alt="{{ $user->name }}" 
                 class="w-24 h-24 rounded-full object-cover border-4 border-white/40 shadow-md shrink-0">
            
            <div class="text-center sm:text-left space-y-1.5 flex-1">
                <div class="flex items-center justify-center sm:justify-start gap-2">
                    <h1 class="text-2xl font-black text-slate-950 tracking-tight">{{ $user->name }}</h1>
                    <span class="bg-slate-900 text-amber-300 text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full shadow-xs">
                        Member Proats
                    </span>
                </div>
                <p class="text-xs text-slate-900 font-semibold flex items-center justify-center sm:justify-start gap-2">
                    <span><i class="fas fa-envelope"></i> {{ $user->email }}</span>
                    @if($user->phone)
                        <span>&bull;</span>
                        <span><i class="fas fa-phone"></i> {{ $user->phone }}</span>
                    @endif
                </p>
                <p class="text-[11px] text-slate-800 font-medium">
                    Bergabung sejak {{ $user->created_at ? $user->created_at->format('d M Y') : '2026' }}
                </p>
            </div>
        </div>

        <div class="absolute -right-8 -bottom-8 opacity-15 pointer-events-none text-slate-900">
            <i class="fas fa-user-gear text-[200px]"></i>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-2xl p-2 shadow-xs border border-amber-100 flex gap-2 text-xs font-bold">
        <button @click="activeTab = 'profile'" 
                :class="activeTab === 'profile' ? 'bg-amber-600 text-white shadow-sm' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700'"
                class="flex-1 py-3 px-4 rounded-xl transition flex items-center justify-center gap-2">
            <i class="fas fa-user"></i> Informasi Akun
        </button>
        
        <button @click="activeTab = 'security'" 
                :class="activeTab === 'security' ? 'bg-amber-600 text-white shadow-sm' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700'"
                class="flex-1 py-3 px-4 rounded-xl transition flex items-center justify-center gap-2">
            <i class="fas fa-key"></i> Ubah Password
        </button>

        <button @click="activeTab = 'orders'" 
                :class="activeTab === 'orders' ? 'bg-amber-600 text-white shadow-sm' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700'"
                class="flex-1 py-3 px-4 rounded-xl transition flex items-center justify-center gap-2">
            <i class="fas fa-receipt"></i> Pesanan Saya ({{ count($orders) }})
        </button>
    </div>

    <!-- Tab 1: Edit Profile Form -->
    <div x-show="activeTab === 'profile'" x-cloak class="bg-white rounded-2xl shadow-xs border border-amber-100 p-6 md:p-8 space-y-6">
        <div class="border-b border-gray-100 pb-4">
            <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                <i class="fas fa-pen-to-square text-amber-600"></i> Pengaturan Informasi Profil
            </h2>
            <p class="text-xs text-gray-500 mt-1">Perbarui nama, nomor telepon, alamat pengiriman, dan foto avatar akun Anda.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6 text-xs font-medium">
            @csrf
            @method('PUT')

            <!-- Avatar Selection Gallery -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Foto Profil / Avatar Anda</label>
                <input type="hidden" name="avatar" :value="selectedAvatar">
                
                <div class="grid grid-cols-4 sm:grid-cols-8 gap-3">
                    @php
                        $avatars = [
                            'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
                            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80',
                            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
                            'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=200&q=80',
                            'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=200&q=80',
                            'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=200&q=80',
                            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&q=80',
                        ];
                    @endphp

                    @foreach($avatars as $idx => $imgUrl)
                    <button type="button" 
                            @click="selectedAvatar = '{{ $imgUrl }}'" 
                            :class="selectedAvatar === '{{ $imgUrl }}' ? 'ring-4 ring-amber-500 scale-105 border-transparent' : 'border-gray-200 hover:scale-105 opacity-70 hover:opacity-100'"
                            class="relative aspect-square rounded-full overflow-hidden border-2 transition duration-200 focus:outline-none group">
                        <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                        <div x-show="selectedAvatar === '{{ $imgUrl }}'" class="absolute inset-0 bg-amber-600/30 flex items-center justify-center">
                            <span class="w-6 h-6 bg-amber-600 text-white rounded-full flex items-center justify-center text-[10px] shadow">
                                <i class="fas fa-check"></i>
                            </span>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full p-3 border border-gray-200 rounded-xl focus:ring-amber-500">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full p-3 border border-gray-200 rounded-xl focus:ring-amber-500">
                </div>
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nomor WhatsApp / Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-amber-500">
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Utama Pengiriman</label>
                <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap rumah / lokasi tujuan order..." class="w-full p-3 border border-gray-200 rounded-xl focus:ring-amber-500">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="px-6 py-3.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-md transition inline-flex items-center gap-2">
                    <i class="fas fa-floppy-disk"></i> Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Tab 2: Change Password Form -->
    <div x-show="activeTab === 'security'" x-cloak class="bg-white rounded-2xl shadow-xs border border-amber-100 p-6 md:p-8 space-y-6">
        <div class="border-b border-gray-100 pb-4">
            <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                <i class="fas fa-lock text-amber-600"></i> Ubah Password Akun
            </h2>
            <p class="text-xs text-gray-500 mt-1">Pastikan password baru Anda menggunakan kombinasi karakter yang kuat.</p>
        </div>

        <form action="{{ route('profile.password') }}" method="POST" class="space-y-4 text-xs font-medium max-w-md">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Password Saat Ini</label>
                <input type="password" name="current_password" required placeholder="••••••••" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-amber-500">
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Password Baru</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-amber-500">
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password baru" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-amber-500">
            </div>

            <div class="pt-2">
                <button type="submit" class="px-6 py-3.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-md transition inline-flex items-center gap-2">
                    <i class="fas fa-key"></i> Perbarui Password
                </button>
            </div>
        </form>
    </div>

    <!-- Tab 3: Order History -->
    <div x-show="activeTab === 'orders'" x-cloak class="bg-white rounded-2xl shadow-xs border border-amber-100 p-6 md:p-8 space-y-6">
        <div class="border-b border-gray-100 pb-4">
            <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                <i class="fas fa-clock-rotate-left text-amber-600"></i> Riwayat Pesanan Saya
            </h2>
            <p class="text-xs text-gray-500 mt-1">Daftar transaksi dan order alat musik yang telah Anda pesan.</p>
        </div>

        @if(count($orders) === 0)
            <div class="text-center py-10 text-xs text-gray-400">
                <i class="fas fa-box-open text-4xl text-amber-200 mb-2"></i>
                <p class="font-bold text-gray-600 text-sm">Belum Ada Pesanan</p>
                <p class="mt-1">Anda belum melakukan transaksi pemesanan alat musik.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($orders as $order)
                <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        @if($order->product)
                            <img src="{{ $order->product->image_url }}" alt="{{ $order->product->name }}" class="w-12 h-12 rounded-xl object-cover border shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold shrink-0">
                                <i class="fas fa-bag-shopping"></i>
                            </div>
                        @endif
                        <div>
                            <h4 class="font-bold text-xs text-gray-900 line-clamp-1">{{ $order->product->name ?? 'Pesanan Katalog' }}</h4>
                            <p class="text-[11px] text-gray-500 font-medium">Qty: {{ $order->quantity }} &bull; Tgl: {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-4 border-t sm:border-t-0 pt-2 sm:pt-0 border-gray-200">
                        <div class="text-right">
                            <p class="text-xs font-extrabold text-amber-700">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full inline-block mt-0.5
                                {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-800' }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection

@section('scripts')
<script>
    function userProfileApp() {
        return {
            activeTab: 'profile',
            selectedAvatar: @json($user->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80')
        }
    }
</script>
@endsection

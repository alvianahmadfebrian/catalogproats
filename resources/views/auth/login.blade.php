@extends('layouts.app')

@section('title', 'Masuk Akun - Proats E-Catalog')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-amber-100">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-300 p-8 text-slate-950 text-center relative overflow-hidden border-b border-amber-300">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Proats Logo" class="h-14 w-auto mx-auto mb-3 object-contain bg-white/95 p-1 rounded-2xl shadow-lg border border-amber-200">
            <h1 class="text-2xl font-extrabold tracking-tight">Selamat Datang Kembali</h1>
            <p class="text-xs text-slate-900 font-semibold mt-1">Masuk ke akun Proats E-Catalog Anda</p>
        </div>

        <div class="p-6 md:p-8 space-y-6">

            <!-- Flash Error -->
            @if(isset($errors) && $errors->any())
                <div class="bg-red-50 text-red-800 p-3 rounded-xl text-xs font-semibold flex items-center gap-2 border border-red-200">
                    <i class="fas fa-circle-exclamation text-red-500"></i> {{ $errors->first() }}
                </div>
            @endif

            <!-- Google OAuth Button -->
            <a href="{{ route('auth.google') }}" class="w-full py-3 px-4 bg-white hover:bg-gray-50 text-gray-700 font-bold border border-gray-200 rounded-xl shadow-xs transition flex items-center justify-center gap-3 text-xs">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.11-6.72-4.96H1.26v3.15C3.24 21.3 7.31 24 12 24z"/>
                    <path fill="#FBBC05" d="M5.28 14.24c-.25-.72-.38-1.49-.38-2.24s.13-1.52.38-2.24V6.61H1.26C.46 8.23 0 10.06 0 12s.46 3.77 1.26 5.39l4.02-3.15z"/>
                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.24 2.7 1.26 6.61l4.02 3.15c.95-2.85 3.6-4.96 6.72-4.96z"/>
                </svg>
                <span>Masuk Instant via Google</span>
            </a>

            <div class="relative flex items-center justify-center">
                <div class="border-t border-gray-200 w-full"></div>
                <span class="bg-white px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest absolute">atau email</span>
            </div>

            <!-- Email & Password Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="nama@email.com" 
                           class="w-full p-3 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500 focus:border-amber-500 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Password</label>
                    <input type="password" 
                           name="password" 
                           required 
                           placeholder="••••••••" 
                           class="w-full p-3 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500 focus:border-amber-500 font-medium">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-600">
                        <input type="checkbox" name="remember" checked class="rounded text-amber-600 focus:ring-amber-500">
                        <span>Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold rounded-xl shadow-md transition flex items-center justify-center gap-2 text-xs">
                    <i class="fas fa-right-to-bracket"></i> Masuk Sekarang
                </button>
            </form>

            <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-100">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-amber-700 hover:underline">Daftar Akun Baru</a>
            </div>

        </div>
    </div>
</div>
@endsection

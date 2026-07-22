<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Catalog - Tempat Belanja Online Termurah')</title>

    <!-- Favicon / Tab Icon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">

    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        theme: {
                            yellow: '#d97706',
                            deepyellow: '#b45309',
                            darkgold: '#92400e',
                            lightyellow: '#fefce8',
                            softamber: '#fef08a',
                            price: '#eab308',
                            badge: '#b45309',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['"Outfit"', '"Plus Jakarta Sans"', 'sans-serif'],
                        outfit: ['"Outfit"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        h1, h2, h3, h4, .font-heading, .font-outfit { font-family: 'Outfit', sans-serif; letter-spacing: -0.02em; }
        /* Custom Pure Gold & White Radio Button without any dark inner ring */
        input[type="radio"] {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            width: 1.1rem !important;
            height: 1.1rem !important;
            border: 2px solid #d1d5db !important;
            border-radius: 50% !important;
            outline: none !important;
            transition: all 0.15s ease-in-out !important;
            cursor: pointer !important;
            background-color: #ffffff !important;
            display: inline-block !important;
            vertical-align: middle !important;
            margin: 0 !important;
        }
        input[type="radio"]:hover {
            border-color: #f59e0b !important;
        }
        input[type="radio"]:checked {
            border-color: #f59e0b !important;
            background-color: #f59e0b !important;
            box-shadow: inset 0 0 0 3px #ffffff !important;
        }
        .gold-gradient {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #eab308 100%);
        }
        .gold-gradient-soft {
            background: linear-gradient(135deg, #ffffff 0%, #fffbeb 35%, #fef08a 70%, #f59e0b 100%);
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-[#fafaf9] text-slate-800 font-sans antialiased min-h-screen flex flex-col selection:bg-amber-500 selection:text-white">

    <!-- Top Announcement Bar (Bright Soft Gold) -->
    <div class="bg-amber-400 text-slate-950 text-xs font-semibold border-b border-amber-300 hidden md:block py-1.5 shadow-2xs">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <!-- Left: Announcement Text & Social Icons -->
            <div class="flex items-center space-x-4 font-semibold">
                <span class="text-slate-950 flex items-center gap-1.5">
                    <i class="fas fa-bullhorn text-amber-900"></i> {{ \App\Models\Setting::get('announcement_bar', 'Gratis Ongkir Seluruh Indonesia Untuk Pembelian Marching Band & Set Musik!') }}
                </span>
                <span class="text-slate-950/30">|</span>
                <div class="flex items-center space-x-2 text-slate-950">
                    <span>Ikuti kami:</span>
                    @if(\App\Models\Setting::get('social_facebook'))
                        <a href="{{ \App\Models\Setting::get('social_facebook') }}" target="_blank" class="hover:text-amber-900"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(\App\Models\Setting::get('social_instagram'))
                        <a href="{{ \App\Models\Setting::get('social_instagram') }}" target="_blank" class="hover:text-amber-900"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(\App\Models\Setting::get('social_tiktok'))
                        <a href="{{ \App\Models\Setting::get('social_tiktok') }}" target="_blank" class="hover:text-amber-900"><i class="fab fa-tiktok"></i></a>
                    @endif
                </div>
            </div>

            <!-- Right: Links & Account -->
            <div class="flex items-center space-x-5 font-semibold text-slate-950">
                <!-- Notification Dropdown -->
                @auth
                <div x-data="notificationDropdown()" x-init="initNotifications()" class="relative inline-block text-left" @click.outside="open = false">
                    <button @click="open = !open" type="button" class="flex items-center gap-1 hover:text-amber-900 focus:outline-none transition py-1 text-slate-950 font-semibold relative" id="notification-menu">
                        <i class="far fa-bell text-amber-900 text-base"></i>
                        <span>{{ __('Notifikasi') }}</span>
                        <!-- Unread Count Badge -->
                        <template x-if="unreadCount > 0">
                            <span class="absolute -top-1 -right-2 bg-red-500 text-white font-extrabold text-[9px] px-1.5 py-0.2 rounded-full border border-white shadow-2xs min-w-[15px] text-center animate-pulse" x-text="unreadCount"></span>
                        </template>
                    </button>
                    <!-- Dropdown Pane -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="transform opacity-0 scale-95" 
                         x-transition:enter-end="transform opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="transform opacity-100 scale-100" 
                         x-transition:leave-end="transform opacity-0 scale-95" 
                         class="origin-top-right absolute right-0 mt-2 w-80 rounded-xl shadow-lg bg-white ring-1 ring-black/5 focus:outline-none z-50 overflow-hidden border border-amber-100 text-xs" 
                         x-cloak>
                        <div class="p-3 bg-amber-50/50 border-b border-amber-100 flex items-center justify-between font-bold">
                            <span class="text-gray-800">{{ __('Notifikasi Anda') }}</span>
                            <template x-if="unreadCount > 0">
                                <button @click="markAllAsRead()" class="text-[10px] text-amber-700 hover:underline">
                                    {{ __('Tandai Semua Dibaca') }}
                                </button>
                            </template>
                        </div>
                        <div class="max-h-64 overflow-y-auto divide-y divide-gray-100">
                            <!-- Empty State -->
                            <template x-if="notifications.length === 0">
                                <div class="p-6 text-center text-gray-400">
                                    <i class="far fa-bell text-xl mb-1 block"></i>
                                    <span>{{ __('Tidak ada notifikasi') }}</span>
                                </div>
                            </template>
                            <!-- Notification List -->
                            <template x-for="item in notifications" :key="item.id">
                                <div class="p-3 hover:bg-amber-50/30 transition flex gap-3 items-start cursor-pointer" :class="item.read_at ? 'opacity-70' : 'bg-amber-50/10 font-semibold'" @click="clickNotification(item)">
                                    <div class="w-7 h-7 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 text-[11px]">
                                        <i :class="item.icon"></i>
                                    </div>
                                    <div class="flex-grow min-w-0 text-left">
                                        <div class="text-gray-800 text-[11px] leading-snug" x-text="item.title"></div>
                                        <div class="text-gray-500 text-[10px] mt-0.5 line-clamp-2" x-text="item.message"></div>
                                        <div class="text-gray-400 text-[9px] mt-1" x-text="item.created_at"></div>
                                    </div>
                                    <template x-if="!item.read_at">
                                        <div class="w-1.5 h-1.5 rounded-full bg-amber-600 mt-1.5 shrink-0"></div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="flex items-center gap-1 hover:text-amber-900"><i class="far fa-bell"></i> {{ __('Notifikasi') }}</a>
                @endauth
                <button @click.prevent="$store.helpModal.open()" class="flex items-center gap-1 hover:text-amber-900 focus:outline-none"><i class="far fa-circle-question text-amber-900 text-base"></i> {{ __('Bantuan') }}</button>
                
                <!-- Language Switcher Dropdown (Alpine.js) -->
                <div x-data="{ open: false }" class="relative inline-block text-left" @click.outside="open = false">
                    <button @click="open = !open" type="button" class="flex items-center gap-1.5 hover:text-amber-900 focus:outline-none transition py-1 text-slate-950 font-semibold" id="language-switcher-menu" aria-expanded="true" aria-haspopup="true">
                        <i class="fas fa-globe text-amber-900"></i>
                        <span>{{ App::getLocale() === 'en' ? 'English' : 'Bahasa Indonesia' }}</span>
                        <i class="fas fa-chevron-down text-[10px] ml-0.5 text-slate-950/60"></i>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="transform opacity-0 scale-95" 
                         x-transition:enter-end="transform opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="transform opacity-100 scale-100" 
                         x-transition:leave-end="transform opacity-0 scale-95" 
                         class="origin-top-right absolute right-0 mt-2 w-44 rounded-xl shadow-lg bg-white ring-1 ring-black/5 focus:outline-none z-50 overflow-hidden py-1 border border-amber-100" 
                         role="menu" 
                         aria-orientation="vertical" 
                         aria-labelledby="language-switcher-menu" 
                         x-cloak>
                        <div class="py-0.5" role="none">
                            <a href="{{ route('lang.switch', 'id') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-amber-50 hover:text-amber-900 transition font-medium" role="menuitem">
                                <span class="text-sm">🇮🇩</span> Bahasa Indonesia
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-amber-50 hover:text-amber-900 transition font-medium" role="menuitem">
                                <span class="text-sm">🇬🇧</span> English
                            </a>
                        </div>
                    </div>
                </div>

                @auth
                    <div class="flex items-center gap-3 border-l border-slate-950/20 pl-4">
                        <a href="{{ route('profile.index') }}" class="flex items-center gap-2 hover:text-amber-900 transition" title="Pengaturan Profil">
                            <img src="{{ Auth::user()->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80'" class="w-5 h-5 rounded-full object-cover border border-amber-900" alt="Avatar">
                            <span class="font-bold truncate max-w-[120px]">{{ Auth::user()->name }}</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-amber-900 ml-1 text-xs" title="{{ __('Keluar') }}">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-3 border-l border-slate-950/20 pl-4 font-bold text-xs">
                        <a href="{{ route('login') }}" class="hover:text-amber-900">{{ __('Masuk') }}</a>
                        <span>|</span>
                        <a href="{{ route('register') }}" class="hover:text-amber-900">{{ __('Daftar') }}</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navigation Header (Bright Pure White Theme) -->
    <header class="bg-white sticky top-0 z-40 shadow-xs border-b border-amber-100/80 text-slate-900">
        <div class="max-w-7xl mx-auto px-3 md:px-4 py-2.5 md:py-3.5">
            <div class="flex items-center justify-between gap-2 md:gap-8">
                <!-- Brand Logo -->
                <a href="{{ route('catalog.index') }}" class="flex items-center gap-2 md:gap-3 text-slate-950 group shrink-0">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Proats Logo" class="h-9 md:h-12 w-auto object-contain bg-amber-50/60 p-1 rounded-xl shadow-xs group-hover:scale-105 transition transform border border-amber-200">
                    <div class="flex flex-col">
                        <span class="text-xl md:text-3xl font-extrabold tracking-tight text-slate-950 leading-none">Proats</span>
                        <span class="text-[9px] md:text-xs font-bold tracking-widest text-amber-600 uppercase hidden sm:inline-block">E-Catalog</span>
                    </div>
                </a>

                <!-- Search Form -->
                <div class="flex-1 max-w-2xl">
                    <form action="{{ route('catalog.index') }}" method="GET" class="relative flex items-center">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <input type="text" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="{{ __('Cari alat musik...') }}" 
                               class="w-full pl-3 md:pl-4 pr-11 md:pr-14 py-2 md:py-3 bg-amber-50/40 text-gray-900 text-xs md:text-sm rounded-xl focus:outline-none focus:bg-white shadow-xs border border-amber-200 placeholder-gray-400 focus:ring-2 focus:ring-amber-500">
                        <button type="submit" class="absolute right-1 top-1 bottom-1 px-3 md:px-4 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold rounded-lg transition flex items-center justify-center shadow-xs">
                            <i class="fas fa-magnifying-glass text-xs md:text-sm"></i>
                        </button>
                    </form>
                    <!-- Quick Keywords -->
                    <div class="hidden md:flex items-center gap-3 text-xs text-gray-500 font-semibold mt-1.5">
                        <a href="{{ route('catalog.index', ['search' => 'Snare']) }}" class="hover:text-amber-600 transition">Snare Marching</a>
                        <a href="{{ route('catalog.index', ['search' => 'Angklung']) }}" class="hover:text-amber-600 transition">Angklung Sunda</a>
                        <a href="{{ route('catalog.index', ['search' => 'Gitar']) }}" class="hover:text-amber-600 transition">Gitar Elektrik</a>
                        <a href="{{ route('catalog.index', ['search' => 'Drum']) }}" class="hover:text-amber-600 transition">Drum Kit</a>
                        <a href="{{ route('catalog.index', ['search' => 'Piano']) }}" class="hover:text-amber-600 transition">Digital Piano</a>
                    </div>
                </div>

                <!-- Right Header Actions (Cart & User Icon for Mobile) -->
                <div class="shrink-0 flex items-center gap-1 md:gap-3">
                    <a href="{{ route('cart.index') }}" @click="$dispatch('open-cart')" class="relative p-1.5 md:p-2.5 text-slate-950 hover:text-amber-600 transition flex items-center gap-2 font-bold cursor-pointer">
                        <div class="relative">
                            <i class="fas fa-cart-shopping text-xl md:text-2xl text-slate-900"></i>
                            <span x-data x-text="$store.cart ? $store.cart.count() : 0" 
                                  class="absolute -top-2 -right-2.5 bg-amber-500 text-slate-950 font-extrabold text-[10px] md:text-[11px] px-1.5 py-0.5 rounded-full border-2 border-white shadow-xs min-w-[18px] md:min-w-[20px] text-center">
                                0
                            </span>
                        </div>
                        <span class="hidden md:inline font-extrabold text-sm">{{ __('Keranjang') }}</span>
                    </a>

                    <!-- Mobile Language Switcher -->
                    <div class="md:hidden flex items-center mr-1">
                        @if(App::getLocale() === 'en')
                            <a href="{{ route('lang.switch', 'id') }}" class="p-1.5 text-[11px] font-extrabold text-slate-900 border border-amber-300 rounded-lg bg-amber-50" title="Switch to Indonesian">🇮🇩 ID</a>
                        @else
                            <a href="{{ route('lang.switch', 'en') }}" class="p-1.5 text-[11px] font-extrabold text-slate-900 border border-amber-300 rounded-lg bg-amber-50" title="Switch to English">🇬🇧 EN</a>
                        @endif
                    </div>

                    <!-- Mobile Direct User Link -->
                    <div class="md:hidden flex items-center">
                        @auth
                            <a href="{{ route('profile.index') }}" class="p-1 rounded-full border border-amber-400 flex items-center justify-center">
                                <img src="{{ Auth::user()->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80'" class="w-7 h-7 rounded-full object-cover" alt="User">
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-2.5 py-1 bg-amber-500 text-slate-950 font-extrabold text-xs rounded-lg shadow-2xs hover:bg-amber-600 transition">
                                {{ __('Masuk') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-2 md:px-4 py-3 md:py-6 pb-24 md:pb-6">
        @yield('content')
    </main>

    <!-- Mobile Fixed Bottom Navigation Bar -->
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-amber-200/80 shadow-lg md:hidden">
        <div class="grid grid-cols-5 h-14 text-[10px] font-bold text-slate-600">
            <a href="{{ route('catalog.index') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('catalog.index') && !request('category') ? 'text-amber-600' : 'hover:text-amber-600' }}">
                <i class="fas fa-store text-lg"></i>
                <span>{{ __('Katalog') }}</span>
            </a>

            <a href="{{ route('catalog.index') }}#catalog-section" class="flex flex-col items-center justify-center gap-0.5 hover:text-amber-600">
                <i class="fas fa-layer-group text-lg"></i>
                <span>{{ __('Kategori') }}</span>
            </a>

            <a href="{{ route('cart.index') }}" class="flex flex-col items-center justify-center gap-0.5 relative {{ request()->routeIs('cart.index') ? 'text-amber-600' : 'hover:text-amber-600' }}">
                <div class="relative">
                    <i class="fas fa-cart-shopping text-lg"></i>
                    <span x-data x-text="$store.cart ? $store.cart.count() : 0" 
                          class="absolute -top-1.5 -right-2 bg-amber-500 text-slate-950 font-extrabold text-[9px] px-1 py-0.2 rounded-full border border-white shadow-2xs min-w-[16px] text-center">
                        0
                    </span>
                </div>
                <span>{{ __('Keranjang') }}</span>
            </a>

            @auth
            <button @click="$dispatch('toggle-user-chat')" class="flex flex-col items-center justify-center gap-0.5 hover:text-amber-600">
                <i class="fas fa-headset text-lg"></i>
                <span>{{ __('Chat Admin') }}</span>
            </button>
            @else
            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center gap-0.5 hover:text-amber-600">
                <i class="fas fa-headset text-lg"></i>
                <span>{{ __('Chat Admin') }}</span>
            </button>
            @endauth

            @auth
            <a href="{{ route('profile.index') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('profile.index') ? 'text-amber-600' : 'hover:text-amber-600' }}">
                <img src="{{ Auth::user()->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80'" class="w-5 h-5 rounded-full object-cover border border-amber-500">
                <span class="truncate max-w-[50px]">{{ Auth::user()->name }}</span>
            </a>
            @else
            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('login') ? 'text-amber-600' : 'hover:text-amber-600' }}">
                <i class="fas fa-user-circle text-lg"></i>
                <span>{{ __('Masuk') }}</span>
            </a>
            @endauth
        </div>
    </nav>

    <!-- Footer -->
    <footer class="bg-white border-t border-amber-200/60 text-gray-600 mt-12 text-xs md:text-sm">
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm md:text-base uppercase tracking-wider mb-3">{{ __('Layanan Pelanggan') }}</h3>
                    <ul class="space-y-2 text-xs">
                        <li><button @click.prevent="$store.helpModal.open()" class="hover:text-amber-600 focus:outline-none">{{ __('Bantuan') }}</button></li>
                        <li><a href="#" class="hover:text-amber-600">{{ __('Metode Pembayaran') }}</a></li>
                        <li><a href="#" class="hover:text-amber-600">Proats Pay</a></li>
                        <li><a href="#" class="hover:text-amber-600">{{ __('Garansi Toko') }}</a></li>
                        <li><a href="#" class="hover:text-amber-600">{{ __('Hubungi Kami') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm md:text-base uppercase tracking-wider mb-3">{{ __('Jelajahi Proats') }}</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#" class="hover:text-amber-600">{{ __('Tentang Kami') }}</a></li>
                        <li><a href="#" class="hover:text-amber-600">{{ __('Karir') }}</a></li>
                        <li><a href="#" class="hover:text-amber-600">{{ __('Kebijakan Privasi') }}</a></li>
                        <li><a href="#" class="hover:text-amber-600">Proats Blog</a></li>
                        <li><a href="#" class="hover:text-amber-600">Flash Sale</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm md:text-base uppercase tracking-wider mb-3">{{ __('Pembayaran & Pengiriman') }}</h3>
                    <div class="flex flex-wrap gap-2 text-gray-400 text-xl">
                        <i class="fab fa-cc-visa text-amber-600"></i>
                        <i class="fab fa-cc-mastercard text-amber-600"></i>
                        <i class="fas fa-wallet text-amber-600"></i>
                        <i class="fas fa-qrcode text-amber-600"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 mb-3 text-sm">{{ __('Ikuti Media Sosial') }}</h3>
                    <div class="flex items-center space-x-3">
                        @if(\App\Models\Setting::get('social_facebook'))
                            <a href="{{ \App\Models\Setting::get('social_facebook') }}" target="_blank" class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center hover:opacity-90"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(\App\Models\Setting::get('social_instagram'))
                            <a href="{{ \App\Models\Setting::get('social_instagram') }}" target="_blank" class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center hover:opacity-90"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(\App\Models\Setting::get('social_tiktok'))
                            <a href="{{ \App\Models\Setting::get('social_tiktok') }}" target="_blank" class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center hover:opacity-90"><i class="fab fa-tiktok"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-6 text-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Proats E-Catalog Showcase. {{ __('Hak Cipta Dilindungi Undang-Undang.') }}</p>
                <p class="mt-1 text-gray-400">{{ __('Desain khusus Putih Gradient Kuning Tua (Deep Gold Aesthetic).') }}</p>
            </div>
        </div>
    </footer>

    @auth
    <!-- Floating User Chat Widget (Only for Logged-In Users) -->
    <div x-data="userChatWidget()" @toggle-user-chat.window="toggleChat()" class="fixed bottom-20 right-4 md:bottom-6 md:right-6 z-50">
        <!-- Chat Toggle Button -->
        <button @click="toggleChat()" class="relative bg-gradient-to-r from-amber-600 to-yellow-500 text-white w-12 h-12 md:w-14 md:h-14 rounded-full shadow-2xl flex items-center justify-center text-xl md:text-2xl hover:scale-105 transition duration-300">
            <i class="fas" :class="isOpen ? 'fa-xmark' : 'fa-headset'"></i>
            <span x-show="unreadCount > 0" x-cloak class="absolute -top-1 -right-1 bg-red-600 text-white font-bold text-[10px] w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow animate-bounce" x-text="unreadCount"></span>
        </button>

        <!-- Chat Popover Window -->
        <div x-show="isOpen" 
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="fixed inset-x-3 bottom-20 sm:bottom-16 sm:right-0 sm:left-auto w-auto sm:w-96 bg-white rounded-2xl shadow-2xl border border-amber-200 overflow-hidden flex flex-col h-[450px]">
            
            <!-- Chat Header -->
            <div class="bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-500 p-4 text-white flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-lg font-bold border border-white/40">
                            <i class="fas fa-user-shield text-amber-900"></i>
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-xs text-slate-950">Live Chat Admin Proats</h4>
                        <p class="text-[10px] text-slate-900 font-medium">Bantuan & Layanan Pelanggan</p>
                    </div>
                </div>
                <button @click="isOpen = false" class="text-slate-900 hover:text-white transition">
                    <i class="fas fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Messages List Body -->
            <div x-ref="messagesBody" class="flex-1 p-4 overflow-y-auto space-y-3 bg-slate-50 text-xs">
                <div class="text-center py-2 text-[10px] text-gray-400 font-medium">
                    <span class="bg-white px-2 py-0.5 rounded-full border border-gray-100">Hubungi Admin Proats melalui fitur ini</span>
                </div>

                <template x-for="msg in messages" :key="msg.id">
                    <div class="flex flex-col" :class="msg.is_admin ? 'items-start' : 'items-end'">
                        <div class="max-w-[80%] rounded-2xl px-3.5 py-2 text-xs shadow-xs leading-relaxed"
                             :class="msg.is_admin ? 'bg-white text-gray-800 border border-gray-100 rounded-tl-none' : 'bg-amber-600 text-white rounded-tr-none font-medium'">
                            <p x-text="msg.message"></p>
                        </div>
                        <span class="text-[9px] text-gray-400 mt-1 px-1" x-text="msg.time"></span>
                    </div>
                </template>
            </div>

            <!-- Send Input Footer -->
            <form @submit.prevent="sendMessage()" class="p-3 bg-white border-t border-gray-100 flex items-center gap-2">
                <input type="text" 
                       x-model="newMessage" 
                       placeholder="Tulis pesan Anda..." 
                       class="flex-1 text-xs p-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
                <button type="submit" 
                        :disabled="!newMessage.trim()" 
                        class="p-2.5 bg-amber-600 hover:bg-amber-700 disabled:opacity-50 text-white rounded-xl transition shrink-0 shadow-sm">
                    <i class="fas fa-paper-plane text-xs"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        function notificationDropdown() {
            return {
                open: false,
                unreadCount: 0,
                notifications: [],

                initNotifications() {
                    this.fetchNotifications();
                    setInterval(() => this.fetchNotifications(), 15000);
                },

                fetchNotifications() {
                    fetch('{{ route('notifications.index') }}')
                        .then(r => r.json())
                        .then(d => {
                            this.unreadCount = d.unread_count;
                            this.notifications = d.notifications;
                        })
                        .catch(() => {});
                },

                clickNotification(item) {
                    if (!item.read_at) {
                        fetch(`/api/notifications/${item.id}/read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(r => r.json())
                        .then(() => {
                            this.fetchNotifications();
                            if (item.url && item.url !== '#') {
                                window.location.href = item.url;
                            }
                        })
                        .catch(() => {
                            if (item.url && item.url !== '#') {
                                window.location.href = item.url;
                            }
                        });
                    } else {
                        if (item.url && item.url !== '#') {
                            window.location.href = item.url;
                        }
                    }
                    this.open = false;
                },

                markAllAsRead() {
                    fetch('/api/notifications/read-all', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(() => {
                        this.fetchNotifications();
                    })
                    .catch(() => {});
                }
            }
        }

        function userChatWidget() {
            return {
                isOpen: false,
                messages: [],
                newMessage: '',
                unreadCount: 0,
                pollInterval: null,

                init() {
                    this.fetchMessages();
                    this.pollInterval = setInterval(() => {
                        this.fetchMessages();
                    }, 4000);
                },

                toggleChat() {
                    this.isOpen = !this.isOpen;
                    if (this.isOpen) {
                        this.fetchMessages();
                        this.scrollToBottom();
                    }
                },

                fetchMessages() {
                    fetch('/chat/messages', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.messages) {
                            this.messages = data.messages;
                            if (this.isOpen) {
                                this.$nextTick(() => this.scrollToBottom());
                            }
                        }
                    })
                    .catch(err => console.error(err));
                },

                sendMessage() {
                    if (!this.newMessage.trim()) return;
                    const text = this.newMessage;
                    this.newMessage = '';

                    fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ message: text })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.messages.push(data.message);
                            this.$nextTick(() => this.scrollToBottom());
                        }
                    });
                },

                scrollToBottom() {
                    if (this.$refs.messagesBody) {
                        this.$refs.messagesBody.scrollTop = this.$refs.messagesBody.scrollHeight;
                    }
                }
            }
        }
    </script>
    @endauth

    <!-- Global Script (Accessible by Guests & Logged-In Users) -->
    <script>
        document.addEventListener('alpine:init', () => {
            if (!Alpine.store('helpModal')) {
                Alpine.store('helpModal', {
                    isOpen: false,
                    open() { this.isOpen = true; },
                    close() { this.isOpen = false; }
                });
            }
        });

        function helpCenterModal() {
            return {
                searchQuery: '',
                activeCategory: 'semua',
                openFaq: null,
                
                categories: [
                    { id: 'semua', name: '{{ __("Semua Bantuan") }}' },
                    { id: 'pemesanan', name: '{{ __("Pemesanan") }}' },
                    { id: 'pembayaran', name: '{{ __("Pembayaran") }}' },
                    { id: 'pengiriman', name: '{{ __("Pengiriman") }}' },
                    { id: 'layanan', name: '{{ __("Layanan") }}' }
                ],
                
                faqs: [
                    {
                        cat: 'pemesanan',
                        q: '{{ __("Bagaimana cara melakukan pemesanan di Proats?") }}',
                        a: '{{ __("Pilih produk favorit Anda, masukkan ke keranjang belanja, klik Checkout, isi detail pengiriman Anda, lalu kirimkan rincian pesanan langsung ke WhatsApp admin untuk dikonfirmasi.") }}'
                    },
                    {
                        cat: 'pembayaran',
                        q: '{{ __("Metode pembayaran apa saja yang didukung?") }}',
                        a: '{{ __("Kami menerima pembayaran via Transfer Bank (BCA & Mandiri), COD (Bayar di Tempat), QRIS, dan Proats Pay yang bebas biaya admin.") }}'
                    },
                    {
                        cat: 'pengiriman',
                        q: '{{ __("Apakah pengiriman di Proats E-Catalog gratis?") }}',
                        a: '{{ __("Ya! Kami menyediakan pengiriman gratis untuk seluruh wilayah yang terjangkau oleh logistik partner kami.") }}'
                    },
                    {
                        cat: 'layanan',
                        q: '{{ __("Bagaimana dengan Garansi Toko?") }}',
                        a: '{{ __("Semua instrumen musik yang dibeli melalui Proats mendapatkan Garansi Toko selama 30 hari sejak barang diterima.") }}'
                    },
                    {
                        cat: 'layanan',
                        q: '{{ __("Bagaimana cara menghubungi admin jika ada kendala?") }}',
                        a: '{{ __("Anda bisa langsung menggunakan tombol Chat Admin Live di bawah untuk live chat, atau langsung ke WhatsApp kami di 0812-3456-7890.") }}'
                    }
                ],
                
                toggleFaq(idx) {
                    this.openFaq = this.openFaq === idx ? null : idx;
                },
                
                filteredFaqs() {
                    let filtered = this.faqs;
                    if (this.activeCategory !== 'semua') {
                        filtered = filtered.filter(f => f.cat === this.activeCategory);
                    }
                    if (this.searchQuery.trim() !== '') {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(f => f.q.toLowerCase().includes(query) || f.a.toLowerCase().includes(query));
                    }
                    return filtered;
                }
            }
        }
    </script>

    <!-- Interactive Help Center & FAQ Modal -->
    <div x-data="helpCenterModal()" 
         x-show="$store.helpModal.isOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
         @keydown.escape.window="$store.helpModal.close()">
        <div class="relative bg-white rounded-2xl max-w-2xl w-full shadow-2xl overflow-hidden border border-amber-100 flex flex-col max-h-[85vh] text-left"
             @click.outside="$store.helpModal.close()"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
             
            <!-- Header -->
            <div class="p-6 bg-gradient-to-r from-amber-600 to-amber-700 text-white shrink-0 relative">
                <button @click="$store.helpModal.close()" class="absolute top-4 right-4 text-white/80 hover:text-white hover:scale-110 transition text-xl">
                    <i class="fas fa-xmark"></i>
                </button>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-2xl shadow-xs">
                        <i class="far fa-circle-question"></i>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-extrabold tracking-tight">{{ __('Pusat Bantuan & FAQ') }}</h2>
                        <p class="text-xs text-amber-100/90 font-medium">{{ __('Temukan jawaban dan solusi cepat untuk pertanyaan Anda') }}</p>
                    </div>
                </div>
                
                <!-- Search FAQ Input -->
                <div class="mt-5 relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-amber-800">
                        <i class="fas fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="{{ __('Cari pertanyaan atau bantuan...') }}" 
                           class="w-full text-xs py-3 pl-10 pr-4 bg-white/95 text-gray-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 shadow-inner font-medium placeholder-gray-400">
                </div>
            </div>
            
            <!-- Category Tabs -->
            <div class="px-6 py-3 bg-gray-50 border-b border-gray-100 flex gap-2 overflow-x-auto shrink-0 scrollbar-none">
                <template x-for="cat in categories" :key="cat.id">
                    <button @click="activeCategory = cat.id"
                            class="px-3.5 py-1.5 rounded-xl font-extrabold text-[10px] md:text-xs border transition shrink-0 uppercase tracking-wider"
                            :class="activeCategory === cat.id 
                                ? 'bg-amber-600 text-white border-amber-600 shadow-xs' 
                                : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-100 hover:text-gray-900'">
                        <span x-text="cat.name"></span>
                    </button>
                </template>
            </div>
            
            <!-- Content & FAQ List -->
            <div class="p-6 overflow-y-auto flex-1 space-y-4">
                <!-- FAQs Accordion -->
                <div class="space-y-2.5">
                    <template x-for="(faq, idx) in filteredFaqs()" :key="idx">
                        <div class="bg-gray-50/50 rounded-xl border border-gray-100 hover:border-amber-200 transition">
                            <!-- Question Button -->
                            <button @click="toggleFaq(idx)" 
                                    class="w-full p-4 text-left flex items-start justify-between gap-3 text-xs md:text-sm font-bold text-gray-800 hover:text-amber-700 transition">
                                <span x-text="faq.q"></span>
                                <i class="fas fa-chevron-down text-[10px] mt-1 text-gray-400 transition transform duration-200" 
                                   :class="openFaq === idx ? 'rotate-180 text-amber-600' : ''"></i>
                            </button>
                            <!-- Answer Pane -->
                            <div x-show="openFaq === idx" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 max-h-0"
                                 x-transition:enter-end="opacity-100 max-h-screen"
                                 class="px-4 pb-4 text-xs text-gray-500 leading-relaxed font-medium"
                                 x-cloak>
                                <p x-html="faq.a"></p>
                            </div>
                        </div>
                    </template>
                    <!-- Empty State -->
                    <template x-if="filteredFaqs().length === 0">
                        <div class="p-8 text-center text-gray-400">
                            <i class="fas fa-magnifying-glass text-2xl mb-2 block text-gray-300"></i>
                            <span class="text-xs font-semibold">{{ __('Tidak ada hasil untuk pencarian Anda') }}</span>
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- Footer Call Actions -->
            <div class="p-4 bg-gray-50 border-t border-gray-100 shrink-0 flex flex-col sm:flex-row gap-3 items-center justify-between text-xs">
                <div class="text-gray-500 font-semibold text-center sm:text-left">
                    {{ __('Belum menemukan jawaban?') }}
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    @auth
                    <button @click="$store.helpModal.close(); $dispatch('toggle-user-chat')" 
                            class="flex-1 sm:flex-none px-4 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-extrabold rounded-xl transition flex items-center justify-center gap-1.5 border border-amber-200 shadow-2xs">
                        <i class="fas fa-headset"></i> {{ __('Chat Admin Live') }}
                    </button>
                    @else
                    <a href="{{ route('login') }}" 
                            class="flex-1 sm:flex-none px-4 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-extrabold rounded-xl transition flex items-center justify-center gap-1.5 border border-amber-200 shadow-2xs">
                        <i class="fas fa-headset"></i> {{ __('Chat Admin Live') }}
                    </a>
                    @endauth
                    <a href="https://wa.me/6281234567890" target="_blank" 
                       class="flex-1 sm:flex-none px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-emerald-600/10">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>

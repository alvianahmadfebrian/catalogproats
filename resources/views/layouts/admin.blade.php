<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Proats Admin CMS')</title>

    <!-- Favicon / Tab Icon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">

    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['"Outfit"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, .font-heading { font-family: 'Outfit', sans-serif; letter-spacing: -0.02em; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-amber-50/20 h-screen overflow-hidden flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 z-30 bg-black/30 lg:hidden"></div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white border-r border-amber-100 flex flex-col justify-between transition-transform duration-200 shrink-0">
        
        <div>
            <!-- Brand Header -->
            <div class="px-5 py-5 border-b border-amber-100 flex items-center gap-3 shrink-0">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Proats Logo" class="h-9 w-auto object-contain bg-amber-50/60 p-1 rounded-xl border border-amber-200">
                <div>
                    <h1 class="font-extrabold text-sm text-gray-900 leading-none">Proats Admin</h1>
                    <span class="text-[10px] text-amber-600 font-bold uppercase tracking-widest">CMS Control Panel</span>
                </div>
            </div>

            <!-- Structured Menu Nav -->
            <nav class="p-3 space-y-4 text-[12px] font-semibold overflow-y-auto max-h-[calc(100vh-140px)]">
                
                <!-- Section 1: UTAMA & ANALITIK -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold text-amber-700/80 uppercase tracking-widest">
                        {{ __('UTAMA & ANALITIK') }}
                    </div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-chart-pie w-4 text-center"></i> {{ __('Ringkasan Dashboard') }}
                    </a>
                </div>

                <!-- Section 2: KELOLA KATALOG USER -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold text-amber-700/80 uppercase tracking-widest">
                        {{ __('KELOLA KATALOG USER') }}
                    </div>
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.products.index') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-boxes-stacked w-4 text-center"></i> {{ __('Kelola Semua Produk') }}
                    </a>
                    <a href="{{ route('admin.products.create') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.products.create') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-square-plus w-4 text-center"></i> {{ __('Tambah Produk Baru') }}
                    </a>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-tags w-4 text-center"></i> {{ __('Kategori Alat Musik') }}
                    </a>
                </div>

                <!-- Section 3: PENJUALAN & USER -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold text-amber-700/80 uppercase tracking-widest">
                        {{ __('PENJUALAN & USER') }}
                    </div>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.orders.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-receipt w-4 text-center"></i> {{ __('Transaksi & Order Pembeli') }}
                    </a>
                    <a href="{{ route('admin.chat.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.chat.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-comments w-4 text-center"></i> {{ __('Live Chat Pelanggan') }}
                        </div>
                        <span x-data="{ unread: 0 }" 
                              x-init="fetch('/cms-admin/chat/unread').then(r=>r.json()).then(d=>unread=d.unread_count); setInterval(()=>fetch('/cms-admin/chat/unread').then(r=>r.json()).then(d=>unread=d.unread_count), 4000)"
                              x-show="unread > 0" 
                              x-cloak 
                              x-text="unread" 
                              class="bg-slate-900 text-amber-300 font-extrabold text-[10px] px-2 py-0.5 rounded-full shadow-2xs"></span>
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.reviews.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-star w-4 text-center"></i> {{ __('Ulasan & Rating User') }}
                    </a>
                </div>

                <!-- Section 4: PROMO & PENGATURAN SISTEM -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold text-amber-700/80 uppercase tracking-widest">
                        {{ __('PROMO & PENGATURAN') }}
                    </div>
                    <a href="{{ route('admin.promos.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.promos.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-ticket-simple w-4 text-center"></i> {{ __('Kode Promo / Voucher') }}
                    </a>
                    <a href="{{ route('admin.banners.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.banners.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-images w-4 text-center"></i> {{ __('Hero Banner Slider') }}
                    </a>
                    <a href="{{ route('admin.settings.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.settings.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-sliders w-4 text-center"></i> {{ __('Pengaturan Keseluruhan') }}
                    </a>
                </div>

                <div class="border-t border-amber-100 pt-2">
                    <a href="{{ route('catalog.index') }}" target="_blank"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-500 hover:bg-amber-50 hover:text-amber-700 transition">
                        <i class="fas fa-external-link-alt w-4 text-center"></i> {{ __('Lihat Katalog User') }} <i class="fas fa-arrow-up-right-from-square text-[9px] ml-auto"></i>
                    </a>
                </div>
            </nav>
        </div>

        <!-- User Footer -->
        <div class="p-4 border-t border-amber-100 shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 font-bold flex items-center justify-center text-xs">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-800 truncate max-w-[100px]">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-gray-400">{{ Auth::user()->username ?? 'admin' }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-1.5 text-gray-400 hover:text-amber-600 transition" title="{{ __('Keluar') }}">
                        <i class="fas fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">

        <!-- Topbar -->
        <header class="bg-white border-b border-amber-100 sticky top-0 z-20 px-4 py-3 flex items-center justify-between shrink-0 shadow-2xs">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-500 hover:bg-amber-50 rounded-lg lg:hidden">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-sm font-bold text-gray-800">@yield('page_title', 'Dashboard')</h2>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Admin Language Switcher Dropdown (Alpine.js) -->
                <div x-data="{ open: false }" class="relative inline-block text-left" @click.outside="open = false">
                    <button @click="open = !open" type="button" class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-xl transition border border-amber-200 focus:outline-none animate-pulse-slow" id="admin-language-switcher" aria-expanded="true" aria-haspopup="true">
                        <i class="fas fa-globe text-amber-600"></i>
                        <span>{{ App::getLocale() === 'en' ? 'EN' : 'ID' }}</span>
                        <i class="fas fa-chevron-down text-[9px] text-amber-600/70"></i>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="transform opacity-0 scale-95" 
                         x-transition:enter-end="transform opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="transform opacity-100 scale-100" 
                         x-transition:leave-end="transform opacity-0 scale-95" 
                         class="origin-top-right absolute right-0 mt-2 w-36 rounded-xl shadow-lg bg-white ring-1 ring-black/5 focus:outline-none z-50 overflow-hidden py-1 border border-amber-100 text-xs" 
                         role="menu" 
                         aria-orientation="vertical" 
                         aria-labelledby="admin-language-switcher" 
                         x-cloak>
                        <div class="py-0.5" role="none">
                            <a href="{{ route('lang.switch', 'id') }}" class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-900 transition font-medium" role="menuitem">
                                <span>🇮🇩</span> Indo (ID)
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-900 transition font-medium" role="menuitem">
                                <span>🇬🇧</span> English (EN)
                            </a>
                        </div>
                    </div>
                </div>

               <!-- Admin Notification Dropdown -->
               <div x-data="notificationDropdown()" x-init="initNotifications()" class="relative inline-block text-left" @click.outside="open = false">
                   <button @click="open = !open" type="button" class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-xl transition border border-amber-200 focus:outline-none relative" id="admin-notifications">
                       <i class="far fa-bell text-amber-600"></i>
                       <!-- Unread Count Badge -->
                       <template x-if="unreadCount > 0">
                           <span class="absolute -top-1 -right-1 bg-red-500 text-white font-extrabold text-[8px] w-4.5 h-4.5 rounded-full border-2 border-white flex items-center justify-center shadow-2xs" x-text="unreadCount"></span>
                       </template>
                   </button>
                   <div x-show="open" 
                        x-transition:enter="transition ease-out duration-100" 
                        x-transition:enter-start="transform opacity-0 scale-95" 
                        x-transition:enter-end="transform opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-75" 
                        x-transition:leave-start="transform opacity-100 scale-100" 
                        x-transition:leave-end="transform opacity-0 scale-95" 
                        class="origin-top-right absolute right-0 mt-2 w-80 rounded-xl shadow-lg bg-white ring-1 ring-black/5 focus:outline-none z-50 overflow-hidden py-1 border border-amber-100 text-xs" 
                        role="menu" 
                        aria-orientation="vertical" 
                        aria-labelledby="admin-notifications" 
                        x-cloak>
                       <div class="p-3 bg-amber-50/50 border-b border-amber-100 flex items-center justify-between font-bold">
                           <span class="text-gray-800">{{ __('Notifikasi Sistem') }}</span>
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
                               <div class="p-3 hover:bg-amber-50/30 transition flex gap-3 items-start cursor-pointer text-left" :class="item.read_at ? 'opacity-70' : 'bg-amber-50/10 font-semibold'" @click="clickNotification(item)">
                                   <div class="w-7 h-7 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 text-[11px]">
                                       <i :class="item.icon"></i>
                                   </div>
                                   <div class="flex-grow min-w-0">
                                       <div class="text-gray-800 text-[11px] leading-snug" x-text="item.title"></div>
                                       <div class="text-gray-500 text-[10px] mt-0.5" x-text="item.message"></div>
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

               <a href="{{ route('admin.chat.index') }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-xl transition flex items-center gap-2 border border-amber-200">
                   <i class="fas fa-comments"></i> {{ __('Chat Pelanggan') }}
               </a>
                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    <i class="fas fa-circle text-[6px] animate-pulse mr-1"></i> {{ __('Online') }}
                </span>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6 max-w-7xl w-full mx-auto space-y-5">

            @if(session('success'))
                <div class="bg-emerald-50 text-emerald-700 p-3 rounded-xl text-xs font-semibold flex items-center gap-2 border border-emerald-200">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="bg-red-50 text-red-700 p-3 rounded-xl text-xs font-semibold border border-red-200">
                    <p class="font-bold flex items-center gap-2 mb-1"><i class="fas fa-circle-exclamation"></i> Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-[11px] space-y-0.5 pl-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </main>
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
    </script>
    @yield('scripts')
</body>
</html>

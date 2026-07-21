<!DOCTYPE html>
<html lang="id">
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
                        UTAMA & ANALITIK
                    </div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-chart-pie w-4 text-center"></i> Ringkasan Dashboard
                    </a>
                </div>

                <!-- Section 2: KELOLA KATALOG USER -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold text-amber-700/80 uppercase tracking-widest">
                        KELOLA KATALOG USER
                    </div>
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.products.index') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-boxes-stacked w-4 text-center"></i> Kelola Semua Produk
                    </a>
                    <a href="{{ route('admin.products.create') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.products.create') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-square-plus w-4 text-center"></i> Tambah Produk Baru
                    </a>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-tags w-4 text-center"></i> Kategori Alat Musik
                    </a>
                </div>

                <!-- Section 3: PENJUALAN & USER -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold text-amber-700/80 uppercase tracking-widest">
                        PENJUALAN & USER
                    </div>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.orders.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-receipt w-4 text-center"></i> Transaksi & Order Pembeli
                    </a>
                    <a href="{{ route('admin.chat.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.chat.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-comments w-4 text-center"></i> Live Chat Pelanggan
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
                        <i class="fas fa-star w-4 text-center"></i> Ulasan & Rating User
                    </a>
                </div>

                <!-- Section 4: PENGATURAN HALAMAN & SISTEM -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold text-amber-700/80 uppercase tracking-widest">
                        PENGATURAN SISTEM
                    </div>
                    <a href="{{ route('admin.banners.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.banners.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-images w-4 text-center"></i> Hero Banner Slider
                    </a>
                    <a href="{{ route('admin.settings.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.settings.*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        <i class="fas fa-sliders w-4 text-center"></i> Pengaturan Keseluruhan
                    </a>
                </div>

                <div class="border-t border-amber-100 pt-2">
                    <a href="{{ route('catalog.index') }}" target="_blank"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-500 hover:bg-amber-50 hover:text-amber-700 transition">
                        <i class="fas fa-external-link-alt w-4 text-center"></i> Lihat Katalog User <i class="fas fa-arrow-up-right-from-square text-[9px] ml-auto"></i>
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
                    <button type="submit" class="p-1.5 text-gray-400 hover:text-amber-600 transition" title="Logout">
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
                <a href="{{ route('admin.chat.index') }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-xl transition flex items-center gap-2 border border-amber-200">
                    <i class="fas fa-comments"></i> Chat Pelanggan
                </a>
                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    <i class="fas fa-circle text-[6px] animate-pulse mr-1"></i> Online
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

    @yield('scripts')
</body>
</html>

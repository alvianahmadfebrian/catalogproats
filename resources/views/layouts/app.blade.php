<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Catalog - Tempat Belanja Online Termurah')</title>

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
                    <a href="#" class="hover:text-amber-900"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-amber-900"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-amber-900"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <!-- Right: Links & Account -->
            <div class="flex items-center space-x-5 font-semibold text-slate-950">
                <a href="#" class="flex items-center gap-1 hover:text-amber-900"><i class="far fa-bell"></i> Notifikasi</a>
                <a href="#" class="flex items-center gap-1 hover:text-amber-900"><i class="far fa-circle-question"></i> Bantuan</a>
                <a href="#" class="flex items-center gap-1 hover:text-amber-900"><i class="fas fa-globe"></i> Bahasa Indonesia</a>
                @auth
                    <div class="flex items-center gap-3 border-l border-slate-950/20 pl-4">
                        <a href="{{ route('profile.index') }}" class="flex items-center gap-2 hover:text-amber-900 transition" title="Pengaturan Profil">
                            <img src="{{ Auth::user()->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80'" class="w-5 h-5 rounded-full object-cover border border-amber-900" alt="Avatar">
                            <span class="font-bold truncate max-w-[120px]">{{ Auth::user()->name }}</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-amber-900 ml-1 text-xs" title="Keluar / Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-3 border-l border-slate-950/20 pl-4 font-bold text-xs">
                        <a href="{{ route('login') }}" class="hover:text-amber-900">Masuk</a>
                        <span>|</span>
                        <a href="{{ route('register') }}" class="hover:text-amber-900">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navigation Header (Bright Pure White Theme) -->
    <header class="bg-white sticky top-0 z-40 shadow-xs border-b border-amber-100/80 text-slate-900">
        <div class="max-w-7xl mx-auto px-4 pt-3.5 pb-3.5">
            <div class="flex items-center justify-between gap-4 md:gap-8">
                <!-- Brand Logo -->
                <a href="{{ route('catalog.index') }}" class="flex items-center gap-3 text-slate-950 group shrink-0">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Proats Logo" class="h-10 md:h-12 w-auto object-contain bg-amber-50/60 p-1 rounded-xl shadow-xs group-hover:scale-105 transition transform border border-amber-200">
                    <div class="flex flex-col">
                        <span class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-950 leading-none">Proats</span>
                        <span class="text-[10px] md:text-xs font-bold tracking-widest text-amber-600 uppercase">E-Catalog</span>
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
                               placeholder="Cari alat musik pilihanmu di Proats Catalog (contoh: Snare Drum, Angklung, Gitar)..." 
                               class="w-full pl-4 pr-14 py-2.5 md:py-3 bg-amber-50/40 text-gray-900 text-sm rounded-xl focus:outline-none focus:bg-white shadow-xs border border-amber-200 placeholder-gray-400 focus:ring-2 focus:ring-amber-500">
                        <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold rounded-lg transition flex items-center justify-center shadow-xs">
                            <i class="fas fa-magnifying-glass text-sm"></i>
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

                <!-- Cart Button Trigger -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('cart.index') }}" @click="$dispatch('open-cart')" class="relative p-2.5 text-slate-950 hover:text-amber-600 transition flex items-center gap-2 font-bold cursor-pointer">
                        <div class="relative">
                            <i class="fas fa-cart-shopping text-2xl text-slate-900"></i>
                            <span x-data x-text="$store.cart ? $store.cart.count() : 0" 
                                  class="absolute -top-2 -right-2.5 bg-amber-500 text-slate-950 font-extrabold text-[11px] px-1.5 py-0.5 rounded-full border-2 border-white shadow-xs min-w-[20px] text-center">
                                0
                            </span>
                        </div>
                        <span class="hidden md:inline font-extrabold text-sm">Keranjang</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-2 md:px-4 py-4 md:py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-amber-200/60 text-gray-600 mt-12 text-xs md:text-sm">
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm md:text-base uppercase tracking-wider mb-3">Layanan Pelanggan</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#" class="hover:text-amber-600">Bantuan</a></li>
                        <li><a href="#" class="hover:text-amber-600">Metode Pembayaran</a></li>
                        <li><a href="#" class="hover:text-amber-600">Proats Pay</a></li>
                        <li><a href="#" class="hover:text-amber-600">Garansi Toko</a></li>
                        <li><a href="#" class="hover:text-amber-600">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm md:text-base uppercase tracking-wider mb-3">Jelajahi Proats</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#" class="hover:text-amber-600">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-amber-600">Karir</a></li>
                        <li><a href="#" class="hover:text-amber-600">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-amber-600">Proats Blog</a></li>
                        <li><a href="#" class="hover:text-amber-600">Flash Sale</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm md:text-base uppercase tracking-wider mb-3">Pembayaran & Pengiriman</h3>
                    <div class="flex flex-wrap gap-2 text-gray-400 text-xl">
                        <i class="fab fa-cc-visa text-amber-600"></i>
                        <i class="fab fa-cc-mastercard text-amber-600"></i>
                        <i class="fas fa-wallet text-amber-600"></i>
                        <i class="fas fa-qrcode text-amber-600"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 mb-3 text-sm">Ikuti Media Sosial</h3>
                    <div class="flex items-center space-x-3">
                        <a href="#" class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center hover:opacity-90"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center hover:opacity-90"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center hover:opacity-90"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-6 text-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Proats E-Catalog Showcase. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="mt-1 text-gray-400">Desain khusus Putih Gradient Kuning Tua (Deep Gold Aesthetic).</p>
            </div>
        </div>
    </footer>

    @auth
    <!-- Floating User Chat Widget (Only for Logged-In Users) -->
    <div x-data="userChatWidget()" class="fixed bottom-6 right-6 z-50">
        <!-- Chat Toggle Button -->
        <button @click="toggleChat()" class="relative bg-gradient-to-r from-amber-600 to-yellow-500 text-white w-14 h-14 rounded-full shadow-2xl flex items-center justify-center text-2xl hover:scale-105 transition duration-300">
            <i class="fas" :class="isOpen ? 'fa-xmark' : 'fa-headset'"></i>
            <span x-show="unreadCount > 0" x-cloak class="absolute -top-1 -right-1 bg-red-600 text-white font-bold text-[10px] w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow animate-bounce" x-text="unreadCount"></span>
        </button>

        <!-- Chat Popover Window -->
        <div x-show="isOpen" 
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="absolute bottom-16 right-0 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-amber-200 overflow-hidden flex flex-col h-[460px]">
            
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

    @yield('scripts')
</body>
</html>

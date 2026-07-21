@extends('layouts.app')

@section('title', 'Proats E-Catalog | Belanja Online Diskon & Flash Sale')

@section('content')
<div x-data="catalogApp()" x-init="initApp()" class="space-y-6">

    <!-- Toast Notification -->
    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-4 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-4 opacity-0"
         x-cloak
         class="fixed bottom-6 right-6 z-50 bg-slate-900/90 backdrop-blur text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3 border border-amber-500/30 text-sm">
        <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0">
            <i class="fas fa-check"></i>
        </div>
        <span x-text="toast.message" class="font-medium"></span>
    </div>

    <!-- Hero Banner Auto-Slide Carousel (No Cut Off, Solid Layering, Smooth Auto Slide) -->
    @php
        $slides = isset($banners) && count($banners) > 0 ? $banners : [
            (object)[
                'badge_text' => 'PROMO EKSKLUSIF ALAT MUSIK',
                'title' => 'Pusat Alat Musik Marching Band, Tradisional & Band',
                'subtitle' => 'Melayani pemesanan drumband, marching band HTS, instrumen etnik tradisional, hingga peralatan band profesional.',
                'button_text' => 'Jelajahi Instrumen',
                'button_url' => '#catalog-section',
                'image_url' => null,
                'bg_color_from' => 'amber-400',
                'bg_color_to' => 'amber-300'
            ]
        ];
    @endphp

    <div x-data="{
            currentSlide: 0,
            totalSlides: {{ count($slides) }},
            timer: null,
            startAutoSlide() {
                this.stopAutoSlide();
                if (this.totalSlides > 1) {
                    this.timer = setInterval(() => {
                        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                    }, 4500);
                }
            },
            stopAutoSlide() {
                if (this.timer) clearInterval(this.timer);
            }
         }"
         x-init="startAutoSlide()"
         @mouseenter="stopAutoSlide()"
         @mouseleave="startAutoSlide()"
         class="relative rounded-2xl overflow-hidden shadow-xs border border-amber-300 min-h-[230px] md:min-h-[250px] bg-amber-400 text-slate-950">
        
        <!-- Slides Container -->
        @foreach($slides as $index => $slide)
        <div x-show="currentSlide === {{ $index }}"
             x-transition:enter="transition opacity ease-out duration-600"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition opacity ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-cloak
             :class="currentSlide === {{ $index }} ? 'z-20' : 'z-10'"
             class="absolute inset-0 w-full h-full p-5 md:p-7 flex flex-col justify-between bg-gradient-to-r from-{{ $slide->bg_color_from ?? 'amber-400' }} via-yellow-400 to-{{ $slide->bg_color_to ?? 'amber-300' }} text-slate-950">
            
            @if(!empty($slide->image_url))
                <!-- Custom Background Image with Subtle Overlay -->
                <div class="absolute inset-0 z-0">
                    <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-950/60 to-slate-950/20"></div>
                </div>
                
                <div class="z-10 max-w-xl text-white">
                    @if(!empty($slide->badge_text))
                    <span class="inline-block px-3 py-1 bg-amber-400 text-slate-950 font-extrabold text-[11px] uppercase tracking-wider rounded-full mb-2 shadow-xs">
                        {{ $slide->badge_text }}
                    </span>
                    @endif
                    <h1 class="text-xl md:text-3xl font-extrabold leading-tight tracking-tight mb-2 text-white">
                        {{ $slide->title }}
                    </h1>
                    @if(!empty($slide->subtitle))
                    <p class="text-xs md:text-sm text-slate-200 font-semibold mb-3 drop-shadow-sm line-clamp-2">
                        {{ $slide->subtitle }}
                    </p>
                    @endif
                </div>

                <div class="z-10 flex flex-wrap items-center gap-2">
                    @if(!empty($slide->button_text))
                    <a href="{{ $slide->button_url ?? '#catalog-section' }}" class="px-4 py-2 bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs md:text-sm rounded-xl transition shadow-md flex items-center gap-2">
                        <i class="fas fa-drum text-slate-950"></i> {{ $slide->button_text }}
                    </a>
                    @endif
                    <span class="px-3 py-1.5 bg-slate-900/80 backdrop-blur rounded-xl text-amber-300 text-xs font-extrabold flex items-center gap-1.5 border border-slate-700 shadow-2xs">
                        <i class="fas fa-crown text-amber-400"></i> Katalog Resmi Proats
                    </span>
                </div>
            @else
                <!-- Styled Gradient Text Banner (Default) -->
                <div class="z-10 max-w-xl">
                    @if(!empty($slide->badge_text))
                    <span class="inline-block px-3 py-1 bg-slate-950 text-amber-300 font-extrabold text-[11px] uppercase tracking-wider rounded-full mb-2 shadow-xs">
                        {{ $slide->badge_text }}
                    </span>
                    @endif
                    <h1 class="text-xl md:text-3xl font-extrabold leading-tight tracking-tight mb-2 text-slate-950">
                        {{ $slide->title }}
                    </h1>
                    @if(!empty($slide->subtitle))
                    <p class="text-xs md:text-sm text-slate-900 font-semibold mb-3 line-clamp-2">
                        {{ $slide->subtitle }}
                    </p>
                    @endif
                </div>
                <div class="z-10 flex flex-wrap items-center gap-2">
                    @if(!empty($slide->button_text))
                    <a href="{{ $slide->button_url ?? '#catalog-section' }}" class="px-4 py-2 bg-slate-950 text-amber-300 font-extrabold text-xs md:text-sm rounded-xl hover:bg-black transition shadow-md flex items-center gap-2">
                        <i class="fas fa-drum text-amber-400"></i> {{ $slide->button_text }}
                    </a>
                    @endif
                    <span class="px-3 py-1.5 bg-white/70 backdrop-blur rounded-xl text-slate-950 text-xs font-extrabold flex items-center gap-1.5 border border-white/70 shadow-2xs">
                        <i class="fas fa-crown text-amber-700"></i> Katalog Resmi Toko Alat Musik Proats
                    </span>
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-15 pointer-events-none text-slate-950 z-0">
                    <i class="fas fa-music text-[200px]"></i>
                </div>
            @endif

        </div>
        @endforeach

    </div>

    <!-- Category Highlights Section -->
    <div class="bg-white rounded-2xl shadow-xs border border-amber-100 p-4 md:p-6">
        <h2 class="text-sm md:text-base font-bold text-gray-800 uppercase tracking-wider mb-4 flex items-center gap-2">
            <i class="fas fa-th-large text-amber-600"></i> Kategori Instrumen Musik
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-6 gap-3 md:gap-4">
            <button @click="filterByCategory('all')" 
                    :class="selectedCategory === 'all' ? 'border-amber-500 bg-amber-50 text-amber-900 font-extrabold shadow-xs' : 'border-gray-100 hover:border-amber-300 text-gray-700'"
                    class="flex flex-col items-center justify-center p-3 rounded-2xl border transition group text-center">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl mb-2 group-hover:scale-110 transition border border-amber-200">
                    <i class="fas fa-globe"></i>
                </div>
                <span class="text-xs font-semibold line-clamp-1">Semua</span>
            </button>
            @foreach($categories as $cat)
            <button @click="filterByCategory('{{ $cat->slug }}')" 
                    :class="selectedCategory === '{{ $cat->slug }}' ? 'border-amber-500 bg-amber-50 text-amber-900 font-extrabold shadow-xs' : 'border-gray-100 hover:border-amber-300 text-gray-700'"
                    class="flex flex-col items-center justify-center p-3 rounded-2xl border transition group text-center">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl mb-2 group-hover:scale-110 transition border border-amber-200">
                    @if($cat->slug === 'marching-band-drumband')
                        <i class="fas fa-drum"></i>
                    @elseif($cat->slug === 'musik-tradisional')
                        <i class="fas fa-drum-steelpan"></i>
                    @elseif($cat->slug === 'alat-musik-band')
                        <i class="fas fa-guitar"></i>
                    @elseif($cat->slug === 'keyboard-piano')
                        <i class="fas fa-sliders"></i>
                    @elseif($cat->slug === 'aksesoris-sound-system')
                        <i class="fas fa-headphones"></i>
                    @else
                        <i class="fas fa-music"></i>
                    @endif
                </div>
                <span class="text-xs font-semibold line-clamp-1">{{ $cat->name }}</span>
            </button>
            @endforeach
        </div>
    </div>

    <!-- Main Catalog Section -->
    <div id="catalog-section" class="grid grid-cols-1 lg:grid-cols-4 gap-6 pt-2">

        <!-- Sidebar Filter -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xs border border-amber-100 p-5 sticky top-24 space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fas fa-filter text-amber-600"></i> FILTER PRODUK
                    </h3>
                    <button @click="resetFilters()" class="text-xs text-amber-600 hover:underline font-semibold">
                        Reset
                    </button>
                </div>

                <!-- Filter Category -->
                <div>
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2.5">Kategori</h4>
                    <div class="space-y-1 text-xs font-medium">
                        <label class="flex items-center gap-2 cursor-pointer p-1.5 rounded hover:bg-amber-50">
                            <input type="radio" name="cat" value="all" x-model="selectedCategory" @change="applyFilters()" class="text-amber-600 focus:ring-amber-500 accent-amber-500">
                            <span>Semua Kategori</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center justify-between cursor-pointer p-1.5 rounded hover:bg-amber-50">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="cat" value="{{ $cat->slug }}" x-model="selectedCategory" @change="applyFilters()" class="text-amber-600 focus:ring-amber-500 accent-amber-500">
                                <span class="text-gray-700">{{ $cat->name }}</span>
                            </div>
                            <span class="text-[10px] text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded-full">({{ $cat->products_count }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Filter Rating -->
                <div class="border-t border-gray-100 pt-4">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2.5">Bintang Rating</h4>
                    <div class="space-y-1 text-xs">
                        <template x-for="stars in [5, 4, 3]" :key="stars">
                            <label class="flex items-center gap-2 cursor-pointer p-1 rounded hover:bg-amber-50">
                                <input type="radio" name="rating_filter" :value="stars" x-model="ratingFilter" @change="applyFilters()" class="text-amber-600 focus:ring-amber-500 accent-amber-500">
                                <div class="flex items-center text-amber-500 text-xs">
                                    <template x-for="i in stars"><i class="fas fa-star"></i></template>
                                    <span class="ml-1.5 text-gray-600 font-semibold" x-text="stars + ' Bintang & Ke atas'"></span>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>

                <!-- Filter Price Range -->
                <div class="border-t border-gray-100 pt-4">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2.5">Batas Harga (Rp)</h4>
                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <input type="number" x-model="minPrice" placeholder="MIN" class="w-full p-2 border border-gray-200 rounded text-xs focus:ring-amber-500 focus:border-amber-500">
                        <input type="number" x-model="maxPrice" placeholder="MAX" class="w-full p-2 border border-gray-200 rounded text-xs focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <button @click="applyFilters()" class="w-full py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-extrabold rounded-xl transition shadow-xs">
                        Terapkan Harga
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Grid & Sort Controls -->
        <div class="lg:col-span-3 space-y-4">

            <!-- Sorting Bar -->
            <div class="bg-white rounded-2xl shadow-xs border border-amber-100 p-3 md:p-4 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-gray-500 font-semibold">Urutkan:</span>
                    <button @click="setSort('popular')" 
                            :class="sort === 'popular' ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-3.5 py-1.5 rounded-xl font-bold transition">
                        Terlaris
                    </button>
                    <button @click="setSort('latest')" 
                            :class="sort === 'latest' ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-3.5 py-1.5 rounded-xl font-bold transition">
                        Terbaru
                    </button>
                    <button @click="setSort('discount')" 
                            :class="sort === 'discount' ? 'bg-amber-500 text-slate-950 font-extrabold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-3.5 py-1.5 rounded-xl font-bold transition">
                        Diskon Terbesar
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <select x-model="sort" @change="applyFilters()" class="bg-gray-100 border-none text-xs font-bold text-gray-700 rounded-xl px-3 py-1.5 focus:ring-amber-500">
                        <option value="popular">Terpopular</option>
                        <option value="price_asc">Harga: Rendah ke Tinggi</option>
                        <option value="price_desc">Harga: Tinggi ke Rendah</option>
                    </select>
                </div>
            </div>

            <!-- Loading Spinner -->
            <div x-show="loading" class="py-16 text-center" x-cloak>
                <div class="inline-block animate-spin text-amber-600 text-4xl mb-2">
                    <i class="fas fa-spinner"></i>
                </div>
                <p class="text-xs text-gray-500 font-medium">Memuat catalog produk...</p>
            </div>

            <!-- Empty State -->
            <div x-show="!loading && products.length === 0" class="bg-white rounded-2xl shadow-xs border border-amber-100 p-12 text-center" x-cloak>
                <div class="w-20 h-20 mx-auto bg-amber-50 rounded-full flex items-center justify-center text-amber-600 text-3xl mb-4 border border-amber-100">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800 mb-1">Produk Tidak Ditemukan</h3>
                <p class="text-xs text-gray-500 mb-4">Coba sesuaikan pencarian atau filter kata kunci Anda.</p>
                <button @click="resetFilters()" class="px-4 py-2 bg-amber-500 text-slate-950 text-xs font-extrabold rounded-xl shadow-xs hover:bg-amber-600 transition">
                    Lihat Semua Produk
                </button>
            </div>

            <!-- Products Card Grid -->
            <div x-show="!loading && products.length > 0" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-4">
                <template x-for="product in products" :key="product.id">
                    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-xs hover:shadow-lg hover:border-amber-300 transition duration-300 flex flex-col justify-between group cursor-pointer"
                         @click="openDetail(product.id)">
                        
                        <div>
                            <!-- Product Image & Badges -->
                            <div class="relative aspect-square overflow-hidden bg-gray-50">
                                <img :src="product.image_url" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                
                                <template x-if="product.discount_percent > 0">
                                    <div class="absolute top-0 right-0 bg-amber-500 text-slate-950 text-[11px] font-black px-2 py-0.5 rounded-bl-lg shadow-xs">
                                        -<span x-text="product.discount_percent"></span>%
                                    </div>
                                </template>
                            </div>

                            <!-- Product Info -->
                            <div class="p-3">
                                <h3 class="text-xs md:text-sm font-semibold text-gray-800 line-clamp-2 leading-snug group-hover:text-amber-600 transition mb-2" x-text="product.name"></h3>
                                
                                <div class="flex items-baseline gap-1.5 mb-1.5">
                                    <span class="text-amber-700 font-extrabold text-sm md:text-base" x-text="product.formatted_price"></span>
                                    <template x-if="product.original_price">
                                        <span class="text-[10px] text-gray-400 line-through font-medium" x-text="product.formatted_original_price"></span>
                                    </template>
                                </div>

                                <div class="flex items-center justify-between text-[11px] text-gray-500 pt-1 border-t border-gray-50">
                                    <div class="flex items-center text-amber-500">
                                        <i class="fas fa-star text-[10px]"></i>
                                        <span class="ml-1 font-bold text-gray-700" x-text="product.rating"></span>
                                    </div>
                                    <span x-text="'Terjual ' + product.formatted_sold"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Location & Quick Add Button -->
                        <div class="p-3 pt-0 flex items-center justify-between gap-2">
                            <span class="text-[10px] text-gray-400 flex items-center gap-1 truncate">
                                <i class="fas fa-location-dot text-gray-300"></i> <span x-text="product.location"></span>
                            </span>
                            <button @click.stop="quickAddToCart(product)" 
                                    class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-500 hover:text-slate-950 transition flex items-center justify-center shrink-0 shadow-xs border border-amber-200"
                                    title="Tambah ke Keranjang">
                                <i class="fas fa-cart-plus text-xs"></i>
                            </button>
                        </div>

                    </div>
                </template>
            </div>

        </div>
    </div>

    <!-- Product Detail Modal -->
    <div x-show="detailModal.show" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-3 md:p-6">
        <div @click.away="detailModal.show = false"
             x-show="detailModal.show"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="scale-95 opacity-0"
             x-transition:enter-end="scale-100 opacity-100"
             class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden relative border border-gray-100">
            
            <button @click="detailModal.show = false" class="absolute top-3 right-3 z-20 w-9 h-9 rounded-full bg-white/90 shadow-md hover:bg-gray-100 text-gray-700 flex items-center justify-center transition border border-gray-200">
                <i class="fas fa-xmark text-lg"></i>
            </button>

            <template x-if="detailModal.product">
                <div class="overflow-y-auto max-h-[90vh] p-4 md:p-6 space-y-4">
                    
                    <!-- Top Info: Compact Photo + Main Details -->
                    <div class="flex flex-col sm:flex-row gap-5 items-start">
                        
                        <!-- Clean Clickable Product Photo -->
                        <div @click.stop="openFullImage(detailModal.product.image_url)" 
                             class="w-full sm:w-44 sm:h-44 md:w-48 md:h-48 aspect-square rounded-2xl overflow-hidden shadow-xs relative group cursor-pointer border border-gray-200 shrink-0 bg-gray-50 mx-auto sm:mx-0">
                            
                            <img :src="detailModal.product.image_url" 
                                 :alt="detailModal.product.name" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>

                        <!-- Right Column: Details & Pricing -->
                        <div class="flex-grow space-y-3 w-full">
                            <div>
                                <span class="text-xs font-bold uppercase text-amber-600 tracking-wider" x-text="detailModal.product.category_name"></span>
                                <h2 class="text-lg md:text-xl font-bold text-gray-900 leading-snug mt-0.5" x-text="detailModal.product.name"></h2>

                                <div class="flex flex-wrap items-center gap-2.5 text-xs mt-2 text-gray-600 border-b border-gray-100 pb-2.5">
                                    <div class="flex items-center text-amber-500 font-bold">
                                        <i class="fas fa-star mr-1"></i>
                                        <span x-text="detailModal.product.rating"></span>
                                    </div>
                                    <span>|</span>
                                    <span class="font-semibold" x-text="detailModal.product.formatted_sold + ' Terjual'"></span>
                                    <span>|</span>
                                    <span class="text-emerald-600 font-semibold"><i class="fas fa-circle-check"></i> Garansi Original</span>
                                </div>

                                <div class="bg-amber-50 border border-amber-200/60 p-3.5 rounded-2xl mt-3 flex items-baseline gap-3">
                                    <span class="text-2xl md:text-3xl font-extrabold text-amber-800" x-text="detailModal.product.formatted_price"></span>
                                    <template x-if="detailModal.product.original_price">
                                        <span class="text-xs text-gray-400 line-through" x-text="detailModal.product.formatted_original_price"></span>
                                    </template>
                                    <template x-if="detailModal.product.discount_percent > 0">
                                        <span class="bg-amber-500 text-slate-950 text-xs font-bold px-2 py-0.5 rounded">
                                            DISKON <span x-text="detailModal.product.discount_percent"></span>%
                                        </span>
                                    </template>
                                </div>

                                <template x-if="detailModal.product.variants && detailModal.product.variants.length > 0">
                                    <div class="mt-3">
                                        <label class="text-xs font-bold text-gray-700 block mb-1.5">Pilih Varian:</label>
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="variant in detailModal.product.variants" :key="variant">
                                                <button @click="selectedVariant = variant"
                                                        :class="selectedVariant === variant ? 'border-amber-500 text-amber-800 bg-amber-50 font-bold shadow-xs' : 'border-gray-200 text-gray-700 hover:border-gray-300'"
                                                        class="px-3 py-1 border rounded-xl text-xs transition">
                                                    <span x-text="variant"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <div class="mt-3 flex items-center gap-4">
                                    <label class="text-xs font-bold text-gray-700">Jumlah:</label>
                                    <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden text-xs">
                                        <button @click="if(detailQty > 1) detailQty--" class="px-3 py-1 bg-gray-50 hover:bg-gray-100 font-bold text-gray-600">-</button>
                                        <span x-text="detailQty" class="px-4 font-bold text-gray-800"></span>
                                        <button @click="detailQty++" class="px-3 py-1 bg-gray-50 hover:bg-gray-100 font-bold text-gray-600">+</button>
                                    </div>
                                    <span class="text-[11px] text-gray-400" x-text="'Stok: ' + detailModal.product.stock"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="bg-gray-50/70 p-3 rounded-2xl border border-gray-100 text-xs text-gray-600">
                        <h4 class="font-bold text-gray-800 mb-1 flex items-center gap-1.5"><i class="fas fa-align-left text-amber-600"></i> Deskripsi Produk</h4>
                        <p x-text="detailModal.product.description" class="leading-relaxed"></p>
                    </div>

                    <!-- Interactive Star Rating & Review Section -->
                    <div class="border-t border-amber-100 pt-3 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <h4 class="font-extrabold text-xs text-gray-900 flex items-center gap-1.5">
                                <i class="fas fa-star text-amber-500"></i> Ulasan & Rating Pelanggan
                            </h4>
                            <span class="text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200" x-text="productReviews.rating_count + ' Ulasan'"></span>
                        </div>

                        <!-- Star Picker Form (Give Rating) -->
                        <div class="bg-amber-50/60 rounded-xl p-2.5 border border-amber-100 space-y-2">
                            <p class="text-[11px] font-bold text-gray-800">Berikan Bintang & Ulasan Anda:</p>
                            
                            <!-- Interactive 5-Star Picker -->
                            <div class="flex items-center gap-1 text-base cursor-pointer">
                                <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                    <i class="fas fa-star transition"
                                       @click="userRating = star"
                                       @mouseenter="hoverRating = star"
                                       @mouseleave="hoverRating = 0"
                                       :class="(hoverRating || userRating) >= star ? 'text-amber-500 scale-110' : 'text-gray-300'"></i>
                                </template>
                                <span class="text-xs font-bold text-gray-700 ml-2" x-text="userRating > 0 ? userRating + ' / 5 Bintang' : 'Pilih bintang'"></span>
                            </div>

                            <textarea x-model="userComment" 
                                      placeholder="Tulis ulasan pengalaman Anda..." 
                                      rows="2" 
                                      class="w-full text-xs p-2 bg-white border border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>

                            <button @click="submitStarReview()" 
                                    :disabled="userRating === 0" 
                                    class="w-full py-1.5 bg-amber-500 hover:bg-amber-600 disabled:opacity-50 text-slate-950 font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-1.5">
                                <i class="fas fa-paper-plane text-xs"></i> Kirim Ulasan Bintang
                            </button>
                        </div>

                        <!-- Reviews Thread List -->
                        <div class="max-h-28 overflow-y-auto space-y-2 text-xs pr-1">
                            <template x-if="productReviews.reviews.length === 0">
                                <p class="text-[11px] text-gray-400 italic text-center py-1.5">Belum ada ulasan. Jadilah yang pertama memberikan bintang!</p>
                            </template>

                            <template x-for="rev in productReviews.reviews" :key="rev.id">
                                <div class="bg-gray-50 rounded-xl p-2 border border-gray-100 space-y-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <img :src="rev.user_avatar" class="w-5 h-5 rounded-full object-cover border">
                                            <span class="font-bold text-gray-800 text-[11px]" x-text="rev.user_name"></span>
                                        </div>
                                        <div class="flex items-center text-amber-500 text-[10px]">
                                            <template x-for="s in [1, 2, 3, 4, 5]" :key="s">
                                                <i class="fas fa-star" :class="s <= rev.rating ? 'text-amber-500' : 'text-gray-200'"></i>
                                            </template>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-gray-600 pl-7" x-text="rev.comment"></p>
                                    <span class="text-[9px] text-gray-400 block text-right" x-text="rev.time_ago"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Bottom Action Buttons -->
                    <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-100 sticky bottom-0 bg-white">
                        <button @click="addToCartFromModal(false)" 
                                class="py-2.5 px-4 border border-amber-500 text-amber-800 bg-amber-50 hover:bg-amber-100 font-bold text-xs rounded-xl transition flex items-center justify-center gap-2 shadow-xs">
                            <i class="fas fa-cart-plus text-sm"></i> Tambah Keranjang
                        </button>
                        <button @click="addToCartFromModal(true)" 
                                class="py-2.5 px-4 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs rounded-xl transition shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-bag-shopping text-sm"></i> Beli Sekarang
                        </button>
                    </div>

                </div>
            </template>
        </div>
    </div>

    <!-- Sliding Cart Drawer -->
    <div x-data
         @open-cart.window="cartDrawerOpen = true"
         x-show="cartDrawerOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-hidden bg-black/50 backdrop-blur-xs">
        
        <div @click.away="cartDrawerOpen = false"
             x-show="cartDrawerOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="absolute inset-y-0 right-0 max-w-md w-full bg-white shadow-2xl flex flex-col justify-between">
            
            <div class="p-4 bg-amber-400 text-slate-950 border-b border-amber-300 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shopping-bag text-xl"></i>
                    <h2 class="font-extrabold text-base">Keranjang Belanja</h2>
                    <span class="bg-slate-950 text-amber-300 text-xs px-2 py-0.5 rounded-full font-bold" x-text="$store.cart.count() + ' item'"></span>
                </div>
                <button @click="cartDrawerOpen = false" class="text-slate-950 hover:text-amber-900 text-xl font-bold p-1">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <div class="flex-grow overflow-y-auto p-4 space-y-4 divide-y divide-gray-100">
                <template x-if="$store.cart.items.length === 0">
                    <div class="py-20 text-center">
                        <div class="w-16 h-16 mx-auto bg-amber-100 text-amber-700 rounded-full flex items-center justify-center text-2xl mb-3">
                            <i class="fas fa-cart-arrow-down"></i>
                        </div>
                        <p class="font-bold text-gray-700 text-sm">Keranjang Kamu Masih Kosong</p>
                        <p class="text-xs text-gray-400 mt-1">Yuk cari produk impianmu dan tambahkan sekarang!</p>
                    </div>
                </template>

                <template x-for="(item, index) in $store.cart.items" :key="index">
                    <div class="pt-3 flex gap-3 items-center">
                        <img :src="item.image_url" :alt="item.name" class="w-16 h-16 object-cover rounded-xl border border-gray-100 shrink-0">
                        <div class="flex-grow">
                            <h4 class="text-xs font-bold text-gray-800 line-clamp-1" x-text="item.name"></h4>
                            <template x-if="item.variant">
                                <span class="text-[10px] bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded" x-text="'Varian: ' + item.variant"></span>
                            </template>
                            <div class="text-amber-700 font-extrabold text-xs mt-1" x-text="formatRp(item.price)"></div>
                            
                            <div class="flex items-center justify-between mt-2">
                                <div class="flex items-center border border-gray-200 rounded-lg text-xs">
                                    <button @click="$store.cart.updateQty(index, item.qty - 1)" class="px-2 py-0.5 bg-gray-50 font-bold">-</button>
                                    <span class="px-3 font-semibold" x-text="item.qty"></span>
                                    <button @click="$store.cart.updateQty(index, item.qty + 1)" class="px-2 py-0.5 bg-gray-50 font-bold">+</button>
                                </div>
                                <button @click="$store.cart.removeItem(index)" class="text-gray-400 hover:text-red-500 text-xs">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <template x-if="$store.cart.items.length > 0">
                <div class="p-4 border-t border-gray-100 bg-gray-50 space-y-3">
                    <div>
                        <div class="flex gap-2">
                            <input type="text" x-model="voucherCode" placeholder="Masukkan kode voucher (ONGKIRFREE / SHOPEE10K)" class="w-full text-xs p-2 border rounded-xl focus:ring-amber-500 uppercase">
                            <button @click="$store.cart.applyVoucher(voucherCode)" class="px-3 py-2 bg-gray-800 text-white text-xs font-bold rounded-xl hover:bg-black transition">
                                Pakai
                            </button>
                        </div>
                        <template x-if="$store.cart.voucher">
                            <p class="text-[11px] text-emerald-600 font-bold mt-1 flex items-center gap-1">
                                <i class="fas fa-check-circle"></i> Voucher "<span x-text="$store.cart.voucher"></span>" berhasil dipasang!
                            </p>
                        </template>
                    </div>

                    <div class="text-xs space-y-1 text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal Produk:</span>
                            <span class="font-bold" x-text="formatRp($store.cart.subtotal())"></span>
                        </div>
                        <div class="flex justify-between text-emerald-600" x-show="$store.cart.discount() > 0">
                            <span>Diskon Voucher:</span>
                            <span class="font-bold" x-text="'-' + formatRp($store.cart.discount())"></span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-2 text-sm font-extrabold text-gray-900">
                            <span>Total Pembayaran:</span>
                            <span class="text-amber-700 text-base" x-text="formatRp($store.cart.total())"></span>
                        </div>
                    </div>

                    <button @click="openCheckoutModal()" class="w-full py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-credit-card"></i> Process Checkout / Pesan WA
                    </button>
                </div>
            </template>
        </div>
    </div>

    <!-- Order Checkout Modal -->
    <div x-show="checkoutModal" x-cloak class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl p-6 relative border border-gray-100">
            <button @click="checkoutModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-xmark text-xl"></i>
            </button>
            <div class="text-center mb-4">
                <div class="w-14 h-14 bg-amber-100 text-amber-700 rounded-full flex items-center justify-center mx-auto text-2xl mb-2">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Simulasi Checkout Proats</h3>
                <p class="text-xs text-gray-500">Lengkapi detail pengiriman untuk memproses order.</p>
            </div>

            <form @submit.prevent="submitOrder()" class="space-y-3 text-xs">
                <div>
                    <label class="font-bold text-gray-700 block mb-1">Nama Penerima</label>
                    <input type="text" x-model="customer.name" required placeholder="Contoh: Alvian Ahmad" class="w-full p-2.5 border rounded-xl focus:ring-amber-500">
                </div>
                <div>
                    <label class="font-bold text-gray-700 block mb-1">Nomor WhatsApp</label>
                    <input type="text" x-model="customer.phone" required placeholder="Contoh: 081234567890" class="w-full p-2.5 border rounded-xl focus:ring-amber-500">
                </div>
                <div>
                    <label class="font-bold text-gray-700 block mb-1">Alamat Lengkap</label>
                    <textarea x-model="customer.address" required rows="2" placeholder="Jl. Sudirman No. 123, Jakarta" class="w-full p-2.5 border rounded-xl focus:ring-amber-500"></textarea>
                </div>
                <div>
                    <label class="font-bold text-gray-700 block mb-1">Metode Pembayaran</label>
                    <select x-model="customer.payment" class="w-full p-2.5 border rounded-xl focus:ring-amber-500 font-semibold">
                        <option value="Proats Pay">Proats Pay (Gratis Admin)</option>
                        <option value="COD">COD (Bayar di Tempat)</option>
                        <option value="Transfer Bank BCA/Mandiri">Transfer Bank (BCA / Mandiri)</option>
                        <option value="QRIS">QRIS All Payment</option>
                    </select>
                </div>

                <div class="pt-3 border-t border-gray-100 flex items-center justify-between font-bold text-sm">
                    <span>Total Tagihan:</span>
                    <span class="text-amber-700 text-base" x-text="formatRp($store.cart.total())"></span>
                </div>

                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md transition flex items-center justify-center gap-2 mt-2">
                    <i class="fab fa-whatsapp text-lg"></i> Kirim Order via WhatsApp Seller
                </button>
            </form>
        </div>
    </div>

    <!-- Require Login Modal Popup -->
    <div x-show="requireLoginModal" x-cloak class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full shadow-2xl p-6 text-center relative border border-amber-100">
            <button @click="requireLoginModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-xmark text-xl"></i>
            </button>
            <div class="w-16 h-16 bg-amber-100 text-amber-700 rounded-2xl flex items-center justify-center mx-auto text-3xl mb-3 shadow-sm">
                <i class="fas fa-lock"></i>
            </div>
            <h3 class="text-lg font-extrabold text-gray-900 mb-1">Login Terlebih Dahulu</h3>
            <p class="text-xs text-gray-500 mb-5 leading-relaxed">
                Anda harus masuk ke akun Proats terlebih dahulu untuk melakukan proses checkout & pemesanan.
            </p>

            <div class="space-y-2.5">
                <a href="{{ route('auth.google') }}" class="w-full py-3 px-4 bg-white hover:bg-gray-50 text-gray-700 font-bold border border-gray-200 rounded-xl shadow-sm transition flex items-center justify-center gap-2.5 text-xs">
                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                        <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.11-6.72-4.96H1.26v3.15C3.24 21.3 7.31 24 12 24z"/>
                        <path fill="#FBBC05" d="M5.28 14.24c-.25-.72-.38-1.49-.38-2.24s.13-1.52.38-2.24V6.61H1.26C.46 8.23 0 10.06 0 12s.46 3.77 1.26 5.39l4.02-3.15z"/>
                        <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.24 2.7 1.26 6.61l4.02 3.15c.95-2.85 3.6-4.96 6.72-4.96z"/>
                    </svg>
                    <span>Masuk Instant via Google</span>
                </a>
                
                <a href="{{ route('login') }}" class="w-full py-3 px-4 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-md transition block text-xs">
                    Masuk dengan Email / Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- Standalone Photo Only Popup Modal -->
    <div x-show="fullImageModal.show" 
         x-cloak 
         @click.self="fullImageModal.show = false"
         @keydown.escape.window="fullImageModal.show = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] bg-white/80 backdrop-blur-md flex items-center justify-center p-3 md:p-6 cursor-pointer">
        
        <div x-show="fullImageModal.show"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="scale-90 opacity-0"
             x-transition:enter-end="scale-100 opacity-100"
             class="relative max-w-4xl max-h-[88vh] bg-white/95 backdrop-blur-xl rounded-3xl p-3 md:p-4 border border-amber-200/80 shadow-2xl flex flex-col items-center justify-center overflow-hidden cursor-default">
            
            <!-- Close Button (X) -->
            <button @click="fullImageModal.show = false" 
                    title="Tutup Foto"
                    class="absolute top-3 right-3 z-30 w-10 h-10 rounded-full bg-slate-950 hover:bg-amber-500 text-white hover:text-slate-950 font-bold transition flex items-center justify-center border border-amber-300 shadow-md cursor-pointer">
                <i class="fas fa-xmark text-lg"></i>
            </button>

            <!-- Big Photo Only -->
            <img :src="fullImageModal.url" class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-lg border border-gray-200/80">
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('cart', {
            items: JSON.parse(localStorage.getItem('proats_cart') || '[]'),
            voucher: localStorage.getItem('proats_voucher') || '',

            save() {
                localStorage.setItem('proats_cart', JSON.stringify(this.items));
                localStorage.setItem('proats_voucher', this.voucher);
            },

            addItem(product, variant = '', qty = 1) {
                const existing = this.items.find(i => i.id === product.id && i.variant === variant);
                if (existing) {
                    existing.qty += qty;
                } else {
                    this.items.push({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        image_url: product.image_url,
                        variant: variant,
                        qty: qty
                    });
                }
                this.save();
            },

            removeItem(index) {
                this.items.splice(index, 1);
                this.save();
            },

            updateQty(index, qty) {
                if (qty <= 0) {
                    this.removeItem(index);
                } else {
                    this.items[index].qty = qty;
                    this.save();
                }
            },

            count() {
                return this.items.reduce((acc, item) => acc + item.qty, 0);
            },

            subtotal() {
                return this.items.reduce((acc, item) => acc + (item.price * item.qty), 0);
            },

            discount() {
                if (!this.voucher) return 0;
                if (this.voucher.toUpperCase() === 'ONGKIRFREE') return 20000;
                if (this.voucher.toUpperCase() === 'SHOPEE10K') return 10000;
                if (this.voucher.toUpperCase() === 'DISKON50') return this.subtotal() * 0.5;
                return 0;
            },

            total() {
                const result = this.subtotal() - this.discount();
                return result < 0 ? 0 : result;
            },

            applyVoucher(code) {
                this.voucher = code.trim();
                this.save();
            },

            clear() {
                this.items = [];
                this.voucher = '';
                this.save();
            }
        });
    });

    function catalogApp() {
        return {
            loading: false,
            products: @json($products),
            selectedCategory: '{{ request("category", "all") }}',
            searchQuery: '{{ request("search", "") }}',
            minPrice: '{{ request("min_price", "") }}',
            maxPrice: '{{ request("max_price", "") }}',
            ratingFilter: '{{ request("rating", "") }}',
            badgeFilter: [],
            sort: '{{ request("sort", "popular") }}',

            isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            requireLoginModal: false,
            cartDrawerOpen: false,
            checkoutModal: false,
            voucherCode: '',

            fullImageModal: {
                show: false,
                url: ''
            },
            openFullImage(url) {
                this.fullImageModal.url = url;
                this.fullImageModal.show = true;
            },

            isPhotoZoomed: false,

            detailModal: {
                show: false,
                product: null
            },
            selectedVariant: '',
            detailQty: 1,

            userRating: 5,
            hoverRating: 0,
            userComment: '',
            productReviews: { average_rating: 4.9, rating_count: 0, reviews: [] },

            toast: {
                show: false,
                message: ''
            },

            customer: {
                name: @json(Auth::user()->name ?? 'Alvian Ahmad'),
                phone: '081234567890',
                address: 'Jl. Sudirman No. 88, Jakarta Selatan',
                payment: 'Proats Pay'
            },

            timer: {
                hours: '02',
                minutes: '14',
                seconds: '35'
            },

            initApp() {
                this.startTimer();
            },

            startTimer() {
                let totalSec = 8075;
                setInterval(() => {
                    if (totalSec > 0) totalSec--;
                    const h = Math.floor(totalSec / 3600);
                    const m = Math.floor((totalSec % 3600) / 60);
                    const s = totalSec % 60;
                    this.timer.hours = h < 10 ? '0' + h : h;
                    this.timer.minutes = m < 10 ? '0' + m : m;
                    this.timer.seconds = s < 10 ? '0' + s : s;
                }, 1000);
            },

            showToast(msg) {
                this.toast.message = msg;
                this.toast.show = true;
                setTimeout(() => { this.toast.show = false; }, 3000);
            },

            formatRp(num) {
                return 'Rp' + new Intl.NumberFormat('id-ID').format(num);
            },

            filterByCategory(slug) {
                this.selectedCategory = slug;
                this.applyFilters();
            },

            setSort(sortType) {
                this.sort = sortType;
                this.applyFilters();
            },

            applyFilters() {
                this.loading = true;
                const params = new URLSearchParams();
                
                if (this.selectedCategory && this.selectedCategory !== 'all') params.append('category', this.selectedCategory);
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.minPrice) params.append('min_price', this.minPrice);
                if (this.maxPrice) params.append('max_price', this.maxPrice);
                if (this.ratingFilter) params.append('rating', this.ratingFilter);
                if (this.sort) params.append('sort', this.sort);
                if (this.badgeFilter.length > 0) params.append('badge', this.badgeFilter[0]);

                fetch('/api/products?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    this.products = data.products;
                    this.loading = false;
                })
                .catch(err => {
                    console.error(err);
                    this.loading = false;
                });
            },

            resetFilters() {
                this.selectedCategory = 'all';
                this.searchQuery = '';
                this.minPrice = '';
                this.maxPrice = '';
                this.ratingFilter = '';
                this.badgeFilter = [];
                this.sort = 'popular';
                this.applyFilters();
            },

            openDetail(id) {
                fetch('/product/' + id)
                    .then(res => res.json())
                    .then(data => {
                        this.detailModal.product = data.product;
                        this.selectedVariant = (data.product.variants && data.product.variants.length > 0) ? data.product.variants[0] : '';
                        this.detailQty = 1;
                        this.isPhotoZoomed = false;
                        this.userRating = 5;
                        this.userComment = '';
                        this.detailModal.show = true;
                        this.fetchProductReviews(id);
                    });
            },

            fetchProductReviews(productId) {
                fetch('/api/products/' + productId + '/reviews')
                    .then(r => r.json())
                    .then(d => {
                        this.productReviews = d;
                    });
            },

            submitStarReview() {
                if (!this.isLoggedIn) {
                    this.requireLoginModal = true;
                    return;
                }
                if (!this.detailModal.product || this.userRating === 0) return;

                fetch('/api/products/' + this.detailModal.product.id + '/reviews', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        rating: this.userRating,
                        comment: this.userComment
                    })
                })
                .then(r => r.json())
                .then(d => {
                    if (d.success) {
                        this.showToast(d.message);
                        this.userComment = '';
                        this.fetchProductReviews(this.detailModal.product.id);
                        if (this.detailModal.product) {
                            this.detailModal.product.rating = d.average_rating;
                        }
                    } else if (d.error) {
                        this.showToast(d.error);
                    }
                });
            },

            quickAddToCart(product) {
                const variant = (product.variants && product.variants.length > 0) ? product.variants[0] : '';
                Alpine.store('cart').addItem(product, variant, 1);
                this.showToast('Produk ditambahkan ke keranjang!');
            },

            addToCartFromModal(isBuyNow = false) {
                if (this.detailModal.product) {
                    Alpine.store('cart').addItem(this.detailModal.product, this.selectedVariant, this.detailQty);
                    this.detailModal.show = false;
                    if (isBuyNow) {
                        if (!this.isLoggedIn) {
                            this.requireLoginModal = true;
                        } else {
                            this.cartDrawerOpen = true;
                        }
                    } else {
                        this.showToast('Produk berhasil masuk keranjang!');
                    }
                }
            },

            openCheckoutModal() {
                if (!this.isLoggedIn) {
                    this.requireLoginModal = true;
                    return;
                }
                this.checkoutModal = true;
            },

            submitOrder() {
                const cart = Alpine.store('cart');
                let text = `*ORDER PROATS CATALOG*\n\n`;
                text += `👤 *Nama:* ${this.customer.name}\n`;
                text += `📞 *No HP:* ${this.customer.phone}\n`;
                text += `📍 *Alamat:* ${this.customer.address}\n`;
                text += `💳 *Pembayaran:* ${this.customer.payment}\n\n`;
                text += `🛒 *Item Pesanan:*\n`;

                cart.items.forEach((item, idx) => {
                    text += `${idx + 1}. ${item.name} (${item.variant || 'Standard'}) x${item.qty} = ${this.formatRp(item.price * item.qty)}\n`;
                });

                if (cart.voucher) {
                    text += `\n🎟️ *Voucher (${cart.voucher}):* -${this.formatRp(cart.discount())}\n`;
                }

                text += `\n💰 *TOTAL BAYAR:* ${this.formatRp(cart.total())}\n`;
                text += `\nTerima kasih sudah berbelanja di Proats E-Catalog!`;

                const encoded = encodeURIComponent(text);
                const waUrl = `https://wa.me/6281234567890?text=${encoded}`;
                
                cart.clear();
                this.checkoutModal = false;
                this.cartDrawerOpen = false;
                this.showToast('Pesanan berhasil dibuat! Membuka WhatsApp...');
                window.open(waUrl, '_blank');
            }
        }
    }
</script>
@endsection

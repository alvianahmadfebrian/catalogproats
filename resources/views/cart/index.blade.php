@extends('layouts.app')

@section('title', 'Keranjang Belanja - Proats E-Catalog')

@section('content')
<div x-data="cartPageApp()" class="max-w-4xl mx-auto space-y-6 my-4">

    <!-- Page Title Header -->
    <div class="bg-white rounded-2xl p-4 md:p-6 border border-amber-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-100 text-amber-700 rounded-2xl flex items-center justify-center text-xl md:text-2xl shadow-xs shrink-0">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div>
                <h1 class="text-lg md:text-2xl font-extrabold text-gray-900 tracking-tight">Keranjang Belanja Anda</h1>
                <p class="text-xs text-gray-500 font-medium">Periksa kembali item pilihanmu sebelum checkout.</p>
            </div>
        </div>
        
        <a href="{{ route('catalog.index') }}" class="px-3.5 py-1.5 md:px-4 md:py-2 bg-amber-50 text-amber-700 font-bold text-xs rounded-xl hover:bg-amber-100 transition flex items-center gap-1.5 border border-amber-200 shrink-0">
            <i class="fas fa-arrow-left"></i> Lanjut Belanja
        </a>
    </div>

    <!-- Empty State -->
    <div x-show="$store.cart.items.length === 0" class="bg-white rounded-2xl p-8 md:p-12 text-center shadow-sm border border-amber-100">
        <div class="w-16 h-16 md:w-20 md:h-20 bg-amber-100 text-amber-700 rounded-full flex items-center justify-center mx-auto text-2xl md:text-3xl mb-4">
            <i class="fas fa-cart-arrow-down"></i>
        </div>
        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1">Keranjang Kamu Masih Kosong</h3>
        <p class="text-xs text-gray-400 mb-6">Yuk temukan berbagai produk menarik di katalog Proats!</p>
        <a href="{{ route('catalog.index') }}" class="px-5 py-2.5 md:px-6 md:py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-lg transition inline-flex items-center gap-2">
            <i class="fas fa-magnifying-glass"></i> Jelajahi Katalog Sekarang
        </a>
    </div>

    <!-- Cart Table & Order Summary Grid -->
    <div x-show="$store.cart.items.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">

        <!-- Cart Items List (Left Column) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-hidden">
                <div class="p-3.5 md:p-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between text-xs font-bold text-gray-700">
                    <span>Daftar Produk (<span x-text="$store.cart.count()"></span> item)</span>
                    <button @click="$store.cart.clear()" class="text-red-500 hover:underline font-semibold flex items-center gap-1">
                        <i class="fas fa-trash-can"></i> Kosongkan Keranjang
                    </button>
                </div>

                <div class="p-3.5 md:p-4 space-y-4 divide-y divide-gray-100">
                    <template x-for="(item, index) in $store.cart.items" :key="index">
                        <div class="pt-4 first:pt-0 flex flex-wrap sm:flex-nowrap items-start sm:items-center gap-3 sm:gap-4">
                            <img :src="item.image_url" :alt="item.name" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-xl border border-gray-100 shrink-0">
                            
                            <div class="flex-grow min-w-0">
                                <h3 class="text-xs sm:text-sm font-bold text-gray-800 line-clamp-2" x-text="item.name"></h3>
                                <template x-if="item.variant">
                                    <span class="inline-block mt-1 text-[10px] sm:text-[11px] bg-amber-50 text-amber-800 border border-amber-200 px-2 py-0.5 rounded-md font-semibold" x-text="'Varian: ' + item.variant"></span>
                                </template>
                                <div class="text-amber-700 font-extrabold text-xs sm:text-sm mt-1" x-text="formatRp(item.price)"></div>
                            </div>

                            <!-- Quantity Selector -->
                            <div class="flex items-center justify-between sm:justify-start w-full sm:w-auto gap-3 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                                <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden text-xs">
                                    <button @click="$store.cart.updateQty(index, item.qty - 1)" class="px-2.5 py-1 sm:px-3 sm:py-1.5 bg-gray-50 hover:bg-gray-100 font-bold text-gray-600">-</button>
                                    <span class="px-3 font-bold text-gray-800" x-text="item.qty"></span>
                                    <button @click="$store.cart.updateQty(index, item.qty + 1)" class="px-2.5 py-1 sm:px-3 sm:py-1.5 bg-gray-50 hover:bg-gray-100 font-bold text-gray-600">+</button>
                                </div>
                                <button @click="$store.cart.removeItem(index)" class="p-2 text-gray-400 hover:text-red-600 text-sm transition" title="Hapus item">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Order Summary (Right Column) -->
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-amber-100 p-6 space-y-5 sticky top-24">
                <h3 class="font-extrabold text-base text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-receipt text-amber-600"></i> Ringkasan Belanja
                </h3>

                <!-- Voucher Code Input -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kode Voucher Promo</label>
                    <div class="flex gap-2">
                        <input type="text" x-model="voucherCode" placeholder="ONGKIRFREE / SHOPEE10K" class="w-full text-xs p-2.5 border border-gray-200 rounded-xl focus:ring-amber-500 uppercase font-mono">
                        <button @click="$store.cart.applyVoucher(voucherCode)" class="px-4 py-2.5 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-black transition shrink-0">
                            Pakai
                        </button>
                    </div>
                    <template x-if="$store.cart.voucher">
                        <p class="text-[11px] text-emerald-600 font-bold mt-1.5 flex items-center gap-1">
                            <i class="fas fa-check-circle"></i> Voucher "<span x-text="$store.cart.voucher"></span>" dipasang!
                        </p>
                    </template>
                </div>

                <!-- Price Breakdown -->
                <div class="space-y-2 text-xs text-gray-600 border-t border-gray-100 pt-4">
                    <div class="flex justify-between">
                        <span>Total Produk (<span x-text="$store.cart.count()"></span>):</span>
                        <span class="font-bold text-gray-800" x-text="formatRp($store.cart.subtotal())"></span>
                    </div>
                    <div class="flex justify-between text-emerald-600" x-show="$store.cart.discount() > 0">
                        <span>Diskon Voucher:</span>
                        <span class="font-bold" x-text="'-' + formatRp($store.cart.discount())"></span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Estimasi Pengiriman:</span>
                        <span class="font-semibold text-emerald-600">GRATIS</span>
                    </div>
                    
                    <div class="flex justify-between border-t border-gray-200 pt-3 text-sm font-extrabold text-gray-900">
                        <span>Total Tagihan:</span>
                        <span class="text-amber-700 text-lg" x-text="formatRp($store.cart.total())"></span>
                    </div>
                </div>

                <!-- Checkout Button -->
                <button @click="processCheckout()" class="w-full py-3.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-credit-card"></i> Lanjut Ke Checkout / WhatsApp
                </button>
            </div>
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
                Anda harus masuk ke akun Proats terlebih dahulu untuk memproses pemesanan & checkout.
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

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        if (!Alpine.store('cart')) {
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
        }
    });

    function cartPageApp() {
        return {
            isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            voucherCode: '',
            checkoutModal: false,
            requireLoginModal: false,

            customer: {
                name: @json(Auth::user()->name ?? 'Alvian Ahmad'),
                phone: '081234567890',
                address: 'Jl. Sudirman No. 88, Jakarta Selatan',
                payment: 'Proats Pay'
            },

            formatRp(num) {
                return 'Rp' + new Intl.NumberFormat('id-ID').format(num);
            },

            processCheckout() {
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
                window.open(waUrl, '_blank');
            }
        }
    }
</script>
@endsection

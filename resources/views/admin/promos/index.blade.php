@extends('layouts.admin')

@section('title', 'Kelola Kode Promo & Voucher - Proats Admin CMS')

@section('content')
<div x-data="adminPromoApp()" class="space-y-6">

    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-amber-100 shadow-xs">
        <div>
            <h1 class="text-xl md:text-2xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2.5">
                <i class="fas fa-ticket-simple text-amber-600"></i> Kelola Kode Promo & Voucher
            </h1>
            <p class="text-xs text-gray-500 font-medium mt-1">
                Atur kode voucher diskon persentase (%) atau nominal rupiah (Rp) untuk pembeli.
            </p>
        </div>
        <button @click="openCreateModal()" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition flex items-center gap-2 shrink-0">
            <i class="fas fa-plus"></i> Tambah Kode Promo
        </button>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl text-xs font-semibold flex items-center gap-2 border border-emerald-200 shadow-xs">
            <i class="fas fa-circle-check text-emerald-500 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Alert Errors -->
    @if($errors->any())
        <div class="bg-red-50 text-red-800 p-4 rounded-xl text-xs font-semibold border border-red-200 shadow-xs">
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

    <!-- Stats Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl shrink-0">
                <i class="fas fa-ticket"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Voucher</p>
                <p class="text-2xl font-black text-gray-900 mt-0.5">{{ count($promos) }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0">
                <i class="fas fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Voucher Aktif</p>
                <p class="text-2xl font-black text-gray-900 mt-0.5">{{ $promos->where('is_active', true)->count() }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl shrink-0">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Penggunaan</p>
                <p class="text-2xl font-black text-gray-900 mt-0.5">{{ $promos->sum('times_used') }} x</p>
            </div>
        </div>
    </div>

    <!-- Promos Table Card -->
    <div class="bg-white rounded-2xl border border-amber-100 shadow-xs overflow-hidden">
        <div class="p-4 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-extrabold text-sm text-gray-800 uppercase tracking-wider flex items-center gap-2">
                <i class="fas fa-list text-amber-600"></i> Daftar Kode Promo
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-3.5 px-4">Kode Promo</th>
                        <th class="py-3.5 px-4">Nilai Diskon</th>
                        <th class="py-3.5 px-4">Min. Belanja</th>
                        <th class="py-3.5 px-4">Max. Diskon</th>
                        <th class="py-3.5 px-4">Pemakaian</th>
                        <th class="py-3.5 px-4">Kadaluarsa</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 font-medium">
                    @forelse($promos as $promo)
                    <tr class="hover:bg-amber-50/40 transition">
                        <td class="py-3.5 px-4 font-mono font-bold text-amber-900">
                            <span class="bg-amber-100 text-amber-900 px-2.5 py-1 rounded-lg border border-amber-200 text-xs">
                                {{ $promo->code }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-gray-900">
                            @if($promo->discount_type === 'percent')
                                <span class="bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full border border-emerald-200 text-[11px]">
                                    Diskon {{ $promo->discount_value }}%
                                </span>
                            @else
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full border border-blue-200 text-[11px]">
                                    Potongan Rp{{ number_format($promo->discount_value, 0, ',', '.') }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            Rp{{ number_format($promo->min_spend, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 text-gray-500">
                            {{ $promo->max_discount ? 'Rp' . number_format($promo->max_discount, 0, ',', '.') : '-' }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-gray-800">{{ $promo->times_used }}</span> 
                            <span class="text-gray-400">/ {{ $promo->usage_limit ? $promo->usage_limit . ' x' : '∞' }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            @if($promo->expires_at)
                                <span class="{{ $promo->expires_at->isPast() ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                    {{ $promo->expires_at->format('d M Y, H:i') }}
                                </span>
                            @else
                                <span class="text-emerald-600 font-semibold">Tanpa Batas</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <button @click="toggleStatus({{ $promo->id }})" 
                                    class="relative inline-flex h-5 w-10 items-center rounded-full transition duration-200 cursor-pointer"
                                    :class="promoStatuses[{{ $promo->id }}] ? 'bg-emerald-500' : 'bg-gray-300'">
                                <span class="inline-block h-3.5 w-3.5 transform rounded-full bg-white transition duration-200"
                                      :class="promoStatuses[{{ $promo->id }}] ? 'translate-x-5' : 'translate-x-1'"></span>
                            </button>
                        </td>
                        <td class="py-3.5 px-4 text-right space-x-2">
                            <button @click="openEditModal({{ json_encode($promo) }})" class="p-1.5 text-amber-700 hover:bg-amber-100 rounded-lg transition" title="Edit Promo">
                                <i class="fas fa-pen-to-square text-xs"></i>
                            </button>
                            <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kode promo {{ $promo->code }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Promo">
                                    <i class="fas fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-400 font-medium">
                            <i class="fas fa-ticket text-3xl mb-2 text-gray-300 block"></i>
                            Belum ada kode promo. Klik <strong>"Tambah Kode Promo"</strong> untuk membuat baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create / Edit Modal -->
    <div x-show="modal.show" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="modal.show = false"
             x-show="modal.show"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="scale-95 opacity-0"
             x-transition:enter-end="scale-100 opacity-100"
             class="bg-white rounded-2xl max-w-lg w-full shadow-2xl overflow-hidden relative border border-amber-100">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-300 p-5 text-slate-950 flex items-center justify-between border-b border-amber-300">
                <h3 class="font-extrabold text-base tracking-tight flex items-center gap-2">
                    <i class="fas fa-ticket-simple"></i>
                    <span x-text="modal.isEdit ? 'Edit Kode Promo' : 'Tambah Kode Promo Baru'"></span>
                </h3>
                <button @click="modal.show = false" class="text-slate-950 hover:text-amber-900 text-lg font-bold">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <!-- Form -->
            <form :action="modal.isEdit ? '/cms-admin/promos/' + modal.promoId : '{{ route('admin.promos.store') }}'" method="POST" class="p-6 space-y-4">
                @csrf
                <template x-if="modal.isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Kode Promo <span class="text-red-500">*</span></label>
                    <input type="text" 
                           name="code" 
                           x-model="form.code" 
                           required 
                           placeholder="Contoh: PROATS10 / DISKON50K" 
                           class="w-full p-2.5 border border-gray-200 rounded-xl text-xs font-mono font-bold uppercase focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tipe Diskon <span class="text-red-500">*</span></label>
                        <select name="discount_type" x-model="form.discount_type" class="w-full p-2.5 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 focus:ring-2 focus:ring-amber-500">
                            <option value="percent">Persentase (%)</option>
                            <option value="fixed">Nominal Tetap (Rp)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nilai Diskon <span class="text-red-500">*</span></label>
                        <input type="number" 
                               step="0.01" 
                               name="discount_value" 
                               x-model="form.discount_value" 
                               required 
                               :placeholder="form.discount_type === 'percent' ? '10 (untuk 10%)' : '15000 (untuk Rp15.000)'" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Min. Belanja (Rp)</label>
                        <input type="number" 
                               name="min_spend" 
                               x-model="form.min_spend" 
                               placeholder="0 (Tanpa minimum)" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Max. Diskon Rp (Opsional)</label>
                        <input type="number" 
                               name="max_discount" 
                               x-model="form.max_discount" 
                               placeholder="Batas potongan persentase" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Batas Kuota Pemakaian</label>
                        <input type="number" 
                               name="usage_limit" 
                               x-model="form.usage_limit" 
                               placeholder="Kosongkan jika tak terbatas" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tanggal Kadaluarsa</label>
                        <input type="datetime-local" 
                               name="expires_at" 
                               x-model="form.expires_at" 
                               class="w-full p-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-700">
                        <input type="checkbox" name="is_active" value="1" x-model="form.is_active" class="w-4 h-4 text-amber-600 rounded focus:ring-amber-500">
                        <span>Aktifkan Kode Promo Ini</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" @click="modal.show = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs rounded-xl shadow-xs transition">
                        Simpan Promo
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function adminPromoApp() {
        return {
            promoStatuses: {
                @foreach($promos as $p)
                    {{ $p->id }}: {{ $p->is_active ? 'true' : 'false' }},
                @endforeach
            },

            modal: {
                show: false,
                isEdit: false,
                promoId: null
            },

            form: {
                code: '',
                discount_type: 'percent',
                discount_value: '',
                min_spend: '',
                max_discount: '',
                usage_limit: '',
                expires_at: '',
                is_active: true
            },

            openCreateModal() {
                this.modal.isEdit = false;
                this.modal.promoId = null;
                this.form = {
                    code: '',
                    discount_type: 'percent',
                    discount_value: '',
                    min_spend: 0,
                    max_discount: '',
                    usage_limit: '',
                    expires_at: '',
                    is_active: true
                };
                this.modal.show = true;
            },

            openEditModal(promo) {
                this.modal.isEdit = true;
                this.modal.promoId = promo.id;
                
                let formattedExpiresAt = '';
                if (promo.expires_at) {
                    const dt = new Date(promo.expires_at);
                    formattedExpiresAt = dt.toISOString().slice(0, 16);
                }

                this.form = {
                    code: promo.code,
                    discount_type: promo.discount_type,
                    discount_value: promo.discount_value,
                    min_spend: promo.min_spend,
                    max_discount: promo.max_discount || '',
                    usage_limit: promo.usage_limit || '',
                    expires_at: formattedExpiresAt,
                    is_active: Boolean(promo.is_active)
                };
                this.modal.show = true;
            },

            toggleStatus(id) {
                fetch('/cms-admin/promos/' + id + '/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.promoStatuses[id] = data.is_active;
                    }
                })
                .catch(err => console.error(err));
            }
        }
    }
</script>
@endsection

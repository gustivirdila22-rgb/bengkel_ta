
<script setup>
import { ref, computed } from 'vue'
import {
    Search,
    ShoppingBasket,
    ShoppingCart,
    Package,
    Camera,
    Info,
    Clock3,
    CreditCard,
    Plus,
    Minus,
    X,
} from 'lucide-vue-next'

const activeCategory = ref('Sering dipilih')
const search = ref('')
const cart = ref([])
const nopol = ref('')
const discount = ref(0)
const useTax = ref(false)

const categories = ['Sering dipilih', 'Sparepart', 'Jasa']

const unfinishedNotes = [
    { code: 'KSR-000197', price: 125000, items: '1 baris', date: '6 hari lalu' },
    { code: 'KSR-000191', price: 125000, items: '1 baris', date: '12 hari lalu' },
    { code: 'KSR-000187', price: 985000, items: '1 baris', date: '14 hari lalu' },
    { code: 'KSR-000182', price: 220000, items: '2 baris', date: '24 hari lalu' },
    { code: 'KSR-000181', price: 220000, items: '2 baris', date: '24 hari lalu' },
]

const products = [
    { id: 1, name: 'Timing Belt', price: 125000, stock: 'Sisa 93 pcs', type: 'Sparepart' },
    { id: 2, name: 'Aki GS Astra NS60 45Ah', price: 985000, stock: 'Stok habis', type: 'Sparepart' },
    { id: 3, name: 'Kaca spion kanan Avanza', price: 395000, stock: 'Stok habis', type: 'Sparepart' },
    { id: 4, name: 'Filter AC Brio / Mobilio', price: 95000, stock: 'Sisa 15 pcs', type: 'Sparepart' },
    { id: 5, name: 'Busi iridium Denso', price: 145000, stock: 'Sisa 24 pcs', type: 'Sparepart' },
    { id: 6, name: 'Cairan pembersih kaca 500ml', price: 45000, stock: 'Sisa 17 botol', type: 'Sparepart' },
    { id: 7, name: 'Oli mesin Pertamina Fastron 10W-40 1L', price: 125000, stock: 'Sisa 23 botol', type: 'Sparepart' },
    { id: 8, name: 'Bearing roda depan Avanza', price: 310000, stock: 'Sisa 5 pcs', type: 'Sparepart' },
    { id: 9, name: 'Filter oli Brio / Jazz', price: 72000, stock: 'Sisa 24 pcs', type: 'Sparepart' },
    { id: 10, name: 'Oli mesin Shell Helix HX7 10W-40 4L', price: 395000, stock: 'Sisa 8 kaleng', type: 'Sparepart' },
    { id: 11, name: 'Servis berkala 10.000 km', price: 350000, stock: 'Jasa', type: 'Jasa' },
    { id: 12, name: 'Ganti oli mesin', price: 60000, stock: 'Jasa', type: 'Jasa' },
    { id: 13, name: 'Cuci mesin & ruang bakar', price: 185000, stock: 'Jasa', type: 'Jasa' },
    { id: 14, name: 'Servis AC & isi freon', price: 450000, stock: 'Jasa', type: 'Jasa' },
    { id: 15, name: 'Servis kaki-kaki', price: 350000, stock: 'Jasa', type: 'Jasa' },
    { id: 16, name: 'Overhaul kepala silinder', price: 2500000, stock: 'Jasa', type: 'Jasa' },
    { id: 17, name: 'Ganti kampas rem', price: 150000, stock: 'Jasa', type: 'Jasa' },
    { id: 18, name: 'Ganti aki & cek pengisian', price: 75000, stock: 'Jasa', type: 'Jasa' },
    { id: 19, name: 'Ganti kampas kopling', price: 850000, stock: 'Jasa', type: 'Jasa' },
    { id: 20, name: 'Ganti timing belt', price: 650000, stock: 'Jasa', type: 'Jasa' },
    { id: 21, name: 'Servis berkala 20.000 km', price: 550000, stock: 'Jasa', type: 'Jasa' },
    { id: 22, name: 'Tune up mesin', price: 450000, stock: 'Jasa', type: 'Jasa' },
]

const filteredProducts = computed(() => {
    return products.filter(product => {
        const matchesSearch = product.name.toLowerCase().includes(search.value.toLowerCase())
        const matchesCategory =
            activeCategory.value === 'Sering dipilih' ||
            product.type === activeCategory.value

        return matchesSearch && matchesCategory
    })
})

const subtotal = computed(() => {
    return cart.value.reduce((total, item) => total + item.price * item.qty, 0)
})

const discountAmount = computed(() => {
    const value = Number(discount.value) || 0
    if (value <= 100) return subtotal.value * value / 100
    return Math.min(value, subtotal.value)
})

const taxAmount = computed(() => {
    return useTax.value
        ? (subtotal.value - discountAmount.value) * 0.11
        : 0
})

const total = computed(() => {
    return subtotal.value - discountAmount.value + taxAmount.value
})

const formatRupiah = (value) => {
    return 'Rp ' + Math.round(value).toLocaleString('id-ID')
}

const addToCart = (product) => {
    const existing = cart.value.find(item => item.id === product.id)

    if (existing) {
        existing.qty++
    } else {
        cart.value.push({ ...product, qty: 1 })
    }
}

const increaseQty = (item) => {
    item.qty++
}

const decreaseQty = (item) => {
    if (item.qty > 1) {
        item.qty--
    } else {
        cart.value = cart.value.filter(product => product.id !== item.id)
    }
}

const removeFromCart = (id) => {
    cart.value = cart.value.filter(item => item.id !== id)
}
</script>

<template>
    <div class="kasir-page space-y-6">

        <!-- NOTA BELUM SELESAI -->
        <section class="rounded-2xl border border-[#e8eee8] bg-white p-6 shadow-sm">
            <div class="mb-4 flex flex-wrap items-center gap-3">
                <Clock3 class="h-5 w-5 text-emerald-700" />

                <span class="text-base font-semibold text-[#293c32]">
                    Nota belum selesai (6)
                </span>

                <span class="text-sm text-slate-500">
                    Keranjang yang tadi belum dibayar. Klik untuk melanjutkan — isinya kembali utuh, stok belum berkurang.
                </span>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    v-for="note in unfinishedNotes"
                    :key="note.code"
                    class="min-w-[180px] rounded-xl bg-[#f0f5ef] px-4 py-3 text-left transition hover:bg-[#e3eee1]"
                >
                    <p class="text-sm font-semibold text-[#293c32]">
                        {{ note.code }}
                    </p>

                    <p class="mt-1 text-base font-bold text-emerald-800">
                        {{ formatRupiah(note.price) }}
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ note.items }} · {{ note.date }}
                    </p>
                </button>
            </div>

            <button class="mt-3 text-sm font-semibold text-emerald-700 hover:text-emerald-900">
                › Lihat semua (6)
            </button>
        </section>

        <!-- AREA KASIR -->
        <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-[minmax(0,1fr)_390px]">

            <!-- PRODUK -->
            <section class="min-w-0">

                <!-- PENCARIAN PRODUK -->
                <div class="mb-5 flex gap-3">
                    <div class="flex flex-1 items-center gap-3 rounded-xl border border-dashed border-slate-300 bg-white px-4 py-3">
                        <Search class="h-5 w-5 shrink-0 text-slate-500" />

                        <input
                            v-model="search"
                            type="text"
                            placeholder="Tambah sparepart, jasa, atau biaya lain..."
                            class="w-full border-0 bg-transparent text-base outline-none placeholder:text-slate-400 focus:ring-0"
                        />

                        <span class="hidden whitespace-nowrap text-sm text-slate-400 md:block">
                            Enter kosong = selesai
                        </span>
                    </div>

                    <button class="rounded-xl border border-slate-200 bg-white px-4 text-slate-600 transition hover:bg-emerald-50 hover:text-emerald-700">
                        <Camera class="h-5 w-5" />
                    </button>
                </div>

                <!-- KATEGORI -->
                <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex gap-2">
                        <button
                            v-for="category in categories"
                            :key="category"
                            @click="activeCategory = category"
                            :class="[
                                'rounded-full px-5 py-2.5 text-sm font-semibold transition',
                                activeCategory === category
                                    ? 'bg-emerald-800 text-white shadow-sm'
                                    : 'bg-[#edf2ed] text-slate-600 hover:bg-[#dfe9de]'
                            ]"
                        >
                            {{ category }}
                        </button>
                    </div>

                    <p class="text-sm text-slate-500">
                        <span class="font-semibold">F2</span> cari ·
                        <span class="font-semibold">F4</span> diskon ·
                        <span class="font-semibold">F8</span> bayar
                    </p>
                </div>

                <!-- DAFTAR PRODUK -->
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                    <button
                        v-for="product in filteredProducts"
                        :key="product.id"
                        @click="addToCart(product)"
                        class="group flex min-h-[110px] flex-col justify-between rounded-xl border border-[#e8eee8] bg-white p-4 text-left shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md"
                    >
                        <span class="text-base font-medium leading-snug text-[#293c32]">
                            {{ product.name }}
                        </span>

                        <div class="mt-4">
                            <p class="text-base font-bold text-emerald-800">
                                {{ formatRupiah(product.price) }}
                            </p>

                            <p
                                :class="[
                                    'mt-1 flex items-center gap-2 text-sm',
                                    product.stock === 'Stok habis' ? 'text-red-500' : 'text-slate-500'
                                ]"
                            >
                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                {{ product.stock }}
                            </p>
                        </div>
                    </button>
                </div>

                <div
                    v-if="filteredProducts.length === 0"
                    class="rounded-2xl border border-dashed border-slate-300 bg-white py-12 text-center"
                >
                    <Package class="mx-auto mb-3 h-9 w-9 text-slate-300" />

                    <p class="text-base font-medium text-slate-500">
                        Produk tidak ditemukan
                    </p>

                    <p class="mt-1 text-sm text-slate-400">
                        Coba kata kunci pencarian lain.
                    </p>
                </div>
            </section>

            <!-- KERANJANG -->
            <aside class="overflow-hidden rounded-2xl border border-[#e8eee8] bg-white shadow-sm xl:sticky xl:top-24">

                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5">
                    <div class="flex items-center gap-3">
                        <ShoppingCart class="h-5 w-5 text-emerald-700" />

                        <h2 class="text-lg font-semibold text-[#293c32]">
                            Keranjang
                        </h2>
                    </div>

                    <span class="rounded-full bg-[#edf4ec] px-3 py-1.5 text-sm font-semibold text-emerald-800">
                        {{ cart.length }} item
                    </span>
                </div>

                <div class="max-h-[350px] min-h-[170px] space-y-4 overflow-y-auto p-5">
                    <div
                        v-if="cart.length === 0"
                        class="flex min-h-[140px] flex-col items-center justify-center text-center"
                    >
                        <ShoppingBasket class="mb-3 h-10 w-10 text-slate-300" />

                        <p class="text-base text-slate-500">
                            Belum ada apa pun di keranjang.
                        </p>

                        <p class="mt-2 text-sm leading-relaxed text-slate-400">
                            Ketuk kartu di kiri atau ketik di kotak cari, atau scan barcode.
                            <Info class="inline h-4 w-4" />
                        </p>
                    </div>

                    <div
                        v-for="item in cart"
                        :key="item.id"
                        class="flex items-start justify-between gap-3 border-b border-slate-100 pb-4"
                    >
                        <div class="min-w-0 flex-1">
                            <p class="text-base font-semibold text-[#293c32]">
                                {{ item.name }}
                            </p>

                            <p class="mt-1 text-sm text-emerald-800">
                                {{ formatRupiah(item.price) }}
                            </p>

                            <div class="mt-3 flex items-center gap-3">
                                <button
                                    @click="decreaseQty(item)"
                                    class="rounded-lg border border-slate-200 p-1.5 transition hover:bg-emerald-50"
                                >
                                    <Minus class="h-4 w-4" />
                                </button>

                                <span class="min-w-5 text-center text-sm font-semibold">
                                    {{ item.qty }}
                                </span>

                                <button
                                    @click="increaseQty(item)"
                                    class="rounded-lg border border-slate-200 p-1.5 transition hover:bg-emerald-50"
                                >
                                    <Plus class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold">
                                {{ formatRupiah(item.price * item.qty) }}
                            </p>

                            <button
                                @click="removeFromCart(item.id)"
                                class="text-slate-400 transition hover:text-red-500"
                            >
                                <X class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TOTAL DAN PEMBAYARAN -->
                <div class="border-t border-slate-100 p-5">

                    <div class="mb-5 flex items-center justify-between gap-3">
                        <label class="text-sm text-slate-500">
                            Nopol (opsional)
                        </label>

                        <input
                            v-model="nopol"
                            type="text"
                            placeholder="B 1234 XYZ"
                            class="w-36 rounded-lg border border-slate-200 px-3 py-2.5 text-right text-sm uppercase outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        />
                    </div>

                    <div class="space-y-4 border-t border-slate-100 pt-4">
                        <div class="flex items-center justify-between text-base">
                            <span class="text-slate-500">Subtotal</span>
                            <span class="font-medium">{{ formatRupiah(subtotal) }}</span>
                        </div>

                        <div class="flex items-center justify-between gap-3 text-base">
                            <label class="text-slate-500">Diskon nota</label>

                            <input
                                v-model.number="discount"
                                type="number"
                                min="0"
                                class="w-28 rounded-lg border border-slate-200 px-3 py-2.5 text-right text-sm outline-none focus:border-emerald-500"
                            />
                        </div>

                        <p class="text-sm leading-relaxed text-slate-400">
                            Tulis diskon dalam persen, atau angka rupiah jika lebih dari 100.
                        </p>

                        <label class="flex cursor-pointer items-center gap-3 text-base">
                            <input
                                v-model="useTax"
                                type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-500"
                            />
                            Kenakan PPN 11%
                        </label>

                        <div v-if="useTax" class="flex justify-between text-sm text-slate-500">
                            <span>PPN 11%</span>
                            <span>{{ formatRupiah(taxAmount) }}</span>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between gap-3 border-t border-slate-100 pt-5">
                        <span class="text-base font-semibold text-[#293c32]">
                            Total
                        </span>

                        <span class="text-2xl font-bold tracking-tight text-[#293c32]">
                            {{ formatRupiah(total) }}
                        </span>
                    </div>

                    <button
                        :disabled="cart.length === 0"
                        class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-800 py-3.5 text-base font-semibold text-white shadow-sm transition hover:bg-emerald-900 disabled:cursor-not-allowed disabled:bg-[#a9b9a7]"
                    >
                        <CreditCard class="h-5 w-5" />
                        Bayar (F8)
                    </button>
                </div>
            </aside>
        </div>
    </div>
</template>

<style scoped>
.kasir-page {
    font-size: 16px;
}

/* Menyamakan ukuran teks kecil */
.kasir-page :deep(.text-xs) {
    font-size: 14px;
    line-height: 1.5;
}

.kasir-page :deep(.text-sm) {
    font-size: 15px;
    line-height: 1.5;
}

.kasir-page :deep(.text-\[10px\]),
.kasir-page :deep(.text-\[11px\]) {
    font-size: 13px;
    line-height: 1.5;
}

.kasir-page :deep(.text-\[13px\]) {
    font-size: 15px;
    line-height: 1.5;
}

.kasir-page input {
    font-family: inherit;
}
</style>

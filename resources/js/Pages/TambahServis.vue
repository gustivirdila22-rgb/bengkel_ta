
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import {
    ArrowLeft,
    Search,
    Plus,
    Trash2,
    Eye,
    Send,
    X,
} from 'lucide-vue-next'

defineOptions({ layout: AppLayout })

// DATA FORM
const pelanggan = ref('')
const kendaraan = ref('')
const kmMasuk = ref('')
const mekanik = ref('')

const keluhan = ref('')
const kondisi = ref('')
const perkiraanSelesai = ref('')
const jam = ref('')

const catatan = ref('')
const servisBerikutnya = ref('')

const diskon = ref(0)
const kenaPpn = ref(false)

const itemBaru = ref('')
const pekerjaan = ref([])

// DATA CONTOH
const pelangganList = [
    'Agung Nugroho',
    'Ahmad Fauzi',
    'Anita Rahmawati',
    'Arif Budiman',
]

const daftarKendaraan = [
    'Honda Beat - B 3344 EFG',
    'Yamaha NMAX - B 9012 GHI',
    'Honda Vario - B 3366 XYZ',
]

// PERHITUNGAN
const totalJasa = computed(() =>
    pekerjaan.value
        .filter(item => item.jenis === 'Jasa')
        .reduce((total, item) => total + item.harga, 0)
)

const totalSparepart = computed(() =>
    pekerjaan.value
        .filter(item => item.jenis === 'Sparepart')
        .reduce((total, item) => total + item.harga, 0)
)

const biayaLain = computed(() =>
    pekerjaan.value
        .filter(item => item.jenis === 'Biaya lain')
        .reduce((total, item) => total + item.harga, 0)
)

const subtotal = computed(() =>
    totalJasa.value + totalSparepart.value + biayaLain.value
)

const nilaiDiskon = computed(() =>
    Math.min(subtotal.value, Math.max(0, Number(diskon.value) || 0))
)

const dasarPajak = computed(() =>
    Math.max(0, subtotal.value - nilaiDiskon.value)
)

const pajak = computed(() =>
    kenaPpn.value ? dasarPajak.value * 0.11 : 0
)

const total = computed(() =>
    dasarPajak.value + pajak.value
)

const formatRupiah = (angka) =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka)

// TAMBAH PEKERJAAN
const tambahItem = () => {
    if (!itemBaru.value.trim()) return

    pekerjaan.value.push({
        id: Date.now(),
        nama: itemBaru.value,
        jenis: 'Jasa',
        harga: 0,
    })

    itemBaru.value = ''
}

const hapusItem = (id) => {
    pekerjaan.value = pekerjaan.value.filter(
        item => item.id !== id
    )
}

// TAMBAH KELUHAN CEPAT
const tambahKeluhan = (item) => {
    const daftar = keluhan.value
        .split(',')
        .map(value => value.trim())
        .filter(Boolean)

    if (!daftar.includes(item)) {
        daftar.push(item)
        keluhan.value = daftar.join(', ')
    }
}

const hapusKeluhan = (item) => {
    keluhan.value = keluhan.value
        .split(',')
        .map(value => value.trim())
        .filter(value => value && value !== item)
        .join(', ')
}

// SERVIS BERIKUTNYA
const setServisBerikutnya = (bulan) => {
    const tanggal = new Date()
    tanggal.setMonth(tanggal.getMonth() + bulan)

    servisBerikutnya.value = [
        tanggal.getFullYear(),
        String(tanggal.getMonth() + 1).padStart(2, '0'),
        String(tanggal.getDate()).padStart(2, '0'),
    ].join('-')
}

// AKSI
const simpanServis = () => {
    if (!pelanggan.value || !kendaraan.value || !kmMasuk.value) {
        alert('Pelanggan, kendaraan, dan KM saat masuk wajib diisi.')
        return
    }

    alert('Form berhasil disiapkan. Penyimpanan database akan dibuat pada tahap backend.')
}

const pratinjau = () => {
    window.print()
}
</script>

<template>
    <div class="min-h-screen bg-[#f6f8fb] p-5">

        <!-- HEADER -->
        <div class="mb-6">
            <Link
                href="/servis"
                class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-emerald-600 hover:text-emerald-700"
            >
                <ArrowLeft :size="17" />
                Daftar Servis
            </Link>

            <h1 class="text-xl font-bold text-slate-800">
                Tambah Servis
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Buat transaksi servis baru untuk pelanggan.
            </p>
        </div>

        <div class="grid grid-cols-1 items-start gap-5 xl:grid-cols-[minmax(0,1fr)_290px]">

            <!-- KOLOM FORM -->
            <div class="space-y-4">

                <!-- 1. PELANGGAN DAN KENDARAAN -->
                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-900 text-sm font-semibold text-white">
                            1
                        </span>

                        <h2 class="text-sm font-semibold text-slate-800">
                            Pelanggan & kendaraan
                        </h2>
                    </div>

                    <div class="grid gap-5 p-5 md:grid-cols-2">

                        <!-- PELANGGAN -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Pelanggan <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <Search
                                    class="absolute left-3 top-3 text-slate-400"
                                    :size="17"
                                />

                                <input
                                    v-model="pelanggan"
                                    list="pelanggan-list"
                                    placeholder="Cari nama atau nomor HP pelanggan"
                                    class="w-full rounded-xl border border-slate-200 py-2.5 pl-10 pr-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                />

                                <datalist id="pelanggan-list">
                                    <option
                                        v-for="item in pelangganList"
                                        :key="item"
                                        :value="item"
                                    />
                                </datalist>
                            </div>

                            <p class="mt-2 text-xs text-slate-400">
                                Pilih pelanggan yang sudah terdaftar.
                            </p>
                        </div>

                        <!-- KENDARAAN -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Kendaraan <span class="text-red-500">*</span>
                            </label>

                            <select
                                v-model="kendaraan"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            >
                                <option value="">Pilih kendaraan</option>

                                <option
                                    v-for="item in daftarKendaraan"
                                    :key="item"
                                    :value="item"
                                >
                                    {{ item }}
                                </option>
                            </select>

                            <!-- KM MASUK -->
                            <label class="mb-2 mt-4 block text-sm font-medium text-slate-700">
                                KM saat masuk <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <input
                                    v-model="kmMasuk"
                                    type="number"
                                    min="0"
                                    placeholder="Contoh: 12500"
                                    class="w-full rounded-xl border border-slate-200 px-3 py-2.5 pr-12 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                />

                                <span class="absolute right-3 top-3 text-sm text-slate-400">
                                    KM
                                </span>
                            </div>

                            <!-- MEKANIK -->
                            <label class="mb-2 mt-4 block text-sm font-medium text-slate-700">
                                Mekanik
                            </label>

                            <select
                                v-model="mekanik"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            >
                                <option value="">Pilih mekanik</option>
                                <option>Andi</option>
                                <option>Budi</option>
                                <option>Rizky</option>
                            </select>
                        </div>
                    </div>
                </section>

                <!-- 2. KELUHAN DAN KONDISI -->
                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-900 text-sm font-semibold text-white">
                            2
                        </span>

                        <h2 class="text-sm font-semibold text-slate-800">
                            Keluhan & kondisi kendaraan
                        </h2>
                    </div>

                    <div class="space-y-5 p-5">

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Keluhan pelanggan
                            </label>

                            <div class="mb-3 flex flex-wrap gap-2">
                                <button
                                    v-for="item in ['Ganti oli', 'Servis rutin', 'Mesin brebet', 'Setir getar', 'Oli bocor']"
                                    :key="item"
                                    type="button"
                                    @click="tambahKeluhan(item)"
                                    class="rounded-full border border-slate-200 px-3 py-1.5 text-sm text-slate-600 transition hover:border-emerald-400 hover:bg-emerald-50 hover:text-emerald-700"
                                >
                                    + {{ item }}
                                </button>
                            </div>

                            <textarea
                                v-model="keluhan"
                                rows="3"
                                placeholder="Tuliskan keluhan pelanggan..."
                                class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Kondisi saat masuk
                            </label>

                            <textarea
                                v-model="kondisi"
                                rows="3"
                                placeholder="Contoh: Lecet di pintu kiri, dongkrak ada di bagasi..."
                                class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            />
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Perkiraan selesai
                                </label>

                                <input
                                    v-model="perkiraanSelesai"
                                    type="date"
                                    class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500"
                                />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Jam
                                </label>

                                <input
                                    v-model="jam"
                                    type="time"
                                    class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500"
                                />
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 3. PEKERJAAN DAN SPAREPART -->
                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-900 text-sm font-semibold text-white">
                            3
                        </span>

                        <h2 class="text-sm font-semibold text-slate-800">
                            Pekerjaan & sparepart
                        </h2>
                    </div>

                    <div class="p-5">

                        <label class="mb-3 block text-sm font-medium text-slate-700">
                            Rincian pekerjaan
                        </label>

                        <div
                            v-if="pekerjaan.length === 0"
                            class="mb-3 rounded-xl border border-dashed border-slate-300 px-4 py-6 text-center"
                        >
                            <p class="text-sm font-medium text-slate-500">
                                Belum ada pekerjaan
                            </p>
                            <p class="mt-1 text-xs text-slate-400">
                                Tambahkan jasa, sparepart, atau biaya lainnya.
                            </p>
                        </div>

                        <div v-else class="mb-3 space-y-3">

                            <div
                                v-for="item in pekerjaan"
                                :key="item.id"
                                class="rounded-xl border border-slate-200 p-3"
                            >
                                <div class="flex flex-wrap items-center gap-3">

                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-slate-800">
                                            {{ item.nama }}
                                        </p>

                                        <select
                                            v-model="item.jenis"
                                            class="mt-2 rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm outline-none focus:border-emerald-500"
                                        >
                                            <option>Jasa</option>
                                            <option>Sparepart</option>
                                            <option>Biaya lain</option>
                                        </select>
                                    </div>

                                    <input
                                        v-model.number="item.harga"
                                        type="number"
                                        min="0"
                                        placeholder="Harga"
                                        class="w-32 rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500"
                                    />

                                    <button
                                        type="button"
                                        @click="hapusItem(item.id)"
                                        class="rounded-lg p-2 text-red-500 transition hover:bg-red-50"
                                    >
                                        <Trash2 :size="17" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <input
                                v-model="itemBaru"
                                @keyup.enter="tambahItem"
                                placeholder="Nama jasa, sparepart, atau biaya..."
                                class="min-w-0 flex-1 rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500"
                            />

                            <button
                                type="button"
                                @click="tambahItem"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700"
                            >
                                <Plus :size="17" />
                                Tambah
                            </button>
                        </div>
                    </div>
                </section>

                <!-- 4. CATATAN -->
                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-900 text-sm font-semibold text-white">
                                4
                            </span>

                            <h2 class="text-sm font-semibold text-slate-800">
                                Catatan & servis berikutnya
                            </h2>
                        </div>

                        <span class="text-xs text-slate-400">
                            Opsional
                        </span>
                    </div>

                    <div class="grid gap-5 p-5 md:grid-cols-2">

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Catatan tambahan
                            </label>

                            <textarea
                                v-model="catatan"
                                rows="3"
                                placeholder="Tambahkan catatan untuk mekanik..."
                                class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500"
                            />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Ingatkan servis berikutnya
                            </label>

                            <input
                                v-model="servisBerikutnya"
                                type="date"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500"
                            />

                            <div class="mt-3 flex flex-wrap gap-2">
                                <button
                                    v-for="bulan in [3, 6, 12]"
                                    :key="bulan"
                                    type="button"
                                    @click="setServisBerikutnya(bulan)"
                                    class="rounded-full bg-slate-100 px-3 py-1.5 text-sm text-slate-600 transition hover:bg-emerald-50 hover:text-emerald-700"
                                >
                                    {{ bulan }} bulan lagi
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- PANEL ESTIMASI -->
            <aside class="space-y-4 xl:sticky xl:top-5">

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <h2 class="mb-5 text-sm font-semibold text-slate-800">
                        Estimasi biaya
                    </h2>

                    <div class="space-y-4">

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Jasa</span>
                            <span class="text-sm font-medium text-slate-800">
                                {{ formatRupiah(totalJasa) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Sparepart</span>
                            <span class="text-sm font-medium text-slate-800">
                                {{ formatRupiah(totalSparepart) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Biaya lain</span>
                            <span class="text-sm font-medium text-slate-800">
                                {{ formatRupiah(biayaLain) }}
                            </span>
                        </div>

                        <div class="border-t border-dashed border-slate-200 pt-4">
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Diskon nota (Rp)
                            </label>

                            <input
                                v-model.number="diskon"
                                type="number"
                                min="0"
                                placeholder="0"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-right outline-none transition focus:border-emerald-500"
                            />
                        </div>

                        <label class="flex cursor-pointer items-center gap-2">
                            <input
                                v-model="kenaPpn"
                                type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                            />

                            <span class="text-sm text-slate-700">
                                Kenakan PPN 11%
                            </span>
                        </label>

                        <div
                            v-if="kenaPpn"
                            class="flex items-center justify-between"
                        >
                            <span class="text-sm text-slate-500">PPN 11%</span>
                            <span class="text-sm font-medium text-slate-800">
                                {{ formatRupiah(pajak) }}
                            </span>
                        </div>

                        <div class="border-t border-dashed border-slate-200 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-slate-800">
                                    Total
                                </span>

                                <span class="text-lg font-bold text-emerald-700">
                                    {{ formatRupiah(total) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- TOMBOL AKSI -->
                <button
                    type="button"
                    @click="simpanServis"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                >
                    <Send :size="17" />
                    Simpan & Masukkan ke Antrean
                </button>

                <button
                    type="button"
                    @click="pratinjau"
                    class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    <Eye :size="17" />
                    Pratinjau
                </button>

                <Link
                    href="/servis"
                    class="block w-full rounded-xl px-4 py-3 text-center text-sm font-medium text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                >
                    Batal
                </Link>

            </aside>
        </div>
    </div>
</template>

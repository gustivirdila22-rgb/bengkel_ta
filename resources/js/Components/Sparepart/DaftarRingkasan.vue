<script setup>
import { ref, computed } from 'vue'

const emit = defineEmits([
    'tambah',
    'ubah',
    'menu-change',
])

const activeSubTab = ref('daftar')
const search = ref('')
const kategori = ref('Semua kategori')
const merek = ref('Semua merek')
const activeFilter = ref('semua')
const showColumns = ref(false)
const showDocuments = ref(false)
const expandedId = ref(null)
const currentPage = ref(1)
const perPage = ref(20)

const columns = ref({
    nama: true,
    stok: true,
    keadaan: true,
    harga: true,
    aksi: true,
})

const spareparts = ref([
    {
        id: 1,
        nama: 'Aki mobil',
        kode: 'NS40',
        barcode: 'BRG-000002',
        kategori: 'Bahan Habis Pakai',
        merek: 'GS Astra',
        stok: 6,
        minimum: 10,
        hargaModal: 150000,
        hargaJual: 200000,
        lokasi: 'Gudang Utama',
    },
    {
        id: 2,
        nama: 'Radiator',
        kode: '16410-0C140',
        barcode: 'BRG-000001',
        kategori: 'Sparepart',
        merek: 'Denso',
        stok: 16,
        minimum: 10,
        hargaModal: 100000,
        hargaJual: 150000,
        lokasi: 'Gudang 17',
    },
    {
        id: 3,
        nama: 'Tang',
        kode: '12345',
        barcode: 'BRG-000003',
        kategori: 'Sparepart',
        merek: 'Denso',
        stok: 0,
        minimum: 10,
        hargaModal: 120000,
        hargaJual: 200000,
        lokasi: 'Gudang Utama',
    },
])

const formatRupiah = (value) => {
    return new Intl.NumberFormat('id-ID').format(value)
}

const jumlahHabis = computed(() =>
    spareparts.value.filter(item => item.stok === 0).length
)

const jumlahMenipis = computed(() =>
    spareparts.value.filter(item =>
        item.stok > 0 && item.stok <= item.minimum
    ).length
)

const jumlahDitinjau = computed(() =>
    spareparts.value.filter(item =>
        item.stok <= item.minimum
    ).length
)

const totalNilaiStok = computed(() =>
    spareparts.value.reduce(
        (total, item) => total + item.stok * item.hargaModal,
        0
    )
)

const kategoriOptions = computed(() => [
    ...new Set(spareparts.value.map(item => item.kategori))
])

const merekOptions = computed(() => [
    ...new Set(spareparts.value.map(item => item.merek))
])

const filteredSpareparts = computed(() => {
    return spareparts.value.filter(item => {
        const keyword = search.value.toLowerCase()

        const cocokSearch =
            item.nama.toLowerCase().includes(keyword) ||
            item.kode.toLowerCase().includes(keyword) ||
            item.barcode.toLowerCase().includes(keyword)

        const cocokKategori =
            kategori.value === 'Semua kategori' ||
            item.kategori === kategori.value

        const cocokMerek =
            merek.value === 'Semua merek' ||
            item.merek === merek.value

        let cocokFilter = true

        if (activeFilter.value === 'menipis') {
            cocokFilter =
                item.stok > 0 &&
                item.stok <= item.minimum
        } else if (activeFilter.value === 'habis') {
            cocokFilter = item.stok === 0
        } else if (activeFilter.value === 'ditinjau') {
            cocokFilter = item.stok <= item.minimum
        }

        return cocokSearch &&
            cocokKategori &&
            cocokMerek &&
            cocokFilter
    })
})

const totalPages = computed(() =>
    Math.max(
        1,
        Math.ceil(
            filteredSpareparts.value.length / perPage.value
        )
    )
)

const paginatedSpareparts = computed(() => {
    const start =
        (currentPage.value - 1) * perPage.value

    return filteredSpareparts.value.slice(
        start,
        start + perPage.value
    )
})

const startData = computed(() =>
    filteredSpareparts.value.length === 0
        ? 0
        : (currentPage.value - 1) * perPage.value + 1
)

const endData = computed(() =>
    Math.min(
        currentPage.value * perPage.value,
        filteredSpareparts.value.length
    )
)

const getStatus = (item) => {
    if (item.stok === 0) return 'Stok habis'
    if (item.stok <= item.minimum) return 'Menipis'
    return 'Tersedia'
}

const getStatusClass = (item) => {
    if (item.stok === 0) return 'text-red-600'
    if (item.stok <= item.minimum) return 'text-amber-500'
    return 'text-emerald-600'
}

const getProgressClass = (item) => {
    if (item.stok === 0) return 'bg-red-500'
    if (item.stok <= item.minimum) return 'bg-amber-500'
    return 'bg-emerald-500'
}

const getProgress = (item) => {
    return Math.min(
        (item.stok / Math.max(item.minimum, 1)) * 100,
        100
    )
}

const resetPage = () => {
    currentPage.value = 1
}

const setFilter = (filter) => {
    activeFilter.value = filter
    resetPage()
}
</script>

<template>
    <div class="-mt-10 space-y-5">

        <!-- Tombol Atas -->
        <div class="flex justify-end gap-2">

            <div class="relative">
                <button
                    @click="showDocuments = !showDocuments"
                    class="flex h-10 items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 text-sm text-slate-700 transition hover:bg-slate-50"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 3v5h5M12 12v6m-3-3l3 3 3-3"
                        />
                    </svg>

                    Dokumen

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 9l6 6 6-6"
                        />
                    </svg>
                </button>

                <div
                    v-if="showDocuments"
                    class="absolute right-0 top-12 z-30 w-48 rounded-xl border border-slate-200 bg-white p-2 shadow-lg"
                >
                    <button
                        @click="showDocuments = false"
                        class="w-full rounded-lg px-3 py-2 text-left text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700"
                    >
                        Daftar Sparepart
                    </button>

                    <button
                        @click="showDocuments = false"
                        class="w-full rounded-lg px-3 py-2 text-left text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700"
                    >
                        Laporan Stok
                    </button>
                </div>
            </div>

            <button
                @click="emit('tambah')"
                class="flex h-10 items-center gap-2 rounded-lg bg-emerald-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 5v14m-7-7h14"
                    />
                </svg>

                Tambah Sparepart

                <span class="text-[10px] opacity-80">
                    (Alt+N)
                </span>
            </button>
        </div>

        <!-- Ringkasan -->
        <div class="flex flex-wrap items-center gap-2">

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                <strong class="text-slate-800">
                    {{ spareparts.length }}
                </strong>

                <span class="text-slate-500">
                    jenis sparepart
                </span>

                <span class="text-slate-400">›</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                <span class="h-2 w-2 rounded-full bg-red-500"></span>

                <strong class="text-red-600">
                    {{ jumlahHabis }}
                </strong>

                <span class="text-slate-500">
                    stok habis
                </span>

                <span class="text-slate-400">›</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                <span class="h-2 w-2 rounded-full bg-amber-500"></span>

                <strong class="text-amber-600">
                    {{ jumlahMenipis }}
                </strong>

                <span class="text-slate-500">
                    stok menipis
                </span>

                <span class="text-slate-400">›</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                <strong class="text-slate-800">
                    Rp {{ formatRupiah(totalNilaiStok) }}
                </strong>

                <span class="text-slate-500">
                    nilai stok - harga modal
                </span>
            </div>
        </div>

        <!-- TAB UTAMA -->
        <div class="border-b border-slate-200">
            <div class="flex items-center gap-8 overflow-x-auto">

                <button
                    @click="emit('menu-change', 'daftar')"
                    class="relative flex h-12 shrink-0 items-center border-b-2 border-emerald-600 px-1 text-sm font-semibold text-emerald-700"
                >
                    Daftar & Ringkasan
                </button>

                <button
                    @click="emit('menu-change', 'riwayat-stok')"
                    class="relative flex h-12 shrink-0 items-center border-b-2 border-transparent px-1 text-sm font-medium text-slate-500 transition hover:border-emerald-300 hover:text-emerald-700"
                >
                    Riwayat Stok
                </button>

                <button
                    @click="emit('menu-change', 'hitung-stok')"
                    class="relative flex h-12 shrink-0 items-center border-b-2 border-transparent px-1 text-sm font-medium text-slate-500 transition hover:border-emerald-300 hover:text-emerald-700"
                >
                    Hitung Stok
                </button>

                <button
                    @click="emit('menu-change', 'harga-aturan')"
                    class="relative flex h-12 shrink-0 items-center border-b-2 border-transparent px-1 text-sm font-medium text-slate-500 transition hover:border-emerald-300 hover:text-emerald-700"
                >
                    Harga & Aturan
                </button>

            </div>
        </div>

        <!-- SUBTAB -->
        <div class="flex w-fit items-center gap-1 rounded-xl bg-slate-100 p-1">

            <button
                @click="activeSubTab = 'daftar'"
                :class="activeSubTab === 'daftar'
                    ? 'bg-white text-emerald-700 shadow-sm'
                    : 'text-slate-500 hover:text-emerald-700'"
                class="rounded-lg px-4 py-2 text-sm font-medium transition"
            >
                Daftar Sparepart
            </button>

            <button
                @click="activeSubTab = 'ringkasan'"
                :class="activeSubTab === 'ringkasan'
                    ? 'bg-white text-emerald-700 shadow-sm'
                    : 'text-slate-500 hover:text-emerald-700'"
                class="rounded-lg px-4 py-2 text-sm font-medium transition"
            >
                Ringkasan
            </button>

        </div>

        <!-- DAFTAR -->
        <div
            v-if="activeSubTab === 'daftar'"
            class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm"
        >

            <!-- SEARCH & FILTER -->
            <div class="mb-3 flex flex-wrap items-center gap-3">

                <div class="relative min-w-[220px] flex-1 md:max-w-[370px]">
                    <svg
                        class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle cx="11" cy="11" r="7" />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20 20l-4-4"
                        />
                    </svg>

                    <input
                        v-model="search"
                        @input="resetPage"
                        type="text"
                        placeholder="Cari nama, kode, atau nomor part..."
                        class="h-11 w-full rounded-lg border border-slate-200 bg-white pl-10 pr-4 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    />
                </div>

                <select
                    v-model="kategori"
                    @change="resetPage"
                    class="h-11 min-w-[160px] rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-700 outline-none focus:border-emerald-500"
                >
                    <option>Semua kategori</option>

                    <option
                        v-for="item in kategoriOptions"
                        :key="item"
                    >
                        {{ item }}
                    </option>
                </select>

                <select
                    v-model="merek"
                    @change="resetPage"
                    class="h-11 min-w-[140px] rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-700 outline-none focus:border-emerald-500"
                >
                    <option>Semua merek</option>

                    <option
                        v-for="item in merekOptions"
                        :key="item"
                    >
                        {{ item }}
                    </option>
                </select>

            </div>

            <!-- FILTER STATUS -->
            <div class="mb-5 flex flex-wrap items-center gap-2">

                <button
                    @click="setFilter('semua')"
                    :class="activeFilter === 'semua'
                        ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                        : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-300'"
                    class="rounded-full border px-3 py-1.5 text-sm transition"
                >
                    Semua {{ spareparts.length }}
                </button>

                <button
                    @click="setFilter('menipis')"
                    :class="activeFilter === 'menipis'
                        ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                        : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-300'"
                    class="rounded-full border px-3 py-1.5 text-sm transition"
                >
                    Menipis {{ jumlahMenipis }}
                </button>

                <button
                    @click="setFilter('habis')"
                    :class="activeFilter === 'habis'
                        ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                        : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-300'"
                    class="rounded-full border px-3 py-1.5 text-sm transition"
                >
                    Stok Habis {{ jumlahHabis }}
                </button>

                <button
                    @click="setFilter('ditinjau')"
                    :class="activeFilter === 'ditinjau'
                        ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                        : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-300'"
                    class="rounded-full border px-3 py-1.5 text-sm transition"
                >
                    Perlu Ditinjau {{ jumlahDitinjau }}
                </button>

            </div>

            <!-- TABEL -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-sm">

                    <thead>
                        <tr class="border-b border-slate-200 text-xs text-slate-500">

                            <th class="w-10 px-2 py-4"></th>

                            <th
                                v-if="columns.nama"
                                class="px-3 py-4 text-left font-medium"
                            >
                                Nama Sparepart
                            </th>

                            <th
                                v-if="columns.stok"
                                class="px-3 py-4 text-right font-medium"
                            >
                                Bisa Dipakai
                            </th>

                            <th
                                v-if="columns.keadaan"
                                class="px-3 py-4 text-left font-medium"
                            >
                                Keadaan
                            </th>

                            <th
                                v-if="columns.harga"
                                class="px-3 py-4 text-right font-medium"
                            >
                                Harga Jual
                            </th>

                            <th
                                v-if="columns.aksi"
                                class="px-3 py-4 text-center font-medium"
                            >
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        <template
                            v-for="item in paginatedSpareparts"
                            :key="item.id"
                        >

                            <tr
                                class="border-b border-slate-100 transition hover:bg-slate-50"
                                :class="expandedId === item.id
                                    ? 'bg-emerald-50/40'
                                    : ''"
                            >

                                <td class="px-2 py-5">
                                    <button
                                        @click="expandedId = expandedId === item.id ? null : item.id"
                                        class="rounded p-1 text-slate-400 hover:text-emerald-600"
                                    >
                                        <svg
                                            class="h-4 w-4 transition-transform"
                                            :class="expandedId === item.id
                                                ? 'rotate-90'
                                                : ''"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 5l7 7-7 7"
                                            />
                                        </svg>
                                    </button>
                                </td>

                                <td
                                    v-if="columns.nama"
                                    class="px-3 py-5"
                                >
                                    <p class="font-medium text-slate-800">
                                        {{ item.nama }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-500">
                                        {{ item.kode }}
                                        ·
                                        {{ item.barcode }}
                                        ·
                                        {{ item.kategori }}
                                        ·
                                        {{ item.merek }}
                                    </p>
                                </td>

                                <td
                                    v-if="columns.stok"
                                    class="px-3 py-5"
                                >
                                    <div class="flex flex-col items-end">

                                        <span class="font-medium text-slate-800">
                                            {{ item.stok }} pcs
                                        </span>

                                        <span class="text-xs text-slate-500">
                                            minimum {{ item.minimum }}
                                        </span>

                                        <div class="mt-1.5 h-1.5 w-28 overflow-hidden rounded-full bg-slate-200">
                                            <div
                                                class="h-full rounded-full transition-all"
                                                :class="getProgressClass(item)"
                                                :style="{
                                                    width: getProgress(item) + '%'
                                                }"
                                            ></div>
                                        </div>

                                    </div>
                                </td>

                                <td
                                    v-if="columns.keadaan"
                                    class="px-3 py-5"
                                >
                                    <span
                                        class="flex items-center gap-2 whitespace-nowrap"
                                        :class="getStatusClass(item)"
                                    >
                                        <span class="h-2 w-2 rounded-full bg-current"></span>

                                        {{ getStatus(item) }}
                                    </span>
                                </td>

                                <td
                                    v-if="columns.harga"
                                    class="whitespace-nowrap px-3 py-5 text-right text-slate-700"
                                >
                                    Rp {{ formatRupiah(item.hargaJual) }}
                                </td>

                                <td
                                    v-if="columns.aksi"
                                    class="px-3 py-5"
                                >
                                    <div class="flex items-center justify-center gap-3">

                                        <button
                                            @click="emit('ubah', item)"
                                            class="font-medium text-slate-600 transition hover:text-emerald-700"
                                        >
                                            Ubah
                                        </button>

                                        <button
                                            @click="expandedId = expandedId === item.id ? null : item.id"
                                            class="text-slate-400 hover:text-emerald-600"
                                        >
                                            ⋮
                                        </button>

                                    </div>
                                </td>

                            </tr>

                            <!-- DETAIL -->
                            <tr v-if="expandedId === item.id">

                                <td
                                    colspan="6"
                                    class="bg-slate-50 px-8 py-4"
                                >

                                    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">

                                        <div>
                                            <p class="text-xs text-slate-400">
                                                Barcode
                                            </p>

                                            <p class="mt-1 font-medium text-slate-700">
                                                {{ item.barcode }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-slate-400">
                                                Harga Modal
                                            </p>

                                            <p class="mt-1 font-medium text-slate-700">
                                                Rp {{ formatRupiah(item.hargaModal) }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-slate-400">
                                                Lokasi Stok
                                            </p>

                                            <p class="mt-1 font-medium text-slate-700">
                                                {{ item.lokasi }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-slate-400">
                                                Batas Minimum
                                            </p>

                                            <p class="mt-1 font-medium text-slate-700">
                                                {{ item.minimum }} pcs
                                            </p>
                                        </div>

                                    </div>

                                </td>

                            </tr>

                        </template>

                        <tr v-if="filteredSpareparts.length === 0">

                            <td
                                colspan="6"
                                class="py-12 text-center text-sm text-slate-400"
                            >
                                Tidak ada data sparepart yang ditemukan.
                            </td>

                        </tr>

                    </tbody>

                </table>
            </div>

            <!-- PAGINATION -->
            <div class="mt-5 flex flex-wrap items-center justify-between gap-4">

                <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">

                    <span>Tampilkan</span>

                    <select
                        v-model.number="perPage"
                        @change="resetPage"
                        class="h-9 rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-700 outline-none focus:border-emerald-500"
                    >
                        <option :value="10">10</option>
                        <option :value="20">20</option>
                        <option :value="50">50</option>
                        <option :value="100">100</option>
                    </select>

                    <span>per halaman</span>

                    <span class="text-slate-300">·</span>

                    <span>
                        Menampilkan
                        {{ startData }}–{{ endData }}
                        dari
                        {{ filteredSpareparts.length }}
                        data
                    </span>

                </div>

                <div class="flex items-center gap-2">

                    <button
                        @click="currentPage--"
                        :disabled="currentPage <= 1"
                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                    >
                        ‹
                    </button>

                    <span class="flex h-9 min-w-9 items-center justify-center rounded-lg bg-emerald-600 px-3 text-sm font-semibold text-white">
                        {{ currentPage }}
                    </span>

                    <button
                        @click="currentPage++"
                        :disabled="currentPage >= totalPages"
                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                    >
                        ›
                    </button>

                </div>

            </div>

        </div>

        <!-- RINGKASAN -->
        <div
            v-else
            class="space-y-4"
        >

            <!-- 6 KARTU RINGKASAN -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">

                <!-- Nilai Stok -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium text-slate-500">
                                Nilai stok
                            </p>

                            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                                Rp {{ formatRupiah(totalNilaiStok) }}
                            </h2>

                            <p class="mt-1 text-xs text-slate-400">
                                Jumlah × harga modal
                            </p>
                        </div>

                        <div class="text-emerald-600">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 3h12v18H6z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 7h6M9 11h6M9 15h4"
                                />
                            </svg>
                        </div>

                    </div>

                    <button
                        @click="activeSubTab = 'daftar'"
                        class="mt-3 text-xs font-medium text-emerald-600 hover:text-emerald-700"
                    >
                        Lihat →
                    </button>
                </div>

                <!-- Jenis Sparepart -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium text-slate-500">
                                Jenis sparepart
                            </p>

                            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                                {{ spareparts.length }}
                            </h2>

                            <p class="mt-1 text-xs text-slate-400">
                                Yang aktif dan dikelola stoknya
                            </p>
                        </div>

                        <div class="text-emerald-600">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle cx="12" cy="12" r="3" />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v3M12 18v3M3 12h3M18 12h3"
                                />
                            </svg>
                        </div>

                    </div>

                    <button
                        @click="activeSubTab = 'daftar'"
                        class="mt-3 text-xs font-medium text-emerald-600 hover:text-emerald-700"
                    >
                        Lihat →
                    </button>
                </div>

                <!-- Stok Habis -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium text-slate-500">
                                Stok habis
                            </p>

                            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                                {{ jumlahHabis }}
                            </h2>

                            <p class="mt-1 text-xs text-slate-400">
                                Tidak ada yang bisa dipakai
                            </p>
                        </div>

                        <div class="text-emerald-600">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v18M3 12h18"
                                />
                            </svg>
                        </div>

                    </div>

                    <button
                        @click="setFilter('habis')"
                        class="mt-3 text-xs font-medium text-emerald-600 hover:text-emerald-700"
                    >
                        Lihat →
                    </button>
                </div>

                <!-- Stok Menipis -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium text-slate-500">
                                Stok menipis
                            </p>

                            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                                {{ jumlahMenipis }}
                            </h2>

                            <p class="mt-1 text-xs text-slate-400">
                                Sudah di bawah batas minimum
                            </p>
                        </div>

                        <div class="text-emerald-600">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v18M3 12h18"
                                />
                            </svg>
                        </div>

                    </div>

                    <button
                        @click="setFilter('menipis')"
                        class="mt-3 text-xs font-medium text-emerald-600 hover:text-emerald-700"
                    >
                        Lihat →
                    </button>
                </div>

                <!-- Tidak Laku -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium text-slate-500">
                                Tidak laku
                            </p>

                            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                                0
                            </h2>

                            <p class="mt-1 text-xs text-slate-400">
                                Semua keluar dalam 90 hari
                            </p>
                        </div>

                        <div class="text-emerald-600">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v18M8 7h8M8 17h8"
                                />
                            </svg>
                        </div>

                    </div>

                    <button
                        @click="activeSubTab = 'daftar'"
                        class="mt-3 text-xs font-medium text-emerald-600 hover:text-emerald-700"
                    >
                        Lihat →
                    </button>
                </div>

                <!-- Rata-rata Untung -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium text-slate-500">
                                Rata-rata untung
                            </p>

                            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                                29,2%
                            </h2>

                            <p class="mt-1 text-xs text-slate-400">
                                Harga jual dibanding harga modal
                            </p>
                        </div>

                        <div class="text-emerald-600">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 17l6-6 4 4 6-8"
                                />
                            </svg>
                        </div>

                    </div>

                    <button
                        @click="activeSubTab = 'daftar'"
                        class="mt-3 text-xs font-medium text-emerald-600 hover:text-emerald-700"
                    >
                        Lihat →
                    </button>
                </div>

            </div>

            <!-- GRAFIK -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <h3 class="text-sm font-semibold text-slate-800">
                    Penjualan sparepart per bulan
                </h3>

                <div class="mt-5 flex h-40 items-end gap-3 border-b border-slate-100 px-2">

                    <div
                        v-for="(value, index) in [5, 8, 4, 6, 3, 7, 5, 9, 4, 6, 85, 5]"
                        :key="index"
                        class="flex h-full flex-1 items-end justify-center"
                    >
                        <div
                            class="w-full max-w-[28px] rounded-t-lg bg-emerald-500 transition hover:bg-emerald-600"
                            :style="{ height: value + '%' }"
                        ></div>
                    </div>

                </div>

                <div class="mt-2 grid grid-cols-12 gap-3 px-2 text-center text-[10px] text-slate-400">
                    <span>Des</span>
                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span>Apr</span>
                    <span>Mei</span>
                    <span>Jun</span>
                    <span>Jul</span>
                    <span>Agu</span>
                    <span>Sep</span>
                    <span>Okt</span>
                    <span>Nov</span>
                </div>

            </div>

            <!-- PALING LAKU & TIDAK LAKU -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                <!-- Paling Laku -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <h3 class="text-sm font-semibold text-slate-800">
                        Paling laku (30 hari terakhir)
                    </h3>

                    <p class="mt-3 text-xs text-slate-400">
                        Belum ada yang keluar dalam sebulan ini.
                    </p>

                </div>

                <!-- Tidak Laku -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <h3 class="text-sm font-semibold text-slate-800">
                        Tidak laku (tidak keluar 90 hari)
                    </h3>

                    <p class="mt-3 text-xs text-slate-400">
                        Semua sparepart yang ada stoknya pernah keluar dalam 3 bulan terakhir.
                    </p>

                </div>

            </div>

            <!-- UNTUNG TERBESAR -->
            <div class="w-full max-w-[calc(50%-0.5rem)] rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <h3 class="text-sm font-semibold text-slate-800">
                    Untung terbesar (90 hari terakhir)
                </h3>

                <div class="mt-4 space-y-3">

                    <div class="flex items-center gap-3">

                        <span class="w-4 text-xs text-slate-400">
                            1
                        </span>

                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-700">
                                Radiator
                            </p>

                            <p class="text-[10px] text-slate-400">
                                BRG-000001
                            </p>
                        </div>

                        <span class="text-xs font-semibold text-slate-700">
                            Rp 200.000
                        </span>

                    </div>

                    <div class="flex items-center gap-3">

                        <span class="w-4 text-xs text-slate-400">
                            2
                        </span>

                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-700">
                                Aki mobil
                            </p>

                            <p class="text-[10px] text-slate-400">
                                BRG-000002
                            </p>
                        </div>

                        <span class="text-xs font-semibold text-slate-700">
                            Rp 50.000
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>
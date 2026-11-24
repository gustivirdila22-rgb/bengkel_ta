<script setup>
import { ref, computed } from 'vue'

const emit = defineEmits([
    'menu-change',
])

const activeMenu = ref('harga-aturan')
const activeTab = ref('harga-jual')
const search = ref('')

const menuItems = [
    {
        id: 'daftar',
        label: 'Daftar & Ringkasan',
    },
    {
        id: 'riwayat-stok',
        label: 'Riwayat Stok',
    },
    {
        id: 'hitung-stok',
        label: 'Hitung Stok',
    },
    {
        id: 'harga-aturan',
        label: 'Harga & Aturan',
    },
]

const spareparts = ref([
    {
        id: 1,
        nama: 'Aki mobil',
        barcode: 'BRG-000002',
        kategori: 'Bahan Habis Pakai',
        satuan: 'pcs',
        hargaJual: 200000,
        hargaGrosir: 0,
        hargaDistributor: 0,
        stokMinimum: 7,
        otomatis: false,
        bedaSaran: false,
    },
    {
        id: 2,
        nama: 'Radiator',
        barcode: 'BRG-000001',
        kategori: 'Sparepart',
        satuan: 'pcs',
        hargaJual: 150000,
        hargaGrosir: 0,
        hargaDistributor: 0,
        stokMinimum: 7,
        otomatis: false,
        bedaSaran: false,
    },
    {
        id: 3,
        nama: 'tang',
        barcode: 'BRG-000003',
        kategori: 'Sparepart',
        satuan: 'pcs',
        hargaJual: 200000,
        hargaGrosir: 0,
        hargaDistributor: 0,
        stokMinimum: 7,
        otomatis: false,
        bedaSaran: false,
    },
])

const filteredSpareparts = computed(() => {
    const keyword = search.value.toLowerCase()

    return spareparts.value.filter(item =>
        item.nama.toLowerCase().includes(keyword) ||
        item.barcode.toLowerCase().includes(keyword)
    )
})

const jumlahOtomatis = computed(() =>
    spareparts.value.filter(item => item.otomatis).length
)

const jumlahBedaSaran = computed(() =>
    spareparts.value.filter(item => item.bedaSaran).length
)

const formatRupiah = (value) => {
    return new Intl.NumberFormat('id-ID').format(value)
}

const pindahMenu = (menu) => {
    activeMenu.value = menu
    emit('menu-change', menu)
}

const downloadExcel = () => {
    alert('Download Excel')
}

const uploadExcel = () => {
    alert('Upload Excel')
}

const terapkanSemua = () => {
    alert('Saran berhasil diterapkan')
}
</script>

<template>
    <div class="-mt-10 space-y-5">

        <!-- RINGKASAN ATAS -->
        <div class="flex flex-wrap items-center gap-2">

            <div
                class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm"
            >
                <strong class="text-slate-800">
                    {{ spareparts.length }}
                </strong>

                <span class="text-slate-500">
                    sparepart disimpan stoknya
                </span>

                <span class="text-slate-300">›</span>
            </div>

            <div
                class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm"
            >
                <strong class="text-slate-800">
                    {{ jumlahOtomatis }}
                </strong>

                <span class="text-slate-500">
                    punya saran stok minimum
                </span>

                <span class="text-slate-300">›</span>
            </div>

            <div
                class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm"
            >
                <strong class="text-slate-800">
                    {{ jumlahBedaSaran }}
                </strong>

                <span class="text-slate-500">
                    beda dari saran
                </span>

                <span class="text-slate-300">›</span>
            </div>

        </div>

        <!-- NAVIGASI UTAMA -->
        <div class="border-b border-slate-200">

            <div class="flex items-center gap-8 overflow-x-auto">

                <button
                    v-for="menu in menuItems"
                    :key="menu.id"
                    @click="pindahMenu(menu.id)"
                    class="relative flex h-12 shrink-0 items-center border-b-2 px-1 text-sm transition"
                    :class="activeMenu === menu.id
                        ? 'border-emerald-600 font-semibold text-emerald-700'
                        : 'border-transparent font-medium text-slate-500 hover:border-emerald-300 hover:text-emerald-700'"
                >
                    {{ menu.label }}
                </button>

            </div>

        </div>

        <!-- KARTU PENJELASAN -->
        <div
            class="rounded-xl border border-slate-200 bg-slate-50 p-5"
        >

            <div class="flex items-center gap-2">

                <svg
                    class="h-4 w-4 text-emerald-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <rect
                        x="5"
                        y="3"
                        width="14"
                        height="18"
                        rx="2"
                    />

                    <path
                        stroke-linecap="round"
                        d="M8 7h8M8 11h8M8 15h3"
                    />
                </svg>

                <h2 class="text-sm font-semibold text-slate-800">
                    Cara stok minimum dihitung
                </h2>

            </div>

            <p class="mt-2 text-sm font-medium text-emerald-700">
                Stok minimum = rata-rata terjual per hari × lama barang datang (hari)
            </p>

            <ul class="mt-2 list-disc space-y-1.5 pl-5 text-xs leading-5 text-slate-600">

                <li>
                    <strong>Rata-rata terjual per hari:</strong>
                    sparepart yang dipakai servis dan kasir di Pusat selama
                    90 hari terakhir, dibagi jumlah harinya.
                    Sparepart baru dibagi jumlah hari sejak ia mulai bergerak
                    (data kurang dari 14 hari diberi tanda “data masih sedikit”).
                </li>

                <li>
                    <strong>Lama barang datang:</strong>
                    hari dari barang dipesan sampai diterima.
                    Dihitung otomatis dari Pembelian yang diisi
                    <strong>Tanggal Order</strong>-nya:
                    rata-rata 5 pembelian terakhir sparepart itu,
                    atau bila belum ada, rata-rata supplier-nya.
                    Belum ada riwayat? Dipakai angka yang diisi di menu
                    Supplier (bawaan 7 hari).
                    Boleh ditimpa per sparepart di kolom “Lama datang”.
                </li>

                <li>
                    Hasilnya dibulatkan ke atas.
                    Contoh: terjual 90 dalam 90 hari = 1 per hari,
                    barang datang 7 hari → saran 7.
                </li>

                <li>
                    <strong>Manual:</strong>
                    angka diketik sendiri.
                    <strong>Otomatis:</strong>
                    angka dihitung ulang dari rumus tiap hari.
                    Tombol <strong>Terapkan</strong> mengisi angka dari
                    saran lalu menjadikannya Manual.
                </li>

            </ul>

            <p class="mt-2 text-xs leading-5 text-slate-600">
                Kolom <strong>Harga Grosir / Distributor</strong> dipakai
                otomatis saat pelanggan yang berkaitan dilayani di Servis
                dan Kasir. Dikosongkan (atau 0) berarti
                <strong>ikut harga Umum.</strong>
            </p>

            <p class="mt-1 text-xs leading-5 text-slate-600">
                Sedang bekerja di cabang Pusat:
                angka yang diubah di sini menjadi acuan semua cabang
                yang belum mengubah sendiri.
            </p>

        </div>

        <!-- SEARCH + ACTION -->
        <div class="flex flex-wrap items-center justify-between gap-3">

            <div class="flex flex-wrap items-center gap-2">

                <div class="relative">

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
                        type="text"
                        placeholder="Cari nama atau kode sparepart..."
                        class="h-11 w-[320px] rounded-lg border border-slate-200 bg-white pl-10 pr-4 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    />

                </div>

                <!-- FILTER SEMUA -->
                <button
                    class="rounded-full border border-emerald-500 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700"
                >
                    Semua {{ spareparts.length }}
                </button>

                <!-- FILTER BEDA -->
                <button
                    class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 transition hover:border-emerald-300 hover:text-emerald-700"
                >
                    Beda dari saran {{ jumlahBedaSaran }}
                </button>

                <!-- FILTER OTOMATIS -->
                <button
                    class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 transition hover:border-emerald-300 hover:text-emerald-700"
                >
                    Otomatis {{ jumlahOtomatis }}
                </button>

                <div
                    class="flex h-6 w-6 items-center justify-center rounded-full text-slate-400"
                    title="Informasi"
                >
                    ⓘ
                </div>

            </div>

            <!-- BUTTON EXCEL -->
            <div class="flex items-center gap-2">

                <button
                    @click="downloadExcel"
                    class="flex h-10 items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 text-sm font-medium text-slate-700 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700"
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
                            d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                        />
                    </svg>

                    Download Excel
                </button>

                <button
                    @click="uploadExcel"
                    class="flex h-10 items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 text-sm font-medium text-slate-700 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700"
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
                            d="M12 21V9m0 0l-4 4m4-4l4 4M5 3h14"
                        />
                    </svg>

                    Upload Excel
                </button>

                <button
                    @click="terapkanSemua"
                    class="flex h-10 items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 text-sm font-medium text-slate-400 transition hover:border-emerald-300 hover:text-emerald-700"
                >
                    ⚒
                    Terapkan saran ke semua yang cocok
                </button>

            </div>

        </div>

        <!-- SUB TAB -->
        <div class="flex items-center gap-2">

            <button
                @click="activeTab = 'harga-jual'"
                :class="activeTab === 'harga-jual'
                    ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                    : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-300 hover:text-emerald-700'"
                class="rounded-full border px-4 py-2 text-sm font-medium transition"
            >
                Harga jual
            </button>

            <button
                @click="activeTab = 'stok-minimum'"
                :class="activeTab === 'stok-minimum'
                    ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                    : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-300 hover:text-emerald-700'"
                class="rounded-full border px-4 py-2 text-sm font-medium transition"
            >
                Stok minimum
            </button>

        </div>

        <!-- TABEL HARGA JUAL -->
        <div
            v-if="activeTab === 'harga-jual'"
            class="overflow-hidden rounded-xl border border-slate-200 bg-white"
        >

            <div class="overflow-x-auto">

                <table class="w-full min-w-[900px] text-sm">

                    <thead>
                        <tr class="border-b border-slate-200 bg-white text-xs text-slate-500">

                            <th class="w-16 px-4 py-4 text-left font-medium">
                                No.
                            </th>

                            <th class="px-4 py-4 text-left font-medium">
                                Sparepart
                            </th>

                            <th class="w-36 px-4 py-4 text-right font-medium">
                                Harga Jual (Rp)
                            </th>

                            <th class="w-36 px-4 py-4 text-right font-medium">
                                Harga Grosir (Rp)
                            </th>

                            <th class="w-36 px-4 py-4 text-right font-medium">
                                Harga Distributor (Rp)
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        <tr
                            v-for="(item, index) in filteredSpareparts"
                            :key="item.id"
                            class="border-b border-slate-100 last:border-b-0"
                        >

                            <td class="px-4 py-5 text-slate-500">
                                {{ index + 1 }}
                            </td>

                            <td class="px-4 py-5">

                                <p class="font-medium text-slate-800">
                                    {{ item.nama }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    {{ item.barcode }}
                                    ·
                                    {{ item.kategori }}
                                    ·
                                    {{ item.satuan }}
                                </p>

                            </td>

                            <td class="px-4 py-5">

                                <input
                                    v-model.number="item.hargaJual"
                                    type="number"
                                    min="0"
                                    class="h-10 w-full rounded-lg border border-slate-200 px-3 text-right text-sm text-slate-700 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                />

                            </td>

                            <td class="px-4 py-5">

                                <input
                                    v-model.number="item.hargaGrosir"
                                    type="number"
                                    min="0"
                                    class="h-10 w-full rounded-lg border border-slate-200 px-3 text-right text-sm text-slate-700 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                />

                                <p class="mt-1 text-right text-[11px] text-slate-400">
                                    ikut harga Umum
                                </p>

                            </td>

                            <td class="px-4 py-5">

                                <input
                                    v-model.number="item.hargaDistributor"
                                    type="number"
                                    min="0"
                                    class="h-10 w-full rounded-lg border border-slate-200 px-3 text-right text-sm text-slate-700 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                />

                                <p class="mt-1 text-right text-[11px] text-slate-400">
                                    ikut harga Umum
                                </p>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

        <!-- TABEL STOK MINIMUM -->
        <div
            v-else
            class="overflow-hidden rounded-xl border border-slate-200 bg-white"
        >

            <div class="overflow-x-auto">

                <table class="w-full min-w-[900px] text-sm">

                    <thead>
                        <tr class="border-b border-slate-200 text-xs text-slate-500">

                            <th class="w-16 px-4 py-4 text-left font-medium">
                                No.
                            </th>

                            <th class="px-4 py-4 text-left font-medium">
                                Sparepart
                            </th>

                            <th class="w-40 px-4 py-4 text-right font-medium">
                                Stok Minimum
                            </th>

                            <th class="w-40 px-4 py-4 text-center font-medium">
                                Mode
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        <tr
                            v-for="(item, index) in filteredSpareparts"
                            :key="item.id"
                            class="border-b border-slate-100 last:border-b-0"
                        >

                            <td class="px-4 py-5 text-slate-500">
                                {{ index + 1 }}
                            </td>

                            <td class="px-4 py-5">

                                <p class="font-medium text-slate-800">
                                    {{ item.nama }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    {{ item.barcode }}
                                    ·
                                    {{ item.kategori }}
                                    ·
                                    {{ item.satuan }}
                                </p>

                            </td>

                            <td class="px-4 py-5">

                                <input
                                    v-model.number="item.stokMinimum"
                                    type="number"
                                    min="0"
                                    class="h-10 w-full rounded-lg border border-slate-200 px-3 text-right text-sm text-slate-700 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                />

                            </td>

                            <td class="px-4 py-5 text-center">

                                <span
                                    class="rounded-full px-3 py-1 text-xs font-medium"
                                    :class="item.otomatis
                                        ? 'bg-emerald-50 text-emerald-700'
                                        : 'bg-slate-100 text-slate-600'"
                                >
                                    {{ item.otomatis ? 'Otomatis' : 'Manual' }}
                                </span>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const emit = defineEmits(['kembali', 'menu-change'])

const activeMenu = ref('riwayat-stok')
const activeView = ref('rekap')
const search = ref('')
const activeFilter = ref('bergerak')
const bulan = ref('11')
const tahun = ref('2026')
const expandedId = ref(null)

const bulanOptions = [
    { value: '01', label: 'Januari' },
    { value: '02', label: 'Februari' },
    { value: '03', label: 'Maret' },
    { value: '04', label: 'April' },
    { value: '05', label: 'Mei' },
    { value: '06', label: 'Juni' },
    { value: '07', label: 'Juli' },
    { value: '08', label: 'Agustus' },
    { value: '09', label: 'September' },
    { value: '10', label: 'Oktober' },
    { value: '11', label: 'November' },
    { value: '12', label: 'Desember' },
]

const menuItems = [
    { id: 'daftar', label: 'Daftar & Ringkasan' },
    { id: 'riwayat-stok', label: 'Riwayat Stok' },
    { id: 'hitung-stok', label: 'Hitung Stok' },
    { id: 'harga-aturan', label: 'Harga & Aturan' },
]

const riwayat = ref([
    {
        id: 1,
        nama: 'Aki mobil',
        kode: 'BRG-000002',
        kategori: 'BAHAN HABIS PAKAI',
        saldoAwal: 6,
        masuk: 0,
        keluar: 0,
        saldoAkhir: 6,
        satuan: 'pcs',
        detail: [],
    },
    {
        id: 2,
        nama: 'Radiator',
        kode: 'BRG-000001',
        kategori: 'SPAREPART',
        saldoAwal: 17,
        masuk: 0,
        keluar: 0,
        saldoAkhir: 17,
        satuan: 'pcs',
        detail: [],
    },
])

const namaBulan = computed(() =>
    bulanOptions.find(item => item.value === bulan.value)?.label || ''
)

const totalAwal = computed(() =>
    filteredRiwayat.value.reduce((total, item) => total + item.saldoAwal, 0)
)

const totalMasuk = computed(() =>
    filteredRiwayat.value.reduce((total, item) => total + item.masuk, 0)
)

const totalKeluar = computed(() =>
    filteredRiwayat.value.reduce((total, item) => total + item.keluar, 0)
)

const totalAkhir = computed(() =>
    filteredRiwayat.value.reduce((total, item) => total + item.saldoAkhir, 0)
)

const jumlahBergerak = computed(() =>
    riwayat.value.filter(item => item.masuk > 0 || item.keluar > 0).length
)

const filteredRiwayat = computed(() => {
    const keyword = search.value.toLowerCase()

    return riwayat.value.filter(item => {
        const cocokSearch =
            item.nama.toLowerCase().includes(keyword) ||
            item.kode.toLowerCase().includes(keyword)

        const bergerak = item.masuk > 0 || item.keluar > 0

        const cocokFilter =
            activeFilter.value === 'semua' ||
            (activeFilter.value === 'bergerak' && bergerak)

        return cocokSearch && cocokFilter
    })
})

const formatAngka = value =>
    new Intl.NumberFormat('id-ID').format(value)

const pindahMenu = (menu) => {
    activeMenu.value = menu
    emit('menu-change', menu)
}

const setFilter = (filter) => {
    activeFilter.value = filter
}

const exportPDF = () => {
    window.print()
}

const exportExcel = () => {
    const header = ['No', 'Sparepart', 'Saldo Awal', 'Masuk', 'Keluar', 'Saldo Akhir']
    const rows = filteredRiwayat.value.map((item, index) => [
        index + 1,
        item.nama,
        item.saldoAwal,
        item.masuk,
        item.keluar,
        item.saldoAkhir,
    ])

    const csv = [header, ...rows]
        .map(row => row.join(';'))
        .join('\n')

    const blob = new Blob(['\uFEFF' + csv], {
        type: 'text/csv;charset=utf-8;',
    })

    const url = URL.createObjectURL(blob)
    const link = document.createElement('a')
    link.href = url
    link.download = `Riwayat-Stok-${namaBulan.value}-${tahun.value}.csv`
    link.click()
    URL.revokeObjectURL(url)
}
</script>

<template>
    <div class="-mt-10 space-y-5">

        <!-- Ringkasan stok -->
        <div class="flex flex-wrap items-center gap-2">
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                <strong class="text-slate-800">{{ formatAngka(totalAwal) }}</strong>
                <span class="text-slate-500">stok awal bulan</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                <strong class="text-emerald-600">+{{ formatAngka(totalMasuk) }}</strong>
                <span class="text-slate-500">masuk</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                <strong class="text-slate-800">-{{ formatAngka(totalKeluar) }}</strong>
                <span class="text-slate-500">keluar</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                <strong class="text-slate-800">{{ formatAngka(totalAkhir) }}</strong>
                <span class="text-slate-500">stok akhir bulan</span>
            </div>
        </div>

       <!-- Tab Utama -->
<div class="border-b border-slate-200">
    <div class="flex items-center gap-8 overflow-x-auto">

        <button
            @click="emit('kembali')"
            class="flex h-12 shrink-0 items-center border-b-2 border-transparent px-1 text-sm font-medium text-slate-500 transition hover:border-emerald-300 hover:text-emerald-700"
        >
            Daftar & Ringkasan
        </button>

        <button
            @click="emit('menu-change', 'riwayat')"
            class="relative flex h-12 shrink-0 items-center border-b-2 border-emerald-600 px-1 text-sm font-semibold text-emerald-700"
        >
            Riwayat Stok
        </button>

         <button
            type="button"
            @click="emit('menu-change', 'hitung-stok')"
            class="relative flex h-12 shrink-0 items-center border-b-2 border-transparent px-1 text-sm font-medium text-slate-500 transition hover:border-emerald-300 hover:text-emerald-700"
        >
            Hitung Stok
        </button>

        <button
            @click="emit('menu-change', 'harga')"
            class="flex h-12 shrink-0 items-center border-b-2 border-transparent px-1 text-sm font-medium text-slate-500 transition hover:border-emerald-300 hover:text-emerald-700"
        >
            Harga & Aturan
        </button>

    </div>
</div>

        <!-- Konten riwayat stok -->
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">

            <!-- Toolbar -->
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">

                <div class="flex flex-wrap items-center gap-2">

                    <!-- Rekap dan Rinci -->
                    <div class="flex items-center rounded-xl border border-slate-200 p-1">
                        <button
                            @click="activeView = 'rekap'"
                            class="flex h-10 items-center gap-2 rounded-lg px-4 text-sm font-semibold transition"
                            :class="activeView === 'rekap'
                                ? 'bg-emerald-600 text-white shadow-sm'
                                : 'text-slate-600 hover:bg-slate-50'"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <path d="M9 3v18M3 9h18"/>
                            </svg>
                            Rekap
                        </button>

                        <button
                            @click="activeView = 'rinci'"
                            class="flex h-10 items-center gap-2 rounded-lg px-4 text-sm font-medium transition"
                            :class="activeView === 'rinci'
                                ? 'bg-emerald-600 text-white shadow-sm'
                                : 'text-slate-600 hover:bg-slate-50'"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" d="M9 6h11M9 12h11M9 18h11"/>
                                <path stroke-linecap="round" d="M4 6h.01M4 12h.01M4 18h.01"/>
                            </svg>
                            Rinci
                        </button>
                    </div>

                    <!-- Pilihan bulan -->
                    <select
                        v-model="bulan"
                        class="h-12 min-w-[150px] rounded-xl border border-slate-200 bg-white px-4 text-sm text-slate-700 outline-none focus:border-emerald-500"
                    >
                        <option
                            v-for="item in bulanOptions"
                            :key="item.value"
                            :value="item.value"
                        >
                            {{ item.label }}
                        </option>
                    </select>

                    <!-- Pilihan tahun -->
                    <select
                        v-model="tahun"
                        class="h-12 min-w-[110px] rounded-xl border border-slate-200 bg-white px-4 text-sm text-slate-700 outline-none focus:border-emerald-500"
                    >
                        <option v-for="year in [2025, 2026, 2027]" :key="year">
                            {{ year }}
                        </option>
                    </select>
                </div>

                <!-- Export -->
                <div class="flex items-center gap-2">
                    <button
                        @click="exportPDF"
                        class="flex h-11 items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 text-sm text-slate-700 transition hover:bg-slate-50"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path d="M7 3h7l5 5v13H5V5a2 2 0 012-2z"/>
                            <path d="M14 3v5h5M8 15h8M8 18h5"/>
                        </svg>
                        PDF Rekap
                    </button>

                    <button
                        @click="exportExcel"
                        class="flex h-11 items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 text-sm text-slate-700 transition hover:bg-slate-50"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m-5-5l5 5 5-5M5 17v4h14v-4"/>
                        </svg>
                        Excel Rekap
                    </button>
                </div>
            </div>

            <!-- Pencarian dan filter -->
            <div class="mb-6 flex flex-wrap items-center gap-3">

                <div class="relative w-full md:max-w-[430px]">
                    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="11" cy="11" r="7"/>
                        <path stroke-linecap="round" d="m20 20-4-4"/>
                    </svg>

                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari nama atau kode sparepart..."
                        class="h-12 w-full rounded-xl border border-slate-200 bg-white pl-11 pr-4 text-sm outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    />
                </div>

                <button
                    @click="setFilter('bergerak')"
                    class="rounded-full border px-4 py-2 text-sm transition"
                    :class="activeFilter === 'bergerak'
                        ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                        : 'border-slate-200 text-slate-600 hover:border-emerald-300'"
                >
                    Ada stok / bergerak {{ jumlahBergerak }}
                </button>

                <button
                    @click="setFilter('semua')"
                    class="rounded-full border px-4 py-2 text-sm transition"
                    :class="activeFilter === 'semua'
                        ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                        : 'border-slate-200 text-slate-600 hover:border-emerald-300'"
                >
                    Semua {{ riwayat.length }}
                </button>

                <div class="group relative">
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" d="M12 11v5m0-8h.01"/>
                    </svg>
                    <div class="absolute left-0 top-6 z-20 hidden w-52 rounded-lg bg-slate-800 p-3 text-xs text-white shadow-lg group-hover:block">
                        Menampilkan sparepart yang memiliki pergerakan stok atau seluruh sparepart.
                    </div>
                </div>
            </div>

            <!-- Tabel rekap -->
            <div v-if="activeView === 'rekap'" class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full min-w-[800px] text-sm">

                    <thead>
                        <tr class="border-b border-slate-200 text-slate-600">
                            <th class="w-14 px-4 py-4 text-left font-semibold">No.</th>
                            <th class="px-4 py-4 text-left font-semibold">Sparepart</th>
                            <th class="px-4 py-4 text-right font-semibold">Saldo Awal</th>
                            <th class="px-4 py-4 text-right font-semibold">Masuk</th>
                            <th class="px-4 py-4 text-right font-semibold">Keluar</th>
                            <th class="px-4 py-4 text-right font-semibold">Saldo Akhir</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template v-for="(item, index) in filteredRiwayat" :key="item.id">

                            <tr v-if="index === 0 || filteredRiwayat[index - 1].kategori !== item.kategori">
                                <td colspan="6" class="bg-slate-50 px-4 py-3 text-xs font-semibold uppercase text-slate-600">
                                    {{ item.kategori }}
                                </td>
                            </tr>

                            <tr
                                class="border-b border-slate-100 transition hover:bg-slate-50"
                                :class="expandedId === item.id ? 'bg-emerald-50/40' : ''"
                            >
                                <td class="px-4 py-5 text-slate-500">{{ index + 1 }}</td>

                                <td class="px-4 py-5">
                                    <button
                                        @click="expandedId = expandedId === item.id ? null : item.id"
                                        class="text-left"
                                    >
                                        <span class="font-medium text-slate-800">{{ item.nama }}</span>
                                        <span class="ml-2 text-xs text-slate-500">{{ item.kode }}</span>
                                    </button>
                                </td>

                                <td class="px-4 py-5 text-right text-slate-700">
                                    {{ formatAngka(item.saldoAwal) }}
                                </td>

                                <td class="px-4 py-5 text-right font-medium text-emerald-600">
                                    {{ item.masuk > 0 ? '+' + formatAngka(item.masuk) : '–' }}
                                </td>

                                <td class="px-4 py-5 text-right font-medium text-orange-600">
                                    {{ item.keluar > 0 ? '-' + formatAngka(item.keluar) : '–' }}
                                </td>

                                <td class="px-4 py-5 text-right font-semibold text-slate-800">
                                    {{ formatAngka(item.saldoAkhir) }}
                                    <span class="text-xs font-normal text-slate-500">{{ item.satuan }}</span>
                                </td>
                            </tr>

                            <tr v-if="expandedId === item.id">
                                <td colspan="6" class="bg-slate-50 px-6 py-4">
                                    <p class="mb-2 text-xs font-semibold text-slate-500">Detail pergerakan stok</p>
                                    <p v-if="item.detail.length === 0" class="text-sm text-slate-500">
                                        Belum ada transaksi stok pada periode ini.
                                    </p>
                                </td>
                            </tr>
                        </template>

                        <tr v-if="filteredRiwayat.length === 0">
                            <td colspan="6" class="py-16 text-center text-sm text-slate-400">
                                Tidak ada data sparepart yang ditemukan.
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr class="border-t-2 border-slate-200 bg-slate-50 font-semibold text-slate-800">
                            <td colspan="2" class="px-4 py-6 uppercase">
                                TOTAL · {{ namaBulan }} {{ tahun }}
                            </td>
                            <td class="px-4 py-6 text-right">{{ formatAngka(totalAwal) }}</td>
                            <td class="px-4 py-6 text-right text-emerald-600">+{{ formatAngka(totalMasuk) }}</td>
                            <td class="px-4 py-6 text-right">{{ totalKeluar > 0 ? '-' + formatAngka(totalKeluar) : '–' }}</td>
                            <td class="px-4 py-6 text-right">{{ formatAngka(totalAkhir) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Tampilan rinci -->
            <div v-else class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full min-w-[800px] text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-slate-600">
                            <th class="px-4 py-4 font-semibold">Tanggal</th>
                            <th class="px-4 py-4 font-semibold">Sparepart</th>
                            <th class="px-4 py-4 font-semibold">Jenis Transaksi</th>
                            <th class="px-4 py-4 text-right font-semibold">Masuk</th>
                            <th class="px-4 py-4 text-right font-semibold">Keluar</th>
                            <th class="px-4 py-4 font-semibold">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="py-16 text-center text-sm text-slate-400">
                                Belum ada detail transaksi stok pada {{ namaBulan }} {{ tahun }}.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Keterangan bawah -->
            <div class="mt-6 text-sm text-slate-500">
                Klik satu baris untuk melihat rinciannya.
                {{ namaBulan }} {{ tahun }} · cabang Pusat.
            </div>

        </div>
    </div>
</template>


<script setup>
import { ref, computed } from 'vue';

const emit = defineEmits(['change-tab']);

const tabs = [
    'Daftar Pembelian',
    'Pesanan ke Supplier',
    'Terima Barang',
    'Riwayat Harga Beli',
    'Laporan',
];

const reportTabs = [
    'Per Hari',
    'Per Bulan',
    'Per Supplier',
    'Per Nota',
];

const activeReportTab = ref('Per Hari');
const currentPage = ref(1);
const perPage = ref(31);

const periodeMulai = ref('2026-11-01');
const periodeAkhir = ref('2026-11-30');
const periodeAktif = ref({
    mulai: '2026-11-01',
    akhir: '2026-11-30',
});

const applied = ref(true);

// Data sementara, silakan isi dengan data pembelian dari database.
const laporan = ref([]);

const formatRupiah = (angka) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka);
};

const formatTanggal = (tanggal) => {
    return new Date(tanggal + 'T00:00:00').toLocaleDateString(
        'id-ID',
        {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        }
    );
};

const formatBulan = (tanggal) => {
    return new Date(tanggal + 'T00:00:00').toLocaleDateString(
        'id-ID',
        {
            month: 'long',
            year: 'numeric',
        }
    );
};

// Filter berdasarkan periode
const filteredLaporan = computed(() => {
    if (!applied.value) return [];

    return laporan.value.filter(item =>
        item.tanggal >= periodeAktif.value.mulai &&
        item.tanggal <= periodeAktif.value.akhir
    );
});

// Ringkasan
const jumlahNota = computed(() => {
    return filteredLaporan.value.length;
});

const jumlahSupplier = computed(() => {
    return new Set(
        filteredLaporan.value.map(item => item.supplier)
    ).size;
});

const totalPembelian = computed(() => {
    return filteredLaporan.value.reduce(
        (total, item) => total + item.total,
        0
    );
});

const totalDibayar = computed(() => {
    return filteredLaporan.value.reduce(
        (total, item) => total + item.dibayar,
        0
    );
});

const totalUtang = computed(() => {
    return filteredLaporan.value.reduce(
        (total, item) => total + item.sisaUtang,
        0
    );
});

// Data tabel berdasarkan tab laporan
const tableData = computed(() => {
    const data = filteredLaporan.value;

    if (activeReportTab.value === 'Per Hari') {
        const grouped = {};

        data.forEach(item => {
            const key = item.tanggal;

            if (!grouped[key]) {
                grouped[key] = {
                    id: key,
                    tanggal: key,
                    nota: 0,
                    total: 0,
                    dibayar: 0,
                    sisaUtang: 0,
                };
            }

            grouped[key].nota++;
            grouped[key].total += item.total;
            grouped[key].dibayar += item.dibayar;
            grouped[key].sisaUtang += item.sisaUtang;
        });

        return Object.values(grouped).sort(
            (a, b) => b.tanggal.localeCompare(a.tanggal)
        );
    }

    if (activeReportTab.value === 'Per Bulan') {
        const grouped = {};

        data.forEach(item => {
            const key = item.tanggal.substring(0, 7);

            if (!grouped[key]) {
                grouped[key] = {
                    id: key,
                    periode: key,
                    nota: 0,
                    total: 0,
                    dibayar: 0,
                    sisaUtang: 0,
                };
            }

            grouped[key].nota++;
            grouped[key].total += item.total;
            grouped[key].dibayar += item.dibayar;
            grouped[key].sisaUtang += item.sisaUtang;
        });

        return Object.values(grouped).sort(
            (a, b) => b.periode.localeCompare(a.periode)
        );
    }

    if (activeReportTab.value === 'Per Supplier') {
        const grouped = {};

        data.forEach(item => {
            const key = item.supplier;

            if (!grouped[key]) {
                grouped[key] = {
                    id: key,
                    supplier: key,
                    nota: 0,
                    total: 0,
                    dibayar: 0,
                    sisaUtang: 0,
                };
            }

            grouped[key].nota++;
            grouped[key].total += item.total;
            grouped[key].dibayar += item.dibayar;
            grouped[key].sisaUtang += item.sisaUtang;
        });

        return Object.values(grouped);
    }

    return data.map(item => ({
        ...item,
        id: item.id,
    })).sort((a, b) =>
        b.tanggal.localeCompare(a.tanggal)
    );
});

// Pagination
const totalPages = computed(() => {
    return Math.max(
        1,
        Math.ceil(tableData.value.length / Number(perPage.value))
    );
});

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * Number(perPage.value);

    return tableData.value.slice(
        start,
        start + Number(perPage.value)
    );
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

// Terapkan periode
const terapkanPeriode = () => {
    if (!periodeMulai.value || !periodeAkhir.value) {
        return;
    }

    if (periodeMulai.value > periodeAkhir.value) {
        alert('Tanggal awal tidak boleh melebihi tanggal akhir.');
        return;
    }

    periodeAktif.value = {
        mulai: periodeMulai.value,
        akhir: periodeAkhir.value,
    };

    applied.value = true;
    currentPage.value = 1;
};

// Ganti tab laporan
const changeReportTab = (tab) => {
    activeReportTab.value = tab;
    currentPage.value = 1;
};

// Navigasi halaman pembelian
const handleTabClick = (index) => {
    const destinations = [
        'pembelian',
        'pesanan',
        'terima',
        'riwayat',
        'laporan',
    ];

    if (index !== 4) {
        emit('change-tab', destinations[index]);
    }
};
</script>

<template>
    <div class="min-h-screen bg-slate-50/70">

        <!-- Header Navigasi -->
        <div class="flex items-center justify-end px-6 py-4">
            <button
                class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
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
                        d="M12 3v12m0 0l-4-4m4 4l4-4M5 17v3h14v-3"
                    />
                </svg>

                Dokumen

                <svg
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </button>
        </div>

        <!-- Tab Pembelian -->
        <div class="border-b border-slate-200 bg-white px-6">
            <div class="flex gap-1 overflow-x-auto">

                <button
                    v-for="(tab, index) in tabs"
                    :key="tab"
                    @click="handleTabClick(index)"
                    :class="[
                        'whitespace-nowrap border-b-2 px-5 py-4 text-sm font-medium transition',
                        index === 4
                            ? 'border-emerald-600 text-emerald-600'
                            : 'border-transparent text-slate-500 hover:border-emerald-300 hover:text-emerald-600'
                    ]"
                >
                    {{ tab }}
                </button>

            </div>
        </div>

        <!-- Konten Laporan -->
        <div class="space-y-4 p-4 sm:p-6">

            <!-- Filter Periode -->
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                <div class="mb-2 flex items-center gap-2">
                    <label class="text-sm font-medium text-slate-600">
                        Periode
                    </label>

                    <span
                        title="Pilih periode laporan pembelian"
                        class="cursor-help text-xs text-slate-400"
                    >
                        ⓘ
                    </span>
                </div>

                <div class="flex flex-wrap items-center gap-3">

                    <div class="flex w-full max-w-[535px] items-center gap-2 rounded-lg border border-slate-200 px-3 py-2.5 focus-within:border-emerald-400">

                        <input
                            v-model="periodeMulai"
                            type="date"
                            class="min-w-0 flex-1 bg-transparent text-sm text-slate-700 outline-none"
                        />

                        <span class="text-slate-400">→</span>

                        <input
                            v-model="periodeAkhir"
                            type="date"
                            class="min-w-0 flex-1 bg-transparent text-sm text-slate-700 outline-none"
                        />

                    </div>

                    <button
                        @click="terapkanPeriode"
                        class="rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                    >
                        Terapkan
                    </button>

                </div>
            </div>

            <!-- Card Ringkasan -->
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">

                <!-- Jumlah Nota -->
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-medium text-slate-500">
                        Jumlah Nota
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ jumlahNota }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        {{ jumlahSupplier }} supplier
                    </p>
                </div>

                <!-- Total Pembelian -->
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-medium text-slate-500">
                        Total Pembelian
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ formatRupiah(totalPembelian) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Nota yang sudah menambah stok
                    </p>
                </div>

                <!-- Sudah Dibayar -->
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-medium text-slate-500">
                        Sudah Dibayar
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ formatRupiah(totalDibayar) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Dari nota pada periode ini
                    </p>
                </div>

                <!-- Sisa Utang -->
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-medium text-slate-500">
                        Sisa Utang
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ formatRupiah(totalUtang) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Dari nota pada periode ini
                    </p>
                </div>

            </div>

            <!-- Informasi Laporan -->
            <div class="flex flex-wrap items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600">

                <svg
                    class="h-4 w-4 shrink-0 text-emerald-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <circle cx="12" cy="12" r="9" />
                    <path
                        stroke-linecap="round"
                        d="M12 11v5m0-8h.01"
                    />
                </svg>

                <span v-if="jumlahNota > 0">
                    {{ jumlahNota }} nota, total {{ formatRupiah(totalPembelian) }},
                    sudah dibayar {{ formatRupiah(totalDibayar) }},
                    sisa utang {{ formatRupiah(totalUtang) }}.
                </span>

                <span v-else>
                    0 nota, total Rp0, sisa utang Rp0.
                    Belum ada pembelian yang menambah stok di periode ini.
                </span>

            </div>

            <!-- Tab Jenis Laporan -->
            <div class="border-b border-slate-200">

                <div class="flex gap-1 overflow-x-auto">

                    <button
                        v-for="tab in reportTabs"
                        :key="tab"
                        @click="changeReportTab(tab)"
                        :class="[
                            'whitespace-nowrap border-b-2 px-3 py-3 text-sm font-medium transition',
                            activeReportTab === tab
                                ? 'border-emerald-600 text-emerald-600'
                                : 'border-transparent text-slate-500 hover:text-emerald-600'
                        ]"
                    >
                        {{ tab }}
                    </button>

                </div>
            </div>

            <!-- Tabel Laporan -->
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="overflow-x-auto">

                    <!-- Per Hari -->
                    <table
                        v-if="activeReportTab === 'Per Hari'"
                        class="w-full min-w-[750px] border-collapse text-left"
                    >
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-medium text-slate-500">
                                <th class="px-3 py-4">Tanggal</th>
                                <th class="px-3 py-4 text-center">Nota</th>
                                <th class="px-3 py-4 text-right">Total</th>
                                <th class="px-3 py-4 text-right">Sudah Dibayar</th>
                                <th class="px-3 py-4 text-right">Sisa Utang</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="item in paginatedData"
                                :key="item.id"
                                class="border-b border-slate-100 text-sm transition hover:bg-slate-50"
                            >
                                <td class="px-3 py-5 text-slate-700">
                                    {{ formatTanggal(item.tanggal) }}
                                </td>

                                <td class="px-3 py-5 text-center text-slate-700">
                                    {{ item.nota }}
                                </td>

                                <td class="px-3 py-5 text-right font-medium text-slate-800">
                                    {{ formatRupiah(item.total) }}
                                </td>

                                <td class="px-3 py-5 text-right text-slate-700">
                                    {{ formatRupiah(item.dibayar) }}
                                </td>

                                <td class="px-3 py-5 text-right text-slate-700">
                                    {{ formatRupiah(item.sisaUtang) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Per Bulan -->
                    <table
                        v-else-if="activeReportTab === 'Per Bulan'"
                        class="w-full min-w-[750px] border-collapse text-left"
                    >
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-medium text-slate-500">
                                <th class="px-3 py-4">Bulan</th>
                                <th class="px-3 py-4 text-center">Nota</th>
                                <th class="px-3 py-4 text-right">Total</th>
                                <th class="px-3 py-4 text-right">Sudah Dibayar</th>
                                <th class="px-3 py-4 text-right">Sisa Utang</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="item in paginatedData"
                                :key="item.id"
                                class="border-b border-slate-100 text-sm hover:bg-slate-50"
                            >
                                <td class="px-3 py-5 text-slate-700">
                                    {{ formatBulan(item.periode + '-01') }}
                                </td>

                                <td class="px-3 py-5 text-center">
                                    {{ item.nota }}
                                </td>

                                <td class="px-3 py-5 text-right font-medium">
                                    {{ formatRupiah(item.total) }}
                                </td>

                                <td class="px-3 py-5 text-right">
                                    {{ formatRupiah(item.dibayar) }}
                                </td>

                                <td class="px-3 py-5 text-right">
                                    {{ formatRupiah(item.sisaUtang) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Per Supplier -->
                    <table
                        v-else-if="activeReportTab === 'Per Supplier'"
                        class="w-full min-w-[750px] border-collapse text-left"
                    >
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-medium text-slate-500">
                                <th class="px-3 py-4">Supplier</th>
                                <th class="px-3 py-4 text-center">Jumlah Nota</th>
                                <th class="px-3 py-4 text-right">Total</th>
                                <th class="px-3 py-4 text-right">Sudah Dibayar</th>
                                <th class="px-3 py-4 text-right">Sisa Utang</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="item in paginatedData"
                                :key="item.id"
                                class="border-b border-slate-100 text-sm hover:bg-slate-50"
                            >
                                <td class="px-3 py-5 font-medium text-slate-700">
                                    {{ item.supplier }}
                                </td>

                                <td class="px-3 py-5 text-center">
                                    {{ item.nota }}
                                </td>

                                <td class="px-3 py-5 text-right font-medium">
                                    {{ formatRupiah(item.total) }}
                                </td>

                                <td class="px-3 py-5 text-right">
                                    {{ formatRupiah(item.dibayar) }}
                                </td>

                                <td class="px-3 py-5 text-right">
                                    {{ formatRupiah(item.sisaUtang) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Per Nota -->
                    <table
                        v-else
                        class="w-full min-w-[850px] border-collapse text-left"
                    >
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-medium text-slate-500">
                                <th class="px-3 py-4">Tanggal</th>
                                <th class="px-3 py-4">Nota</th>
                                <th class="px-3 py-4">Supplier</th>
                                <th class="px-3 py-4 text-right">Total</th>
                                <th class="px-3 py-4 text-right">Sudah Dibayar</th>
                                <th class="px-3 py-4 text-right">Sisa Utang</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="item in paginatedData"
                                :key="item.id"
                                class="border-b border-slate-100 text-sm hover:bg-slate-50"
                            >
                                <td class="whitespace-nowrap px-3 py-5 text-slate-700">
                                    {{ formatTanggal(item.tanggal) }}
                                </td>

                                <td class="px-3 py-5 font-medium text-emerald-600">
                                    {{ item.nomor }}
                                </td>

                                <td class="px-3 py-5 text-slate-700">
                                    {{ item.supplier }}
                                </td>

                                <td class="px-3 py-5 text-right font-medium">
                                    {{ formatRupiah(item.total) }}
                                </td>

                                <td class="px-3 py-5 text-right">
                                    {{ formatRupiah(item.dibayar) }}
                                </td>

                                <td class="px-3 py-5 text-right">
                                    {{ formatRupiah(item.sisaUtang) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <!-- Data Kosong -->
                <div
                    v-if="paginatedData.length === 0"
                    class="flex min-h-[125px] items-center justify-center px-4 py-12"
                >
                    <p class="text-center text-sm text-slate-500">
                        Belum ada pembelian pada periode ini.
                    </p>
                </div>

                <!-- Footer Pagination -->
                <div class="flex flex-wrap items-center justify-between gap-3 p-4 text-sm text-slate-500">

                    <div class="flex flex-wrap items-center gap-2">

                        <span>Tampilkan</span>

                        <select
                            v-model="perPage"
                            @change="currentPage = 1"
                            class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 outline-none focus:border-emerald-400"
                        >
                            <option :value="10">10</option>
                            <option :value="20">20</option>
                            <option :value="31">31</option>
                            <option :value="50">50</option>
                            <option :value="100">100</option>
                        </select>

                        <span>per halaman</span>

                        <span>·</span>

                        <span>
                            {{ tableData.length === 0
                                ? '0 data'
                                : `Menampilkan ${(currentPage - 1) * perPage + 1}–${Math.min(currentPage * perPage, tableData.length)} dari ${tableData.length} data`
                            }}
                        </span>

                    </div>

                    <div class="flex items-center gap-2">

                        <button
                            @click="changePage(currentPage - 1)"
                            :disabled="currentPage === 1"
                            class="rounded-lg border border-slate-200 px-3 py-1.5 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                        >
                            ‹
                        </button>

                        <button
                            class="rounded-lg bg-emerald-600 px-3.5 py-1.5 font-medium text-white"
                        >
                            {{ currentPage }}
                        </button>

                        <button
                            @click="changePage(currentPage + 1)"
                            :disabled="currentPage >= totalPages"
                            class="rounded-lg border border-slate-200 px-3 py-1.5 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                        >
                            ›
                        </button>

                    </div>
                </div>

            </div>

        </div>
    </div>
</template>


<script setup>
import { ref, computed } from 'vue';

const emit = defineEmits(['change-tab']);

const search = ref('');
const currentPage = ref(1);
const perPage = ref(20);
const sortAscending = ref(true);

const tabs = [
    'Daftar Pembelian',
    'Pesanan ke Supplier',
    'Terima Barang',
    'Riwayat Harga Beli',
    'Laporan',
];

// Data sementara riwayat harga beli
const riwayatHarga = ref([
    {
        id: 1,
        kode: 'BRG-000002',
        sparepart: 'Aki mobil',
        supplier: 'Toko Astraboy',
        hargaTerakhir: 150000,
        hargaSebelumnya: null,
        tanggal: '13 Oktober 2026',
    },
    {
        id: 2,
        kode: 'BRG-000001',
        sparepart: 'Radiator',
        supplier: 'Toko Astraboy',
        hargaTerakhir: 100000,
        hargaSebelumnya: null,
        tanggal: '19 Oktober 2026',
    },
]);

const formatRupiah = (angka) => {
    if (angka === null || angka === undefined) {
        return '—';
    }

    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka);
};

// Pencarian
const filteredRiwayat = computed(() => {
    const keyword = search.value.toLowerCase();

    return riwayatHarga.value
        .filter(item => {
            return (
                item.sparepart.toLowerCase().includes(keyword) ||
                item.kode.toLowerCase().includes(keyword) ||
                item.supplier.toLowerCase().includes(keyword)
            );
        })
        .sort((a, b) => {
            return sortAscending.value
                ? a.sparepart.localeCompare(b.sparepart)
                : b.sparepart.localeCompare(a.sparepart);
        });
});

// Pagination
const paginatedRiwayat = computed(() => {
    const start = (currentPage.value - 1) * Number(perPage.value);

    return filteredRiwayat.value.slice(
        start,
        start + Number(perPage.value)
    );
});

const totalPages = computed(() => {
    return Math.max(
        1,
        Math.ceil(filteredRiwayat.value.length / Number(perPage.value))
    );
});

const toggleSort = () => {
    sortAscending.value = !sortAscending.value;
    currentPage.value = 1;
};

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const changePerPage = () => {
    currentPage.value = 1;
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

        <!-- Navigasi Tab -->
        <div class="border-b border-slate-200 bg-white px-6">
            <div class="flex h-[53px] items-stretch gap-1 overflow-x-auto">

                <button
                    v-for="(tab, index) in tabs"
                    :key="tab"
                    @click="
                        index === 0
                            ? emit('change-tab', 'pembelian')
                            : index === 1
                            ? emit('change-tab', 'pesanan')
                            : index === 2
                            ? emit('change-tab', 'terima')
                             : index === 4
        ? emit('change-tab', 'laporan')
                            : null
                    "
                    :class="[
                        'flex h-full shrink-0 items-center whitespace-nowrap border-b-2 px-5 text-sm font-medium transition',
                        index === 3
                            ? 'border-emerald-600 text-emerald-600'
                            : 'border-transparent text-slate-500 hover:border-emerald-300 hover:text-emerald-600'
                    ]"
                >
                    {{ tab }}
                </button>

            </div>
        </div>

        <!-- Konten Riwayat Harga -->
        <div class="p-4 sm:p-6">

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="p-5">

                    <!-- Search -->
                    <div class="mb-4">

                        <div class="relative max-w-md">

                            <svg
                                class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle cx="11" cy="11" r="7" />
                                <path d="m16 16 4 4" />
                            </svg>

                            <input
                                v-model="search"
                                @input="currentPage = 1"
                                type="text"
                                placeholder="Cari sparepart atau supplier..."
                                class="w-full rounded-lg border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 sm:w-[396px]"
                            />

                        </div>

                    </div>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">

                        <table class="w-full min-w-[850px] border-collapse text-left">

                            <thead>
                                <tr class="border-b border-slate-200 text-sm font-medium text-slate-500">

                                    <th class="px-4 py-4">

                                        <button
                                            @click="toggleSort"
                                            class="flex items-center gap-2 text-slate-700 transition hover:text-emerald-600"
                                        >
                                            Sparepart

                                            <span class="flex flex-col text-[10px] leading-[8px]">
                                                <span
                                                    :class="sortAscending ? 'text-emerald-600' : 'text-slate-300'"
                                                >
                                                    ▲
                                                </span>
                                                <span
                                                    :class="!sortAscending ? 'text-emerald-600' : 'text-slate-300'"
                                                >
                                                    ▼
                                                </span>
                                            </span>
                                        </button>

                                    </th>

                                    <th class="px-4 py-4">
                                        Supplier
                                    </th>

                                    <th class="px-4 py-4 text-right">
                                        Harga beli terakhir
                                    </th>

                                    <th class="px-4 py-4 text-right">
                                        Dibanding sebelumnya
                                    </th>

                                    <th class="px-4 py-4 text-right">
                                        Tanggal
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                <tr
                                    v-for="item in paginatedRiwayat"
                                    :key="item.id"
                                    class="border-b border-slate-100 transition hover:bg-slate-50/70 even:bg-slate-50/70"
                                >

                                    <!-- Sparepart -->
                                    <td class="px-4 py-5">

                                        <p class="text-sm font-medium text-slate-800">
                                            {{ item.sparepart }}
                                        </p>

                                        <p class="mt-0.5 text-sm text-slate-500">
                                            {{ item.kode }}
                                        </p>

                                    </td>

                                    <!-- Supplier -->
                                    <td class="px-4 py-5 text-sm text-slate-700">
                                        {{ item.supplier }}
                                    </td>

                                    <!-- Harga terakhir -->
                                    <td class="whitespace-nowrap px-4 py-5 text-right text-sm font-medium text-slate-800">
                                        {{ formatRupiah(item.hargaTerakhir) }}
                                    </td>

                                    <!-- Perbandingan -->
                                    <td class="whitespace-nowrap px-4 py-5 text-right text-sm">

                                        <span
                                            v-if="item.hargaSebelumnya === null"
                                            class="text-slate-500"
                                        >
                                            —
                                        </span>

                                        <span
                                            v-else-if="item.hargaTerakhir > item.hargaSebelumnya"
                                            class="font-medium text-red-500"
                                        >
                                            +{{ formatRupiah(item.hargaTerakhir - item.hargaSebelumnya) }}
                                        </span>

                                        <span
                                            v-else-if="item.hargaTerakhir < item.hargaSebelumnya"
                                            class="font-medium text-emerald-600"
                                        >
                                            -{{ formatRupiah(item.hargaSebelumnya - item.hargaTerakhir) }}
                                        </span>

                                        <span
                                            v-else
                                            class="text-slate-500"
                                        >
                                            Tetap
                                        </span>

                                    </td>

                                    <!-- Tanggal -->
                                    <td class="whitespace-nowrap px-4 py-5 text-right text-sm text-slate-700">
                                        {{ item.tanggal }}
                                    </td>

                                </tr>

                                <!-- Data kosong -->
                                <tr v-if="paginatedRiwayat.length === 0">

                                    <td colspan="5" class="px-4 py-16 text-center">

                                        <p class="text-sm font-medium text-slate-600">
                                            Data riwayat harga beli tidak ditemukan
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Coba gunakan nama sparepart atau supplier lainnya.
                                        </p>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                    <!-- Footer Pagination -->
                    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 text-sm text-slate-500">

                        <div class="flex flex-wrap items-center gap-2">

                            <span>Tampilkan</span>

                            <select
                                v-model="perPage"
                                @change="changePerPage"
                                class="rounded-lg border border-slate-200 bg-white px-3 py-2 outline-none transition focus:border-emerald-400"
                            >
                                <option :value="10">10</option>
                                <option :value="20">20</option>
                                <option :value="50">50</option>
                                <option :value="100">100</option>
                            </select>

                            <span>per halaman</span>

                            <span>·</span>

                            <span>
                                Menampilkan
                                {{ filteredRiwayat.length
                                    ? (currentPage - 1) * perPage + 1
                                    : 0
                                }}–{{ Math.min(
                                    currentPage * perPage,
                                    filteredRiwayat.length
                                ) }}
                                dari {{ filteredRiwayat.length }} data
                            </span>

                        </div>

                        <div class="flex items-center gap-2">

                            <button
                                @click="changePage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="rounded-lg border border-slate-200 px-3 py-2 transition hover:bg-emerald-50 hover:text-emerald-600 disabled:cursor-not-allowed disabled:opacity-40"
                            >
                                ‹
                            </button>

                            <button
                                class="rounded-lg bg-emerald-600 px-4 py-2 font-medium text-white"
                            >
                                {{ currentPage }}
                            </button>

                            <button
                                @click="changePage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="rounded-lg border border-slate-200 px-3 py-2 transition hover:bg-emerald-50 hover:text-emerald-600 disabled:cursor-not-allowed disabled:opacity-40"
                            >
                                ›
                            </button>

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
</template>

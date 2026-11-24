
<script setup>
import { ref, computed } from 'vue';

const emit = defineEmits(['change-tab']);

const search = ref('');
const activeFilter = ref('Menunggu barang');
const currentPage = ref(1);
const perPage = ref(20);

const tabs = [
    'Daftar Pembelian',
    'Pesanan ke Supplier',
    'Terima Barang',
    'Riwayat Harga Beli',
    'Laporan',
];

// Data pesanan yang masih menunggu barang
const waitingOrders = ref([]);

// Data contoh riwayat penerimaan
const historyOrders = ref([
    {
        id: 1,
        nomor: 'PO-000004',
        tanggal: '13 Oktober 2026',
        tanggalTerima: '14 Oktober 2026',
        supplier: 'Toko Astraboy',
        jumlah: 5,
        status: 'Selesai',
    },
    {
        id: 2,
        nomor: 'PO-000003',
        tanggal: '13 Oktober 2026',
        tanggalTerima: '14 Oktober 2026',
        supplier: 'Toko Astraboy',
        jumlah: 1,
        status: 'Selesai',
    },
    {
        id: 3,
        nomor: 'PO-000002',
        tanggal: '13 Oktober 2026',
        tanggalTerima: '15 Oktober 2026',
        supplier: 'Toko Astraboy',
        jumlah: 3,
        status: 'Diterima sebagian',
    },
]);

const activeOrders = computed(() => {
    return activeFilter.value === 'Menunggu barang'
        ? waitingOrders.value
        : historyOrders.value;
});

const filteredOrders = computed(() => {
    const keyword = search.value.toLowerCase();

    return activeOrders.value.filter(item => {
        return (
            item.nomor.toLowerCase().includes(keyword) ||
            item.supplier.toLowerCase().includes(keyword)
        );
    });
});

const paginatedOrders = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;

    return filteredOrders.value.slice(
        start,
        start + Number(perPage.value)
    );
});

const totalPages = computed(() => {
    return Math.max(
        1,
        Math.ceil(filteredOrders.value.length / perPage.value)
    );
});

const changeFilter = (filter) => {
    activeFilter.value = filter;
    currentPage.value = 1;
};

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const formatNumber = (number) => {
    return new Intl.NumberFormat('id-ID').format(number);
};
</script>

<template>
    <div class="min-h-screen bg-slate-50/70">

        <!-- Ringkasan Atas -->
        <div class="flex flex-wrap items-center gap-2 px-6 py-4">

            <button
                @click="changeFilter('Menunggu barang')"
                class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm transition hover:bg-emerald-50"
            >
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>

                <span class="font-semibold text-slate-800">
                    {{ waitingOrders.length }}
                </span>

                <span class="text-slate-600">
                    Pesanan ke Supplier menunggu barang
                </span>

                <span class="text-slate-400">›</span>
            </button>

            <button
                @click="changeFilter('Riwayat penerimaan')"
                class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm transition hover:bg-emerald-50"
            >
                <span class="font-semibold text-slate-800">
                    {{ historyOrders.length }}
                </span>

                <span class="text-slate-600">
                    penerimaan tercatat
                </span>

                <span class="text-slate-400">›</span>
            </button>

        </div>

       <!-- Tab Pembelian -->
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
        : index === 3
        ? emit('change-tab', 'riwayat')
         : index === 4
        ? emit('change-tab', 'laporan')
        : null
            "
            :class="[
                'flex h-full shrink-0 items-center whitespace-nowrap border-b-2 px-5 text-sm font-medium transition',
                index === 2
                    ? 'border-emerald-600 text-emerald-600'
                    : 'border-transparent text-slate-500 hover:border-emerald-300 hover:text-emerald-600'
            ]"
        >
            {{ tab }}
        </button>
    </div>
</div>
        <!-- Konten Utama -->
        <div class="p-4 sm:p-6">

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="p-5">

                    <!-- Pencarian -->
                    <div class="mb-3">
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
                                type="text"
                                placeholder="Cari nomor pesanan atau supplier..."
                                class="w-full rounded-lg border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 sm:w-[396px]"
                            />

                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="mb-6 flex flex-wrap items-center gap-2">

                        <button
                            @click="changeFilter('Menunggu barang')"
                            :class="[
                                'rounded-full border px-4 py-1.5 text-sm transition',
                                activeFilter === 'Menunggu barang'
                                    ? 'border-emerald-500 bg-emerald-50 text-emerald-600'
                                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
                            ]"
                        >
                            Menunggu barang
                            <span class="ml-1">
                                {{ waitingOrders.length }}
                            </span>
                        </button>

                        <button
                            @click="changeFilter('Riwayat penerimaan')"
                            :class="[
                                'rounded-full border px-4 py-1.5 text-sm transition',
                                activeFilter === 'Riwayat penerimaan'
                                    ? 'border-emerald-500 bg-emerald-50 text-emerald-600'
                                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
                            ]"
                        >
                            Riwayat penerimaan
                            <span class="ml-1">
                                {{ historyOrders.length }}
                            </span>
                        </button>

                        <span
                            class="text-slate-400"
                            title="Informasi penerimaan barang"
                        >
                            ⓘ
                        </span>

                    </div>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">

                        <table class="w-full min-w-[850px] border-collapse text-left">

                            <thead>
                                <tr class="border-b border-slate-200 text-sm font-medium text-slate-500">

                                    <th class="px-4 py-4">
                                        No. Pesanan
                                    </th>

                                    <th class="px-4 py-4 text-center">
                                        Tanggal Pesan
                                    </th>

                                    <th class="px-4 py-4">
                                        Supplier
                                    </th>

                                    <th
                                        v-if="activeFilter === 'Riwayat penerimaan'"
                                        class="px-4 py-4"
                                    >
                                        Tanggal Terima
                                    </th>

                                    <th class="px-4 py-4 text-center">
                                        Sudah Datang
                                    </th>

                                    <th class="px-4 py-4">
                                        Keadaan
                                        <span class="ml-1 text-slate-400">ⓘ</span>
                                    </th>

                                    <th class="px-4 py-4 text-center">
                                        Aksi
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                <!-- Data -->
                                <tr
                                    v-for="item in paginatedOrders"
                                    :key="item.id"
                                    class="border-b border-slate-100 transition hover:bg-slate-50"
                                >

                                    <td class="px-4 py-5">
                                        <span class="font-medium text-emerald-600">
                                            {{ item.nomor }}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-5 text-center text-sm text-slate-600">
                                        {{ item.tanggal }}
                                    </td>

                                    <td class="px-4 py-5 text-sm text-slate-700">
                                        {{ item.supplier }}
                                    </td>

                                    <td
                                        v-if="activeFilter === 'Riwayat penerimaan'"
                                        class="whitespace-nowrap px-4 py-5 text-sm text-slate-600"
                                    >
                                        {{ item.tanggalTerima }}
                                    </td>

                                    <td class="px-4 py-5 text-center text-sm text-slate-700">
                                        {{ item.jumlah }} barang
                                    </td>

                                    <td class="px-4 py-5">
                                        <div class="flex items-center gap-2">

                                            <span
                                                :class="[
                                                    'h-2.5 w-2.5 rounded-full',
                                                    item.status === 'Selesai'
                                                        ? 'bg-emerald-500'
                                                        : 'bg-amber-400'
                                                ]"
                                            ></span>

                                            <span class="text-sm text-slate-700">
                                                {{ item.status }}
                                            </span>

                                        </div>
                                    </td>

                                    <td class="px-4 py-5 text-center">

                                        <button
                                            class="rounded-lg border border-slate-200 p-2 text-slate-500 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-600"
                                            title="Lihat detail"
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
                                                    d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"
                                                />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </button>

                                    </td>

                                </tr>

                                <!-- Data Kosong -->
                                <tr v-if="paginatedOrders.length === 0">
                                    <td
                                        :colspan="activeFilter === 'Riwayat penerimaan' ? 7 : 6"
                                        class="h-[245px] px-4 py-12 text-center"
                                    >

                                        <div class="flex flex-col items-center justify-center">

                                            <svg
                                                class="mb-3 h-10 w-10 text-slate-200"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M3 7l9-5 9 5v10l-9 5-9-5V7z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M3 7l9 5 9-5M12 12v10M7.5 4.5l9 5"
                                                />
                                            </svg>

                                            <p class="text-base font-medium text-slate-800">
                                                {{ search
                                                    ? 'Data penerimaan tidak ditemukan.'
                                                    : activeFilter === 'Menunggu barang'
                                                        ? 'Tidak ada barang yang sedang ditunggu.'
                                                        : 'Belum ada riwayat penerimaan barang.'
                                                }}
                                            </p>

                                            <p class="mt-1 text-sm text-slate-500">
                                                {{ activeFilter === 'Menunggu barang'
                                                    ? 'Pesanan ke Supplier yang sudah dipesan dan belum lengkap diterima tampil di sini.'
                                                    : 'Riwayat barang yang sudah diterima akan ditampilkan di sini.'
                                                }}
                                            </p>

                                        </div>

                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                    <!-- Pagination -->
                    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 text-sm text-slate-500">

                        <div class="flex flex-wrap items-center gap-2">

                            <span>Tampilkan</span>

                            <select
                                v-model="perPage"
                                @change="currentPage = 1"
                                class="rounded-lg border border-slate-200 bg-white px-3 py-2 outline-none focus:border-emerald-400"
                            >
                                <option :value="10">10</option>
                                <option :value="20">20</option>
                                <option :value="50">50</option>
                                <option :value="100">100</option>
                            </select>

                            <span>per halaman</span>

                            <span>·</span>

                            <span>
                                {{ filteredOrders.length
                                    ? (currentPage - 1) * perPage + 1
                                    : 0
                                }}
                                -
                                {{ Math.min(
                                    currentPage * perPage,
                                    filteredOrders.length
                                ) }}
                                dari {{ formatNumber(filteredOrders.length) }} data
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

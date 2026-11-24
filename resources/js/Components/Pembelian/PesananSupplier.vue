
<script setup>
import { ref, computed } from 'vue';

const emit = defineEmits(['change-tab']);

const search = ref('');
const activeFilter = ref('Semua');
const currentPage = ref(1);
const perPage = ref(20);
const expandedId = ref(null);
const selectedOrder = ref(null);

const tabs = [
    'Daftar Pembelian',
    'Pesanan ke Supplier',
    'Terima Barang',
    'Riwayat Harga Beli',
    'Laporan',
];

const filters = [
    'Semua',
    'Belum selesai',
    'Dipesan',
    'Diterima sebagian',
    'Selesai',
    'Dibatalkan',
];

// Data sementara
const orders = ref([
    {
        id: 4,
        nomor: 'PO-000004',
        tanggal: '13 Oktober 2026',
        supplier: 'Toko Astraboy',
        jenis: 1,
        total: 500000,
        jumlahPesanan: 5,
        sudahDatang: 5,
        status: 'Selesai',
        products: [
            {
                nama: 'Oli Mesin MPX 2',
                jumlah: 5,
                harga: 100000,
            },
        ],
    },
    {
        id: 3,
        nomor: 'PO-000003',
        tanggal: '13 Oktober 2026',
        supplier: 'Toko Astraboy',
        jenis: 1,
        total: 100000,
        jumlahPesanan: 1,
        sudahDatang: 1,
        status: 'Selesai',
        products: [
            {
                nama: 'Busi NGK',
                jumlah: 1,
                harga: 100000,
            },
        ],
    },
    {
        id: 2,
        nomor: 'PO-000002',
        tanggal: '13 Oktober 2026',
        supplier: 'Toko Astraboy',
        jenis: 1,
        total: 15000000,
        jumlahPesanan: 10,
        sudahDatang: 3,
        status: 'Diterima sebagian',
        products: [
            {
                nama: 'Ban Motor',
                jumlah: 10,
                harga: 1500000,
            },
        ],
    },
    {
        id: 1,
        nomor: 'PO-000001',
        tanggal: '13 Oktober 2026',
        supplier: 'Toko Astraboy',
        jenis: 1,
        total: 1000000,
        jumlahPesanan: 10,
        sudahDatang: 0,
        status: 'Dipesan',
        products: [
            {
                nama: 'Kampas Rem',
                jumlah: 10,
                harga: 100000,
            },
        ],
    },
]);

const formatRupiah = (angka) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka);
};

const filteredOrders = computed(() => {
    return orders.value.filter(order => {
        const keyword = search.value.toLowerCase();

        const cocokSearch =
            order.nomor.toLowerCase().includes(keyword) ||
            order.supplier.toLowerCase().includes(keyword);

        const cocokFilter =
            activeFilter.value === 'Semua' ||
            (
                activeFilter.value === 'Belum selesai'
                    ? ['Dipesan', 'Diterima sebagian'].includes(order.status)
                    : order.status === activeFilter.value
            );

        return cocokSearch && cocokFilter;
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

const statusCount = (status) => {
    if (status === 'Semua') {
        return orders.value.length;
    }

    if (status === 'Belum selesai') {
        return orders.value.filter(order =>
            ['Dipesan', 'Diterima sebagian'].includes(order.status)
        ).length;
    }

    return orders.value.filter(
        order => order.status === status
    ).length;
};

const changeFilter = (filter) => {
    activeFilter.value = filter;
    currentPage.value = 1;
};

const toggleDetail = (id) => {
    expandedId.value = expandedId.value === id ? null : id;
};

const showDetail = (order) => {
    selectedOrder.value = order;
};

const closeDetail = () => {
    selectedOrder.value = null;
};

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};
</script>

<template>
    <div class="min-h-screen bg-slate-50/70">

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-end gap-3 px-6 py-4">

            <button
                class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
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

            <button
                class="flex items-center gap-2 rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
            >
                <span class="text-lg leading-none">+</span>
                Buat Pesanan
                <span class="text-xs text-emerald-200">Alt+N</span>
            </button>
        </div>

        <!-- Ringkasan -->
        <div class="flex flex-wrap gap-2 px-6 pb-4">

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="font-bold text-slate-900">
                    {{ orders.length }}
                </span>
                <span class="text-sm text-slate-500">
                    pesanan supplier
                </span>
                <span class="text-slate-400">›</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                <span class="font-bold text-slate-900">
                    {{ statusCount('Belum selesai') }}
                </span>
                <span class="text-sm text-slate-500">
                    belum selesai
                </span>
                <span class="text-slate-400">›</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="font-bold text-slate-900">
                    {{ formatRupiah(orders.reduce((total, item) => total + item.total, 0)) }}
                </span>
                <span class="text-sm text-slate-500">
                    nilai pesanan
                </span>
            </div>
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
        : index === 2
        ? emit('change-tab', 'terima')
        : index === 3
        ? emit('change-tab', 'riwayat')
         : index === 4
        ? emit('change-tab', 'laporan')
        : null
            "
            :class="[
                'flex h-full shrink-0 items-center whitespace-nowrap border-b-2 px-5 text-sm font-medium transition',
                index === 1
                    ? 'border-emerald-600 text-emerald-600'
                    : 'border-transparent text-slate-500 hover:border-emerald-300 hover:text-emerald-600'
            ]"
        >
            {{ tab }}
        </button>
    </div>
</div>

        <!-- Konten Pesanan Supplier -->
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
                                type="text"
                                placeholder="Cari nomor atau nama supplier"
                                class="w-full rounded-lg border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 sm:w-[400px]"
                            />
                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="mb-6 flex flex-wrap items-center gap-2">

                        <button
                            v-for="filter in filters"
                            :key="filter"
                            @click="changeFilter(filter)"
                            :class="[
                                'rounded-full border px-4 py-1.5 text-sm transition',
                                activeFilter === filter
                                    ? 'border-emerald-500 bg-emerald-50 text-emerald-600'
                                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
                            ]"
                        >
                            {{ filter }}

                            <span class="ml-1">
                                {{ statusCount(filter) }}
                            </span>
                        </button>

                        <span class="text-slate-400">ⓘ</span>
                    </div>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">

                        <table class="w-full min-w-[950px] border-collapse text-left">

                            <thead>
                                <tr class="border-b border-slate-200 text-xs font-medium text-slate-500">
                                    <th class="w-12 px-3 py-4"></th>
                                    <th class="px-3 py-4">Nomor</th>
                                    <th class="px-3 py-4">Tanggal Pesan</th>
                                    <th class="px-3 py-4">Supplier</th>
                                    <th class="px-3 py-4 text-center">Jenis Sparepart</th>
                                    <th class="px-3 py-4 text-right">Total Perkiraan</th>
                                    <th class="px-3 py-4 text-center">Sudah Datang</th>
                                    <th class="px-3 py-4">Keadaan</th>
                                    <th class="px-3 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <template
                                    v-for="item in paginatedOrders"
                                    :key="item.id"
                                >

                                    <tr class="border-b border-slate-100 transition hover:bg-slate-50/70">

                                        <!-- Expand -->
                                        <td class="px-3 py-5">
                                            <button
                                                @click="toggleDetail(item.id)"
                                                class="text-slate-400 hover:text-emerald-600"
                                            >
                                                <svg
                                                    :class="[
                                                        'h-4 w-4 transition-transform',
                                                        expandedId === item.id ? 'rotate-90' : ''
                                                    ]"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="m9 18 6-6-6-6" />
                                                </svg>
                                            </button>
                                        </td>

                                        <td class="px-3 py-5">
                                            <p class="font-medium text-emerald-600">
                                                {{ item.nomor }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-3 py-5 text-sm text-slate-700">
                                            {{ item.tanggal }}
                                        </td>

                                        <td class="px-3 py-5 text-sm text-slate-700">
                                            {{ item.supplier }}
                                        </td>

                                        <td class="px-3 py-5 text-center text-sm text-slate-700">
                                            {{ item.jenis }} jenis
                                        </td>

                                        <td class="whitespace-nowrap px-3 py-5 text-right text-sm font-semibold text-slate-800">
                                            {{ formatRupiah(item.total) }}
                                        </td>

                                        <td class="px-3 py-5 text-center text-sm text-slate-700">
                                            {{ item.sudahDatang }} dari {{ item.jumlahPesanan }}
                                        </td>

                                        <td class="px-3 py-5">
                                            <div class="flex items-center gap-2">

                                                <span
                                                    :class="[
                                                        'h-2.5 w-2.5 shrink-0 rounded-full',
                                                        item.status === 'Selesai'
                                                            ? 'bg-emerald-500'
                                                            : item.status === 'Dibatalkan'
                                                            ? 'bg-red-500'
                                                            : 'bg-amber-400'
                                                    ]"
                                                ></span>

                                                <span class="text-sm text-slate-700">
                                                    {{ item.status }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Aksi -->
                                        <td class="px-3 py-5 text-center">
                                            <button
                                                @click="showDetail(item)"
                                                title="Lihat detail"
                                                class="rounded-lg border border-slate-200 p-2 text-slate-500 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-600"
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

                                    <!-- Detail Barang -->
                                    <tr
                                        v-if="expandedId === item.id"
                                        class="border-b border-slate-100 bg-slate-50"
                                    >
                                        <td colspan="9" class="px-8 py-5">

                                            <p class="mb-4 text-sm font-semibold text-slate-700">
                                                Rincian Sparepart
                                            </p>

                                            <div class="overflow-x-auto">
                                                <table class="w-full text-sm">

                                                    <thead>
                                                        <tr class="border-b border-slate-200 text-xs text-slate-500">
                                                            <th class="py-3 text-left">Nama Sparepart</th>
                                                            <th class="py-3 text-center">Jumlah</th>
                                                            <th class="py-3 text-right">Harga Satuan</th>
                                                            <th class="py-3 text-right">Subtotal</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr
                                                            v-for="(product, index) in item.products"
                                                            :key="index"
                                                            class="border-b border-slate-100"
                                                        >
                                                            <td class="py-3 text-slate-700">
                                                                {{ product.nama }}
                                                            </td>

                                                            <td class="py-3 text-center">
                                                                {{ product.jumlah }}
                                                            </td>

                                                            <td class="py-3 text-right">
                                                                {{ formatRupiah(product.harga) }}
                                                            </td>

                                                            <td class="py-3 text-right font-medium">
                                                                {{ formatRupiah(product.harga * product.jumlah) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </td>
                                    </tr>

                                </template>

                                <!-- Data Kosong -->
                                <tr v-if="paginatedOrders.length === 0">
                                    <td colspan="9" class="px-4 py-12 text-center">
                                        <p class="text-sm font-medium text-slate-600">
                                            Data pesanan tidak ditemukan
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Coba gunakan kata kunci atau filter lainnya.
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
                                @change="currentPage = 1"
                                class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 outline-none focus:border-emerald-400"
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
                                {{ filteredOrders.length ? (currentPage - 1) * perPage + 1 : 0 }}
                                -
                                {{ Math.min(currentPage * perPage, filteredOrders.length) }}
                                dari {{ filteredOrders.length }} data
                            </span>
                        </div>

                        <div class="flex items-center gap-2">

                            <button
                                @click="changePage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="rounded-lg border border-slate-200 px-3 py-1.5 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                            >
                                ‹
                            </button>

                            <button
                                v-for="page in totalPages"
                                :key="page"
                                @click="changePage(page)"
                                :class="[
                                    'rounded-lg px-3.5 py-1.5 font-medium',
                                    currentPage === page
                                        ? 'bg-emerald-600 text-white'
                                        : 'border border-slate-200 text-slate-600 hover:bg-slate-50'
                                ]"
                            >
                                {{ page }}
                            </button>

                            <button
                                @click="changePage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="rounded-lg border border-slate-200 px-3 py-1.5 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                            >
                                ›
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div
            v-if="selectedOrder"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
            @click.self="closeDetail"
        >
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">

                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-800">
                        Detail Pesanan Supplier
                    </h2>

                    <button
                        @click="closeDetail"
                        class="text-2xl text-slate-400 hover:text-slate-700"
                    >
                        &times;
                    </button>
                </div>

                <div class="space-y-4 text-sm">

                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Nomor Pesanan</span>
                        <span class="font-medium text-slate-800">
                            {{ selectedOrder.nomor }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Tanggal Pesan</span>
                        <span class="font-medium text-slate-800">
                            {{ selectedOrder.tanggal }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Supplier</span>
                        <span class="font-medium text-slate-800">
                            {{ selectedOrder.supplier }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Jumlah Sparepart</span>
                        <span class="font-medium text-slate-800">
                            {{ selectedOrder.jenis }} jenis
                        </span>
                    </div>

                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Sudah Datang</span>
                        <span class="font-medium text-slate-800">
                            {{ selectedOrder.sudahDatang }} dari {{ selectedOrder.jumlahPesanan }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Keadaan</span>
                        <span class="font-medium text-slate-800">
                            {{ selectedOrder.status }}
                        </span>
                    </div>

                    <div class="border-t border-slate-100 pt-4">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Total Perkiraan</span>

                            <span class="font-bold text-emerald-600">
                                {{ formatRupiah(selectedOrder.total) }}
                            </span>
                        </div>
                    </div>

                </div>

                <button
                    @click="closeDetail"
                    class="mt-6 w-full rounded-lg bg-emerald-600 py-2.5 text-sm font-medium text-white transition hover:bg-emerald-700"
                >
                    Tutup
                </button>

            </div>
        </div>

    </div>
</template>

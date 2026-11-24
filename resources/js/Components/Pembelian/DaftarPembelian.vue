
<script setup>
import { ref, computed } from 'vue';

const search = ref('');
const activeFilter = ref('Semua');
const expandedId = ref(null);
const emit = defineEmits(['change-tab']);

const filters = [
    'Semua',
    'Belum menambah stok',
    'Stok sudah bertambah',
];

const tabs = [
    'Daftar Pembelian',
    'Pesanan ke Supplier',
    'Terima Barang',
    'Riwayat Harga Beli',
    'Laporan',
];

// Data sementara
const pembelian = ref([
    {
        id: 5,
        nomor: 'PB-000005',
        nota: '1212',
        tanggal: '19 Oktober 2026',
        supplier: 'Toko Astraboy',
        jenis: 1,
        total: 1000000,
        status: 'Stok sudah bertambah',
        sisaUtang: 0,
    },
    {
        id: 1,
        nomor: 'PB-000001',
        nota: '-',
        tanggal: '13 Oktober 2026',
        supplier: 'Toko Astraboy',
        jenis: 1,
        total: 1000000,
        status: 'Stok sudah bertambah',
        sisaUtang: 0,
    },
    {
        id: 4,
        nomor: 'PB-000004',
        nota: '1122',
        tanggal: '13 Oktober 2026',
        supplier: 'Toko Astraboy',
        jenis: 1,
        total: 300000,
        status: 'Stok sudah bertambah',
        sisaUtang: 300000,
    },
    {
        id: 3,
        nomor: 'PB-000003',
        nota: '1212',
        tanggal: '13 Oktober 2026',
        supplier: 'Toko Astraboy',
        jenis: 1,
        total: 750000,
        status: 'Stok sudah bertambah',
        sisaUtang: 750000,
    },
    {
        id: 2,
        nomor: 'PB-000002',
        nota: '-',
        tanggal: '13 Oktober 2026',
        supplier: 'Toko Astraboy',
        jenis: 1,
        total: 100000,
        status: 'Stok sudah bertambah',
        sisaUtang: 0,
    },
]);

const formatRupiah = (angka) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka);
};

const totalPembelian = computed(() =>
    pembelian.value.reduce((total, item) => total + item.total, 0)
);

const totalUtang = computed(() =>
    pembelian.value.reduce((total, item) => total + item.sisaUtang, 0)
);

const belumMenambahStok = computed(() =>
    pembelian.value.filter(
        item => item.status === 'Belum menambah stok'
    ).length
);

const filteredPembelian = computed(() => {
    return pembelian.value.filter(item => {
        const keyword = search.value.toLowerCase();

        const cocokSearch =
            item.nomor.toLowerCase().includes(keyword) ||
            item.nota.toLowerCase().includes(keyword) ||
            item.supplier.toLowerCase().includes(keyword);

        const cocokFilter =
            activeFilter.value === 'Semua' ||
            item.status === activeFilter.value;

        return cocokSearch && cocokFilter;
    });
});

const toggleDetail = (id) => {
    expandedId.value = expandedId.value === id ? null : id;
};
</script>

<template>
    <div class="min-h-screen bg-slate-50/70">

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-end gap-3 px-6 py-4">

            <button
                class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v12m0 0l-4-4m4 4l4-4M5 17v3h14v-3" />
                </svg>
                Dokumen
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </button>

            <button
                class="flex items-center gap-2 rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
            >
                <span class="text-lg leading-none">+</span>
                Tambah Pembelian
                <span class="text-xs text-emerald-200">Alt+N</span>
            </button>
        </div>

        <!-- Ringkasan -->
        <div class="flex flex-wrap gap-2 px-6 pb-4">

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="font-bold text-slate-900">
                    {{ pembelian.length }}
                </span>
                <span class="text-sm text-slate-500">pembelian</span>
                <span class="text-slate-400">›</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                <span class="font-bold text-slate-900">
                    {{ belumMenambahStok }}
                </span>
                <span class="text-sm text-slate-500">belum menambah stok</span>
                <span class="text-slate-400">›</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="font-bold text-slate-900">
                    {{ formatRupiah(totalPembelian) }}
                </span>
                <span class="text-sm text-slate-500">
                    nilai pembelian tercatat
                </span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="font-bold text-red-600">
                    {{ formatRupiah(totalUtang) }}
                </span>
                <span class="text-sm text-slate-500">
                    utang supplier · belum dibayar
                </span>
                <span class="text-slate-400">ⓘ</span>
            </div>
        </div>

        <!-- Tab Pembelian -->
<div class="border-b border-slate-200 bg-white px-6">
    <div class="flex h-[53px] items-stretch gap-1 overflow-x-auto">
        <button
            v-for="(tab, index) in tabs"
            :key="tab"
            @click="
    index === 1
        ? emit('change-tab', 'pesanan')
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
                index === 0
                    ? 'border-emerald-600 text-emerald-600'
                    : 'border-transparent text-slate-500 hover:border-emerald-300 hover:text-emerald-600'
            ]"
        >
            {{ tab }}
        </button>
    </div>
</div>

        <!-- Daftar Pembelian -->
        <div class="p-4 sm:p-6">
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="p-5">

                    <!-- Search -->
                    <div class="mb-4">
                        <div class="relative max-w-md">
                            <svg
                                class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                                fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8"
                            >
                                <circle cx="11" cy="11" r="7" />
                                <path d="m16 16 4 4" />
                            </svg>

                            <input
                                v-model="search"
                                type="text"
                                placeholder="Cari nomor, nota supplier, atau nama supplier"
                                class="w-full rounded-lg border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 sm:w-[400px]"
                            />
                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="mb-6 flex flex-wrap items-center gap-2">
                        <button
                            v-for="filter in filters"
                            :key="filter"
                            @click="activeFilter = filter"
                            :class="[
                                'rounded-full border px-4 py-1.5 text-sm transition',
                                activeFilter === filter
                                    ? 'border-emerald-500 bg-emerald-50 text-emerald-600'
                                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
                            ]"
                        >
                            {{ filter }}
                            <span class="ml-1">
                                {{
                                    filter === 'Semua'
                                        ? pembelian.length
                                        : pembelian.filter(item =>
                                            item.status === filter
                                        ).length
                                }}
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
                                    <th class="px-3 py-4">Tanggal</th>
                                    <th class="px-3 py-4">Supplier</th>
                                    <th class="px-3 py-4 text-center">Jenis Sparepart</th>
                                    <th class="px-3 py-4 text-right">Total</th>
                                    <th class="px-3 py-4">Keadaan</th>
                                    <th class="px-3 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <template
                                    v-for="item in filteredPembelian"
                                    :key="item.id"
                                >
                                    <tr class="border-b border-slate-100 transition hover:bg-slate-50/70">

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
                                                    fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2"
                                                >
                                                    <path d="m9 18 6-6-6-6" />
                                                </svg>
                                            </button>
                                        </td>

                                        <td class="px-3 py-5">
                                            <p class="font-medium text-emerald-600">
                                                {{ item.nomor }}
                                            </p>
                                            <p class="mt-0.5 text-xs text-slate-500">
                                                Nota supplier: {{ item.nota }}
                                            </p>
                                        </td>

                                        <td class="px-3 py-5 text-sm text-slate-700">
                                            {{ item.tanggal }}
                                        </td>

                                        <td class="px-3 py-5 text-sm text-slate-700">
                                            {{ item.supplier }}
                                        </td>

                                        <td class="px-3 py-5 text-center text-sm text-slate-700">
                                            {{ item.jenis }} jenis
                                        </td>

                                        <td class="px-3 py-5 text-right text-sm font-semibold text-slate-800">
                                            {{ formatRupiah(item.total) }}
                                        </td>

                                        <td class="px-3 py-5">
                                            <div class="flex items-start gap-2">
                                                <span
                                                    :class="[
                                                        'mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full',
                                                        item.status === 'Stok sudah bertambah'
                                                            ? 'bg-emerald-500'
                                                            : 'bg-amber-400'
                                                    ]"
                                                ></span>

                                                <div>
                                                    <p class="text-sm text-slate-700">
                                                        {{ item.status }}
                                                    </p>

                                                    <p
                                                        v-if="item.sisaUtang > 0"
                                                        class="mt-1 text-xs text-slate-500"
                                                    >
                                                        Sisa utang {{ formatRupiah(item.sisaUtang) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-3 py-5 text-center">
                                            <button
                                                @click="toggleDetail(item.id)"
                                                title="Lihat detail"
                                                class="rounded-lg border border-slate-200 p-2 text-slate-500 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-600"
                                            >
                                                <svg class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="1.8"
                                                >
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Detail -->
                                    <tr
                                        v-if="expandedId === item.id"
                                        class="border-b border-slate-100 bg-slate-50"
                                    >
                                        <td colspan="8" class="px-8 py-5">
                                            <div class="grid gap-4 sm:grid-cols-3">
                                                <div>
                                                    <p class="text-xs text-slate-400">
                                                        Nomor pembelian
                                                    </p>
                                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                                        {{ item.nomor }}
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-slate-400">
                                                        Supplier
                                                    </p>
                                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                                        {{ item.supplier }}
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-slate-400">
                                                        Total pembelian
                                                    </p>
                                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                                        {{ formatRupiah(item.total) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </template>

                                <tr v-if="filteredPembelian.length === 0">
                                    <td colspan="8" class="px-4 py-12 text-center">
                                        <p class="text-sm font-medium text-slate-600">
                                            Data pembelian tidak ditemukan
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            Coba gunakan kata kunci atau filter lainnya.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 text-sm text-slate-500">
                        <div>
                            Menampilkan {{ filteredPembelian.length }} dari {{ pembelian.length }} data
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-xs">20 per halaman</span>

                            <button disabled
                                class="rounded-lg border border-slate-200 px-3 py-1.5 text-slate-300">
                                ‹
                            </button>

                            <button class="rounded-lg bg-emerald-600 px-3.5 py-1.5 font-medium text-white">
                                1
                            </button>

                            <button disabled
                                class="rounded-lg border border-slate-200 px-3 py-1.5 text-slate-300">
                                ›
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

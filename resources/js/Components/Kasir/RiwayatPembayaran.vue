
<script setup>
import { ref, computed } from 'vue'
import {
    Search,
    ChevronDown,
    ChevronRight,
    ChevronLeft,
    MessageCircle,
    FileText,
    Download,
    Info,
} from 'lucide-vue-next'

const search = ref('')
const activeFilter = ref('Semua')
const currentPage = ref(1)
const perPage = ref(20)
const expandedRow = ref(null)

const payments = ref([
    { code: 'BYR-000483', date: '16 November 2026', customer: 'Pelanggan Umum', method: 'QRIS', amount: 985000, status: 'Selesai', note: 'KSR-000200' },
    { code: 'BYR-000482', date: '16 November 2026', customer: 'Pelanggan Umum', method: 'QRIS', amount: 985000, status: 'Selesai', note: 'KSR-000199' },
    { code: 'BYR-000481', date: '12 November 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 138750, status: 'Selesai', note: 'KSR-000198' },
    { code: 'BYR-000479', date: '10 November 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 125000, status: 'Selesai', note: 'KSR-000197' },
    { code: 'BYR-000480', date: '10 November 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 125000, status: 'Selesai', note: 'KSR-000196' },
    { code: 'BYR-000476', date: '04 November 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 125000, status: 'Selesai', note: 'KSR-000194' },
    { code: 'BYR-000475', date: '04 November 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 125000, status: 'Selesai', note: 'KSR-000193' },
    { code: 'BYR-000478', date: '04 November 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 125000, status: 'Selesai', note: 'KSR-000192' },
    { code: 'BYR-000477', date: '04 November 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 125000, status: 'Selesai', note: 'KSR-000191' },
    { code: 'BYR-000474', date: '04 November 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 985000, status: 'Selesai', note: 'KSR-000190' },
    { code: 'BYR-000473', date: '02 November 2026', customer: 'Agen Oli Makmur Sentosa', method: 'Tunai', amount: 6000000, status: 'Selesai', note: 'KSR-000189' },
    { code: 'BYR-000472', date: '02 November 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 1110000, status: 'Selesai', note: 'KSR-000188' },
    { code: 'BYR-000471', date: '30 Oktober 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 12500000, status: 'Selesai', note: 'KSR-000186' },
    { code: 'BYR-000470', date: '30 Oktober 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 5910000, status: 'Selesai', note: 'KSR-000185' },
    { code: 'BYR-000469', date: '30 Oktober 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 1580000, status: 'Selesai', note: 'KSR-000184' },
    { code: 'BYR-000468', date: '28 Oktober 2026', customer: 'Bagus Wicaksono', method: 'Tunai', amount: 532000, status: 'Selesai', note: 'KSR-000183' },
    { code: 'BYR-000467', date: '23 Oktober 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 95000, status: 'Selesai', note: 'KSR-000183' },
    { code: 'BYR-000465', date: '23 Oktober 2026', customer: 'Pelanggan Umum', method: 'Tunai', amount: 240000, status: 'Selesai', note: 'KSR-000182' },
    { code: 'BYR-000466', date: '23 Oktober 2026', customer: 'Ratna Juwita', method: 'Tunai', amount: 898000, status: 'Selesai', note: 'KSR-000181' },
    { code: 'BYR-000464', date: '21 Oktober 2026', customer: 'Arif Budiman', method: 'Tunai', amount: 1410000, status: 'Selesai', note: 'KSR-000180' },
])

const filters = [
    { name: 'Semua', count: 483 },
    { name: 'Selesai', count: 483 },
    { name: 'Dibatalkan', count: 0 },
]

const filteredPayments = computed(() => {
    return payments.value.filter(payment => {
        const keyword = search.value.toLowerCase()

        const matchesSearch =
            payment.code.toLowerCase().includes(keyword) ||
            payment.customer.toLowerCase().includes(keyword) ||
            payment.note.toLowerCase().includes(keyword) ||
            payment.method.toLowerCase().includes(keyword)

        const matchesFilter =
            activeFilter.value === 'Semua' ||
            (activeFilter.value === 'Selesai' && payment.status === 'Selesai') ||
            (activeFilter.value === 'Dibatalkan' && payment.status === 'Dibatalkan')

        return matchesSearch && matchesFilter
    })
})

const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredPayments.value.length / perPage.value))
)

const paginatedPayments = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    return filteredPayments.value.slice(start, start + perPage.value)
})

const formatRupiah = (value) => {
    return 'Rp ' + Math.round(value).toLocaleString('id-ID')
}

const changeFilter = (filter) => {
    activeFilter.value = filter
    currentPage.value = 1
    expandedRow.value = null
}

const exportExcel = () => {
    const headers = [
        'Nomor Pembayaran',
        'Tanggal',
        'Pelanggan',
        'Metode',
        'Jumlah',
        'Status',
        'Nomor Nota',
    ]

    const rows = filteredPayments.value.map(payment => [
        payment.code,
        payment.date,
        payment.customer,
        payment.method,
        payment.amount,
        payment.status,
        payment.note,
    ])

    const csv = [headers, ...rows]
        .map(row =>
            row.map(value =>
                `"${String(value).replaceAll('"', '""')}"`
            ).join(';')
        )
        .join('\n')

    const blob = new Blob(['\uFEFF' + csv], {
        type: 'text/csv;charset=utf-8;',
    })

    const url = URL.createObjectURL(blob)
    const link = document.createElement('a')

    link.href = url
    link.download = 'riwayat-pembayaran.csv'
    link.click()

    URL.revokeObjectURL(url)
}

const exportPdf = () => {
    window.print()
}
</script>

<template>
    <div class="riwayat-page space-y-6">

        <!-- TOMBOL EXPORT -->
        <div class="flex flex-wrap justify-end gap-3 print:hidden">
            <button
                @click="exportPdf"
                class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-700"
            >
                <FileText class="h-5 w-5" />
                Cetak PDF
            </button>

            <button
                @click="exportExcel"
                class="flex items-center gap-2 rounded-xl bg-emerald-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-900"
            >
                <Download class="h-5 w-5" />
                Download Excel
            </button>
        </div>

        <!-- RINGKASAN -->
        <section class="grid grid-cols-1 gap-3 sm:grid-cols-3">

            <div class="rounded-2xl border border-[#e8eee8] bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">
                    Total uang masuk
                </p>

                <p class="mt-2 text-xl font-bold text-[#293c32]">
                    Rp 834.284.750
                </p>

                <p class="mt-1 text-sm text-slate-400">
                    Dari pembayaran sah
                </p>
            </div>

            <div class="rounded-2xl border border-[#e8eee8] bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">
                    Total pembayaran
                </p>

                <p class="mt-2 text-xl font-bold text-emerald-700">
                    483
                </p>

                <p class="mt-1 text-sm text-slate-400">
                    Pembayaran berhasil
                </p>
            </div>

            <div class="rounded-2xl border border-[#e8eee8] bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">
                    Pembayaran dibatalkan
                </p>

                <p class="mt-2 text-xl font-bold text-slate-700">
                    0
                </p>

                <p class="mt-1 text-sm text-slate-400">
                    Tidak ada pembatalan
                </p>
            </div>
        </section>

        <!-- INFORMASI -->
        <p class="flex items-start gap-2 text-sm leading-relaxed text-slate-500">
            <Info class="mt-0.5 h-5 w-5 shrink-0 text-emerald-700" />
            <span>
                Riwayat ini menampilkan pembayaran yang masuk dari transaksi kasir.
                Klik nomor pembayaran untuk melihat detailnya.
            </span>
        </p>

        <!-- TABEL PEMBAYARAN -->
        <section class="overflow-hidden rounded-2xl border border-[#e8eee8] bg-white p-5 shadow-sm">

            <!-- HEADER -->
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-[#293c32]">
                        Riwayat Pembayaran
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Daftar seluruh pembayaran yang telah dilakukan.
                    </p>
                </div>

                <span class="rounded-full bg-[#edf4ec] px-3 py-1.5 text-sm font-semibold text-emerald-800">
                    {{ filteredPayments.length }} pembayaran
                </span>
            </div>

            <!-- SEARCH -->
            <div class="mb-5 flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 sm:max-w-md">
                <Search class="h-5 w-5 shrink-0 text-slate-400" />

                <input
                    v-model="search"
                    @input="currentPage = 1"
                    type="text"
                    placeholder="Cari nomor pembayaran, nota, atau pelanggan..."
                    class="w-full border-0 bg-transparent text-base outline-none placeholder:text-slate-400 focus:ring-0"
                />
            </div>

            <!-- FILTER -->
            <div class="mb-5 flex flex-wrap items-center gap-2">
                <button
                    v-for="filter in filters"
                    :key="filter.name"
                    @click="changeFilter(filter.name)"
                    :class="[
                        'rounded-full border px-4 py-2 text-sm font-medium transition',
                        activeFilter === filter.name
                            ? 'border-emerald-700 bg-emerald-800 text-white'
                            : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-300 hover:bg-emerald-50'
                    ]"
                >
                    {{ filter.name }}

                    <span
                        class="ml-1"
                        :class="activeFilter === filter.name ? 'text-emerald-100' : 'text-slate-400'"
                    >
                        {{ filter.count }}
                    </span>
                </button>
            </div>

            <!-- DAFTAR PEMBAYARAN -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1050px] text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-[#f8faf8] text-sm text-slate-500">
                            <th class="w-12 px-3 py-4"></th>
                            <th class="px-4 py-4 font-semibold">Nomor Pembayaran</th>
                            <th class="px-4 py-4 font-semibold">Tanggal</th>
                            <th class="px-4 py-4 font-semibold">Pelanggan / Supplier</th>
                            <th class="px-4 py-4 font-semibold">Metode</th>
                            <th class="px-4 py-4 text-right font-semibold">Jumlah</th>
                            <th class="px-4 py-4 font-semibold">Status</th>
                            <th class="px-4 py-4 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template
                            v-for="payment in paginatedPayments"
                            :key="payment.code"
                        >
                            <tr class="border-b border-slate-100 transition hover:bg-[#f8faf8]">

                                <!-- EXPAND -->
                                <td class="px-3 py-5">
                                    <button
                                        @click="expandedRow = expandedRow === payment.code ? null : payment.code"
                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-emerald-50 hover:text-emerald-700"
                                    >
                                        <ChevronDown
                                            v-if="expandedRow === payment.code"
                                            class="h-5 w-5"
                                        />

                                        <ChevronRight
                                            v-else
                                            class="h-5 w-5"
                                        />
                                    </button>
                                </td>

                                <td class="whitespace-nowrap px-4 py-5 font-semibold text-emerald-800">
                                    {{ payment.code }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-5 text-slate-600">
                                    {{ payment.date }}
                                </td>

                                <td class="px-4 py-5 text-slate-600">
                                    {{ payment.customer }}
                                </td>

                                <td class="px-4 py-5">
                                    <span class="inline-flex rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-600">
                                        {{ payment.method }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-4 py-5 text-right font-semibold text-slate-700">
                                    {{ formatRupiah(payment.amount) }}
                                </td>

                                <td class="px-4 py-5">
                                    <span
                                        :class="[
                                            'inline-flex items-center gap-2 whitespace-nowrap rounded-full px-3 py-1.5 text-sm font-medium',
                                            payment.status === 'Selesai'
                                                ? 'bg-emerald-50 text-emerald-700'
                                                : 'bg-red-50 text-red-700'
                                        ]"
                                    >
                                        <span
                                            :class="[
                                                'h-2 w-2 rounded-full',
                                                payment.status === 'Selesai' ? 'bg-emerald-500' : 'bg-red-500'
                                            ]"
                                        ></span>

                                        {{ payment.status }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-4 py-5 text-right">
                                    <button
                                        @click="expandedRow = expandedRow === payment.code ? null : payment.code"
                                        class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700"
                                    >
                                        <FileText class="h-4 w-4" />
                                        Detail
                                    </button>
                                </td>
                            </tr>

                            <!-- DETAIL PEMBAYARAN -->
                            <tr
                                v-if="expandedRow === payment.code"
                                class="border-b border-slate-100 bg-[#f8faf8]"
                            >
                                <td colspan="8" class="px-8 py-5 sm:px-14">
                                    <div class="grid gap-5 sm:grid-cols-3">

                                        <div>
                                            <p class="text-sm text-slate-400">
                                                Nomor pembayaran
                                            </p>

                                            <p class="mt-1 text-base font-semibold text-slate-700">
                                                {{ payment.code }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-400">
                                                Nomor nota terkait
                                            </p>

                                            <p class="mt-1 text-base font-semibold text-emerald-700">
                                                {{ payment.note }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-400">
                                                Jumlah pembayaran
                                            </p>

                                            <p class="mt-1 text-base font-semibold text-slate-700">
                                                {{ formatRupiah(payment.amount) }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-400">
                                                Pelanggan
                                            </p>

                                            <p class="mt-1 text-base font-semibold text-slate-700">
                                                {{ payment.customer }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-400">
                                                Metode pembayaran
                                            </p>

                                            <p class="mt-1 text-base font-semibold text-slate-700">
                                                {{ payment.method }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-400">
                                                Tanggal pembayaran
                                            </p>

                                            <p class="mt-1 text-base font-semibold text-slate-700">
                                                {{ payment.date }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <tr v-if="paginatedPayments.length === 0">
                            <td colspan="8" class="py-14 text-center">
                                <FileText class="mx-auto mb-3 h-10 w-10 text-slate-300" />

                                <p class="text-base font-semibold text-slate-500">
                                    Riwayat pembayaran tidak ditemukan
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Coba gunakan kata kunci pencarian lain.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="mt-5 flex flex-wrap items-center justify-between gap-4 border-t border-slate-100 pt-5">

                <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
                    <span>Tampilkan</span>

                    <select
                        v-model.number="perPage"
                        @change="currentPage = 1"
                        class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-emerald-500"
                    >
                        <option :value="10">10</option>
                        <option :value="20">20</option>
                        <option :value="50">50</option>
                    </select>

                    <span>per halaman · Menampilkan</span>

                    <span class="font-semibold text-slate-700">
                        {{ filteredPayments.length ? (currentPage - 1) * perPage + 1 : 0 }}–{{ Math.min(currentPage * perPage, filteredPayments.length) }}
                    </span>

                    <span>dari {{ filteredPayments.length }} data</span>
                </div>

                <div class="flex items-center gap-2">
                    <button
                        @click="currentPage = Math.max(1, currentPage - 1)"
                        :disabled="currentPage === 1"
                        class="rounded-lg border border-slate-200 p-2.5 text-slate-600 transition hover:bg-emerald-50 disabled:cursor-not-allowed disabled:opacity-40"
                    >
                        <ChevronLeft class="h-5 w-5" />
                    </button>

                    <span class="rounded-lg bg-emerald-800 px-4 py-2.5 text-sm font-semibold text-white">
                        {{ currentPage }}
                    </span>

                    <span class="text-sm text-slate-500">
                        dari {{ totalPages }}
                    </span>

                    <button
                        @click="currentPage = Math.min(totalPages, currentPage + 1)"
                        :disabled="currentPage === totalPages"
                        class="rounded-lg border border-slate-200 p-2.5 text-slate-600 transition hover:bg-emerald-50 disabled:cursor-not-allowed disabled:opacity-40"
                    >
                        <ChevronRight class="h-5 w-5" />
                    </button>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.riwayat-page {
    font-size: 16px;
}

.riwayat-page input,
.riwayat-page select,
.riwayat-page button {
    font-family: inherit;
}

@media print {
    .riwayat-page {
        font-size: 12px;
    }

    .riwayat-page button,
    .riwayat-page input,
    .riwayat-page select {
        display: none;
    }

    .riwayat-page section {
        box-shadow: none;
    }
}
</style>


<script setup>
import { ref, computed } from 'vue'
import {
    Search,
    Info,
    ChevronLeft,
    ChevronRight,
    FileText,
} from 'lucide-vue-next'

const search = ref('')
const activeFilter = ref('Semua')
const currentPage = ref(1)
const perPage = ref(20)

const notes = ref([
    { code: 'KSR-000200', date: '16 November 2026', customer: 'Umum', items: 1, total: 985000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000199', date: '16 November 2026', customer: 'Umum', items: 1, total: 985000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000198', date: '12 November 2026', customer: 'Umum', items: 1, total: 138750, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000197', date: '10 November 2026', customer: 'Umum', items: 1, total: 125000, unpaid: 0, status: 'Belum selesai' },
    { code: 'KSR-000196', date: '10 November 2026', customer: 'Umum', items: 1, total: 125000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000195', date: '10 November 2026', customer: 'Umum', items: 1, total: 125000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000194', date: '04 November 2026', customer: 'Umum', items: 1, total: 125000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000193', date: '04 November 2026', customer: 'Umum', items: 1, total: 125000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000192', date: '04 November 2026', customer: 'Umum', items: 1, total: 125000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000191', date: '04 November 2026', customer: 'Umum', items: 1, total: 125000, unpaid: 0, status: 'Belum selesai' },
    { code: 'KSR-000190', date: '04 November 2026', customer: 'Umum', items: 1, total: 125000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000189', date: '04 November 2026', customer: 'Umum', items: 1, total: 985000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000188', date: '02 November 2026', customer: 'Umum', items: 2, total: 1110000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000187', date: '02 November 2026', customer: 'Umum', items: 1, total: 985000, unpaid: 0, status: 'Belum selesai' },
    { code: 'KSR-000186', date: '30 Oktober 2026', customer: 'Umum', items: 1, total: 12500000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000185', date: '30 Oktober 2026', customer: 'Umum', items: 1, total: 5910000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000184', date: '30 Oktober 2026', customer: 'Umum', items: 1, total: 1580000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000183', date: '23 Oktober 2026', customer: 'Umum', items: 1, total: 95000, unpaid: 0, status: 'Lunas' },
    { code: 'KSR-000182', date: '23 Oktober 2026', customer: 'Umum', items: 2, total: 220000, unpaid: 0, status: 'Belum selesai' },
    { code: 'KSR-000181', date: '23 Oktober 2026', customer: 'Umum', items: 2, total: 220000, unpaid: 0, status: 'Belum selesai' },
])

const filters = [
    { name: 'Semua', count: 200 },
    { name: 'Belum selesai', count: 6 },
    { name: 'Belum dibayar', count: 0 },
    { name: 'Lunas', count: 194 },
    { name: 'Dibatalkan', count: 0 },
]

const filteredNotes = computed(() => {
    return notes.value.filter(note => {
        const keyword = search.value.toLowerCase()

        const matchesSearch =
            note.code.toLowerCase().includes(keyword) ||
            note.customer.toLowerCase().includes(keyword)

        const matchesFilter =
            activeFilter.value === 'Semua' ||
            (activeFilter.value === 'Lunas' && note.status === 'Lunas') ||
            (activeFilter.value === 'Belum selesai' && note.status === 'Belum selesai') ||
            (activeFilter.value === 'Belum dibayar' && note.unpaid > 0)

        return matchesSearch && matchesFilter
    })
})

const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredNotes.value.length / perPage.value))
)

const paginatedNotes = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    return filteredNotes.value.slice(start, start + perPage.value)
})

const formatRupiah = (value) => {
    return 'Rp ' + Math.round(value).toLocaleString('id-ID')
}

const changeFilter = (filter) => {
    activeFilter.value = filter
    currentPage.value = 1
}

const changeSearch = () => {
    currentPage.value = 1
}
</script>

<template>
    <div class="nota-page space-y-6">

        <!-- RINGKASAN -->
        <section class="flex flex-wrap items-center gap-3">
            <div class="rounded-xl border border-[#e8eee8] bg-white px-4 py-3 shadow-sm">
                <p class="text-sm text-slate-500">Total nota</p>
                <p class="mt-1 text-xl font-bold text-slate-800">200</p>
            </div>

            <div class="rounded-xl border border-[#e8eee8] bg-white px-4 py-3 shadow-sm">
                <p class="text-sm text-slate-500">Belum selesai</p>
                <p class="mt-1 text-xl font-bold text-amber-600">6</p>
            </div>

            <div class="rounded-xl border border-[#e8eee8] bg-white px-4 py-3 shadow-sm">
                <p class="text-sm text-slate-500">Belum dibayar</p>
                <p class="mt-1 text-xl font-bold text-slate-800">0</p>
            </div>
        </section>

        <p class="flex items-start gap-2 text-sm leading-relaxed text-slate-500">
            <Info class="mt-0.5 h-5 w-5 shrink-0 text-emerald-700" />
            <span>
                Nota yang belum dibayar juga tercatat sebagai tagihan pelanggan:
                <span class="font-semibold text-emerald-700">
                    Pelanggan › Tagihan › Nota Belum Lunas.
                </span>
            </span>
        </p>

        <!-- TABEL NOTA -->
        <section class="overflow-hidden rounded-2xl border border-[#e8eee8] bg-white p-5 shadow-sm">

            <!-- HEADER TABEL -->
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-[#293c32]">
                        Daftar Nota Kasir
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat dan cari seluruh transaksi kasir.
                    </p>
                </div>

                <span class="rounded-full bg-[#edf4ec] px-3 py-1.5 text-sm font-semibold text-emerald-800">
                    {{ filteredNotes.length }} nota
                </span>
            </div>

            <!-- PENCARIAN -->
            <div class="mb-5 flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 sm:max-w-md">
                <Search class="h-5 w-5 shrink-0 text-slate-400" />

                <input
                    v-model="search"
                    @input="changeSearch"
                    type="text"
                    placeholder="Cari nomor nota atau pelanggan..."
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

            <!-- DATA NOTA -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1000px] text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-[#f8faf8] text-sm text-slate-500">
                            <th class="px-4 py-4 font-semibold">Nomor Nota</th>
                            <th class="px-4 py-4 font-semibold">Tanggal</th>
                            <th class="px-4 py-4 font-semibold">Pelanggan</th>
                            <th class="px-4 py-4 font-semibold">Jenis Barang</th>
                            <th class="px-4 py-4 text-right font-semibold">Total</th>
                            <th class="px-4 py-4 text-right font-semibold">Belum Dibayar</th>
                            <th class="px-4 py-4 font-semibold">Status</th>
                            <th class="px-4 py-4 text-right font-semibold">Nota</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="note in paginatedNotes"
                            :key="note.code"
                            class="border-b border-slate-100 transition hover:bg-[#f8faf8]"
                        >
                            <td class="whitespace-nowrap px-4 py-5 font-semibold text-emerald-800">
                                {{ note.code }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-5 text-slate-600">
                                {{ note.date }}
                            </td>

                            <td class="px-4 py-5 text-slate-600">
                                {{ note.customer }}
                            </td>

                            <td class="px-4 py-5 text-slate-600">
                                {{ note.items }} barang
                            </td>

                            <td class="whitespace-nowrap px-4 py-5 text-right font-semibold text-slate-700">
                                {{ formatRupiah(note.total) }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-5 text-right text-slate-600">
                                {{ formatRupiah(note.unpaid) }}
                            </td>

                            <td class="px-4 py-5">
                                <span
                                    :class="[
                                        'inline-flex items-center gap-2 whitespace-nowrap rounded-full px-3 py-1.5 text-sm font-medium',
                                        note.status === 'Lunas'
                                            ? 'bg-emerald-50 text-emerald-700'
                                            : 'bg-amber-50 text-amber-700'
                                    ]"
                                >
                                    <span
                                        :class="[
                                            'h-2 w-2 rounded-full',
                                            note.status === 'Lunas' ? 'bg-emerald-500' : 'bg-amber-500'
                                        ]"
                                    ></span>
                                    {{ note.status }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-4 py-5 text-right">
                                <button class="inline-flex items-center gap-2 font-semibold text-emerald-700 transition hover:text-emerald-900">
                                    <FileText class="h-4 w-4" />
                                    Lihat nota
                                </button>
                            </td>
                        </tr>

                        <tr v-if="paginatedNotes.length === 0">
                            <td colspan="8" class="py-14 text-center">
                                <FileText class="mx-auto mb-3 h-10 w-10 text-slate-300" />

                                <p class="text-base font-semibold text-slate-500">
                                    Nota tidak ditemukan
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Coba gunakan kata kunci atau filter lainnya.
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
                        {{ filteredNotes.length ? (currentPage - 1) * perPage + 1 : 0 }}–{{ Math.min(currentPage * perPage, filteredNotes.length) }}
                    </span>

                    <span>dari {{ filteredNotes.length }} data</span>
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
.nota-page {
    font-size: 16px;
}

.nota-page input,
.nota-page select,
.nota-page button {
    font-family: inherit;
}
</style>

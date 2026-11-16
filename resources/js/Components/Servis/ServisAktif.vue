
<script setup>
import { ref, computed } from 'vue'
import {
    Search,
    Plus,
    Wrench,
    Clock3,
    CheckCircle2,
    CarFront,
    ChevronLeft,
    ChevronRight,
    Eye,
    MoreHorizontal,
    CalendarDays,
    UserRound,
    Phone,
    X,
} from 'lucide-vue-next'
import { Link } from '@inertiajs/vue3'

const search = ref('')
const activeFilter = ref('Semua')
const currentPage = ref(1)
const perPage = 8
const selectedService = ref(null)

const filters = ['Semua', 'Menunggu', 'Dikerjakan', 'Ditunda']

const services = ref([
    {
        id: 1,
        invoice: 'SRV-001',
        customer: 'Andi Pratama',
        phone: '081234567890',
        vehicle: 'Honda Vario 160',
        plate: 'AD 2345 AB',
        mechanic: 'Budi Santoso',
        service: 'Ganti oli, servis CVT',
        date: '16 Nov 2026',
        time: '08:30',
        status: 'Dikerjakan',
        cost: 185000,
    },
    {
        id: 2,
        invoice: 'SRV-002',
        customer: 'Dimas Saputra',
        phone: '081298765432',
        vehicle: 'Yamaha NMAX',
        plate: 'AD 4567 CD',
        mechanic: 'Agus Setiawan',
        service: 'Servis berkala',
        date: '16 Nov 2026',
        time: '09:00',
        status: 'Menunggu',
        cost: 250000,
    },
    {
        id: 3,
        invoice: 'SRV-003',
        customer: 'Rizky Maulana',
        phone: '082123456789',
        vehicle: 'Honda Beat',
        plate: 'AD 7890 EF',
        mechanic: 'Budi Santoso',
        service: 'Ganti kampas rem',
        date: '16 Nov 2026',
        time: '09:15',
        status: 'Dikerjakan',
        cost: 95000,
    },
    {
        id: 4,
        invoice: 'SRV-004',
        customer: 'Fajar Nugroho',
        phone: '085123456789',
        vehicle: 'Yamaha Aerox',
        plate: 'AD 1122 GH',
        mechanic: 'Belum ditentukan',
        service: 'Pemeriksaan mesin',
        date: '16 Nov 2026',
        time: '10:00',
        status: 'Menunggu',
        cost: 150000,
    },
    {
        id: 5,
        invoice: 'SRV-005',
        customer: 'Agus Widodo',
        phone: '087812345678',
        vehicle: 'Honda Scoopy',
        plate: 'AD 3344 IJ',
        mechanic: 'Agus Setiawan',
        service: 'Ganti oli mesin',
        date: '16 Nov 2026',
        time: '10:30',
        status: 'Ditunda',
        cost: 75000,
    },
    {
        id: 6,
        invoice: 'SRV-006',
        customer: 'Rian Firmansyah',
        phone: '081345678901',
        vehicle: 'Honda PCX',
        plate: 'AD 5566 KL',
        mechanic: 'Budi Santoso',
        service: 'Servis CVT',
        date: '16 Nov 2026',
        time: '11:00',
        status: 'Dikerjakan',
        cost: 175000,
    },
    {
        id: 7,
        invoice: 'SRV-007',
        customer: 'Bayu Ramadhan',
        phone: '082234567890',
        vehicle: 'Yamaha Mio',
        plate: 'AD 7788 MN',
        mechanic: 'Belum ditentukan',
        service: 'Perbaikan kelistrikan',
        date: '16 Nov 2026',
        time: '11:30',
        status: 'Menunggu',
        cost: 200000,
    },
    {
        id: 8,
        invoice: 'SRV-008',
        customer: 'Hendra Kurniawan',
        phone: '085678901234',
        vehicle: 'Honda Supra X',
        plate: 'AD 9900 OP',
        mechanic: 'Agus Setiawan',
        service: 'Ganti rantai dan gear',
        date: '16 Nov 2026',
        time: '12:00',
        status: 'Dikerjakan',
        cost: 220000,
    },
])

const filteredServices = computed(() => {
    const keyword = search.value.toLowerCase().trim()

    return services.value.filter((item) => {
        const matchSearch = [
            item.invoice,
            item.customer,
            item.vehicle,
            item.plate,
            item.mechanic,
            item.service,
        ].some(value => value.toLowerCase().includes(keyword))

        const matchFilter =
            activeFilter.value === 'Semua' ||
            item.status === activeFilter.value

        return matchSearch && matchFilter
    })
})

const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredServices.value.length / perPage))
)

const paginatedServices = computed(() => {
    const start = (currentPage.value - 1) * perPage
    return filteredServices.value.slice(start, start + perPage)
})

const summary = computed(() => ({
    total: services.value.length,
    waiting: services.value.filter(item => item.status === 'Menunggu').length,
    working: services.value.filter(item => item.status === 'Dikerjakan').length,
    delayed: services.value.filter(item => item.status === 'Ditunda').length,
}))

const formatRupiah = (value) =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(value)

const setFilter = (filter) => {
    activeFilter.value = filter
    currentPage.value = 1
}

const changeStatus = (item, status) => {
    item.status = status
    selectedService.value = null
}

const statusClass = (status) => {
    const classes = {
        Menunggu: 'bg-amber-50 text-amber-700 border-amber-200',
        Dikerjakan: 'bg-blue-50 text-blue-700 border-blue-200',
        Ditunda: 'bg-rose-50 text-rose-700 border-rose-200',
    }

    return classes[status] || 'bg-slate-50 text-slate-600 border-slate-200'
}
</script>

<template>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-bold text-slate-800">
                    Servis Aktif
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Pantau dan kelola seluruh pekerjaan servis kendaraan.
                </p>
            </div>

           <Link
                href="/servis/tambah"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800"
            >
                <Plus :size="18" />
                Tambah Servis
            </Link>
        </div>

        <!-- Summary -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Servis Aktif</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-800">
                            {{ summary.total }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                        <Wrench :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Seluruh pekerjaan servis</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Menunggu</p>
                        <h2 class="mt-2 text-2xl font-bold text-amber-600">
                            {{ summary.waiting }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-amber-50 p-3 text-amber-600">
                        <Clock3 :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Belum mulai dikerjakan</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Sedang Dikerjakan</p>
                        <h2 class="mt-2 text-2xl font-bold text-blue-600">
                            {{ summary.working }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                        <Wrench :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Dalam proses pengerjaan</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Ditunda</p>
                        <h2 class="mt-2 text-2xl font-bold text-rose-600">
                            {{ summary.delayed }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-rose-50 p-3 text-rose-600">
                        <CalendarDays :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Servis yang tertunda</p>
            </div>
        </div>

        <!-- Main Table -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="border-b border-slate-100 p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-800">
                            Daftar Servis
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Daftar kendaraan yang sedang dalam antrean servis.
                        </p>
                    </div>

                    <div class="relative w-full lg:max-w-xs">
                        <Search
                            :size="18"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                        />
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Cari servis, pelanggan, kendaraan..."
                            class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                            @input="currentPage = 1"
                        />
                    </div>
                </div>

                <!-- Filters -->
                <div class="mt-5 flex flex-wrap gap-2">
                    <button
                        v-for="filter in filters"
                        :key="filter"
                        @click="setFilter(filter)"
                        class="rounded-lg border px-4 py-2 text-sm font-medium transition"
                        :class="activeFilter === filter
                            ? 'border-emerald-700 bg-emerald-700 text-white'
                            : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'"
                    >
                        {{ filter }}
                        <span
                            v-if="filter === 'Semua'"
                            class="ml-1"
                        >
                            ({{ summary.total }})
                        </span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1050px] text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-4">No. Servis</th>
                            <th class="px-5 py-4">Pelanggan</th>
                            <th class="px-5 py-4">Kendaraan</th>
                            <th class="px-5 py-4">Jenis Servis</th>
                            <th class="px-5 py-4">Mekanik</th>
                            <th class="px-5 py-4">Biaya</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="item in paginatedServices"
                            :key="item.id"
                            class="transition hover:bg-slate-50/70"
                        >
                            <td class="px-5 py-4">
                                <span class="font-semibold text-emerald-700">
                                    {{ item.invoice }}
                                </span>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ item.date }} · {{ item.time }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-700">
                                    {{ item.customer }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ item.phone }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-700">
                                    {{ item.vehicle }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ item.plate }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ item.service }}
                            </td>

                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ item.mechanic }}
                            </td>

                            <td class="px-5 py-4 font-semibold text-slate-700">
                                {{ formatRupiah(item.cost) }}
                            </td>

                            <td class="px-5 py-4">
                                <span
                                    class="inline-flex rounded-full border px-3 py-1.5 text-xs font-semibold"
                                    :class="statusClass(item.status)"
                                >
                                    {{ item.status }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        @click="selectedService = item"
                                        class="rounded-lg border border-slate-200 p-2 text-slate-500 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700"
                                        title="Lihat detail"
                                    >
                                        <Eye :size="17" />
                                    </button>

                                    <button
                                        class="rounded-lg border border-slate-200 p-2 text-slate-500 transition hover:bg-slate-100"
                                        title="Aksi lainnya"
                                    >
                                        <MoreHorizontal :size="17" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="paginatedServices.length === 0">
                            <td colspan="8" class="px-5 py-14 text-center">
                                <div class="flex flex-col items-center">
                                    <Search :size="30" class="text-slate-300" />
                                    <p class="mt-3 font-semibold text-slate-600">
                                        Data servis tidak ditemukan
                                    </p>
                                    <p class="mt-1 text-sm text-slate-400">
                                        Coba gunakan kata kunci atau filter lainnya.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    Menampilkan
                    <span class="font-semibold text-slate-700">
                        {{ filteredServices.length ? (currentPage - 1) * perPage + 1 : 0 }}–{{ Math.min(currentPage * perPage, filteredServices.length) }}
                    </span>
                    dari
                    <span class="font-semibold text-slate-700">
                        {{ filteredServices.length }}
                    </span>
                    servis
                </p>

                <div class="flex items-center gap-2">
                    <button
                        @click="currentPage = Math.max(1, currentPage - 1)"
                        :disabled="currentPage === 1"
                        class="rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                    >
                        <ChevronLeft :size="18" />
                    </button>

                    <span class="px-2 text-sm font-medium text-slate-600">
                        Halaman {{ currentPage }} dari {{ totalPages }}
                    </span>

                    <button
                        @click="currentPage = Math.min(totalPages, currentPage + 1)"
                        :disabled="currentPage === totalPages"
                        class="rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                    >
                        <ChevronRight :size="18" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <div
            v-if="selectedService"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4"
            @click.self="selectedService = null"
        >
            <div class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-100 p-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">
                            Detail Servis
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ selectedService.invoice }}
                        </p>
                    </div>
                    <button
                        @click="selectedService = null"
                        class="rounded-lg p-2 text-slate-400 hover:bg-slate-100"
                    >
                        <X :size="20" />
                    </button>
                </div>

                <div class="space-y-4 p-5">
                    <div class="flex items-center gap-3 rounded-xl bg-emerald-50 p-4">
                        <div class="rounded-lg bg-white p-3 text-emerald-700">
                            <CarFront :size="23" />
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">
                                {{ selectedService.vehicle }}
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ selectedService.plate }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-400">Pelanggan</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedService.customer }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Nomor HP</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedService.phone }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Tanggal Servis</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedService.date }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Jam Masuk</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedService.time }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Mekanik</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedService.mechanic }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Biaya Servis</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ formatRupiah(selectedService.cost) }}
                            </p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs text-slate-400">Keluhan / Jenis Servis</p>
                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ selectedService.service }}
                        </p>
                    </div>

                    <div>
                        <p class="mb-2 text-sm font-semibold text-slate-700">
                            Ubah Status Servis
                        </p>
                        <div class="grid grid-cols-3 gap-2">
                            <button
                                v-for="status in ['Menunggu', 'Dikerjakan', 'Ditunda']"
                                :key="status"
                                @click="changeStatus(selectedService, status)"
                                class="rounded-lg border px-2 py-2.5 text-xs font-semibold transition"
                                :class="selectedService.status === status
                                    ? 'border-emerald-700 bg-emerald-700 text-white'
                                    : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                            >
                                {{ status }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 p-5">
                    <button
                        @click="selectedService = null"
                        class="w-full rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

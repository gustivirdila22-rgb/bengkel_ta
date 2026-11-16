
<script setup>
import { ref, computed } from 'vue'
import {
    Search,
    CheckCircle2,
    Wallet,
    Wrench,
    CalendarDays,
    Eye,
    ChevronLeft,
    ChevronRight,
    X,
    Printer,
    Download,
    CarFront,
    UserRound,
    FileText,
} from 'lucide-vue-next'

const search = ref('')
const activeFilter = ref('Semua')
const currentPage = ref(1)
const perPage = 8
const selectedService = ref(null)

const filters = ['Semua', 'Lunas', 'Belum Lunas']

const services = ref([
    {
        id: 1,
        invoice: 'SRV-009',
        customer: 'Rizal Firmansyah',
        phone: '081234567890',
        vehicle: 'Honda Vario 125',
        plate: 'AD 1234 AB',
        mechanic: 'Budi Santoso',
        service: 'Ganti oli dan servis CVT',
        date: '15 Nov 2026',
        time: '09:30',
        completedAt: '15 Nov 2026, 11:15',
        payment: 'Tunai',
        status: 'Lunas',
        cost: 185000,
    },
    {
        id: 2,
        invoice: 'SRV-010',
        customer: 'Doni Saputra',
        phone: '081298765432',
        vehicle: 'Yamaha NMAX',
        plate: 'AD 2345 CD',
        mechanic: 'Agus Setiawan',
        service: 'Servis berkala',
        date: '15 Nov 2026',
        time: '10:00',
        completedAt: '15 Nov 2026, 12:30',
        payment: 'Transfer',
        status: 'Lunas',
        cost: 250000,
    },
    {
        id: 3,
        invoice: 'SRV-011',
        customer: 'Fajar Nugroho',
        phone: '082123456789',
        vehicle: 'Honda Beat',
        plate: 'AD 3456 EF',
        mechanic: 'Budi Santoso',
        service: 'Ganti kampas rem',
        date: '14 Nov 2026',
        time: '08:30',
        completedAt: '14 Nov 2026, 10:00',
        payment: 'QRIS',
        status: 'Lunas',
        cost: 95000,
    },
    {
        id: 4,
        invoice: 'SRV-012',
        customer: 'Agus Widodo',
        phone: '085123456789',
        vehicle: 'Yamaha Aerox',
        plate: 'AD 4567 GH',
        mechanic: 'Agus Setiawan',
        service: 'Perbaikan sistem injeksi',
        date: '14 Nov 2026',
        time: '09:00',
        completedAt: '14 Nov 2026, 13:00',
        payment: 'Tunai',
        status: 'Lunas',
        cost: 320000,
    },
    {
        id: 5,
        invoice: 'SRV-013',
        customer: 'Bayu Ramadhan',
        phone: '087812345678',
        vehicle: 'Honda Scoopy',
        plate: 'AD 5678 IJ',
        mechanic: 'Budi Santoso',
        service: 'Ganti oli mesin',
        date: '13 Nov 2026',
        time: '10:00',
        completedAt: '13 Nov 2026, 11:00',
        payment: 'Belum Bayar',
        status: 'Belum Lunas',
        cost: 75000,
    },
    {
        id: 6,
        invoice: 'SRV-014',
        customer: 'Hendra Kurniawan',
        phone: '081345678901',
        vehicle: 'Honda PCX',
        plate: 'AD 6789 KL',
        mechanic: 'Agus Setiawan',
        service: 'Servis CVT dan ganti oli',
        date: '13 Nov 2026',
        time: '08:00',
        completedAt: '13 Nov 2026, 10:45',
        payment: 'Transfer',
        status: 'Lunas',
        cost: 275000,
    },
    {
        id: 7,
        invoice: 'SRV-015',
        customer: 'Rian Maulana',
        phone: '082234567890',
        vehicle: 'Yamaha Mio',
        plate: 'AD 7890 MN',
        mechanic: 'Budi Santoso',
        service: 'Perbaikan kelistrikan',
        date: '12 Nov 2026',
        time: '09:00',
        completedAt: '12 Nov 2026, 12:00',
        payment: 'QRIS',
        status: 'Lunas',
        cost: 200000,
    },
    {
        id: 8,
        invoice: 'SRV-016',
        customer: 'Dimas Pratama',
        phone: '085678901234',
        vehicle: 'Honda Supra X',
        plate: 'AD 8901 OP',
        mechanic: 'Agus Setiawan',
        service: 'Ganti rantai dan gear',
        date: '12 Nov 2026',
        time: '10:30',
        completedAt: '12 Nov 2026, 13:30',
        payment: 'Tunai',
        status: 'Lunas',
        cost: 220000,
    },
])

const filteredServices = computed(() => {
    const keyword = search.value.toLowerCase().trim()

    return services.value.filter(item => {
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
    paid: services.value.filter(item => item.status === 'Lunas').length,
    unpaid: services.value.filter(item => item.status === 'Belum Lunas').length,
    revenue: services.value
        .filter(item => item.status === 'Lunas')
        .reduce((total, item) => total + item.cost, 0),
}))

const formatRupiah = value =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(value)

const setFilter = filter => {
    activeFilter.value = filter
    currentPage.value = 1
}

const statusClass = status => {
    return status === 'Lunas'
        ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
        : 'border-amber-200 bg-amber-50 text-amber-700'
}

const printInvoice = item => {
    const content = `
        <html>
        <head>
            <title>Nota ${item.invoice}</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 30px; color: #334155; }
                h2 { margin-bottom: 5px; }
                .muted { color: #64748b; font-size: 13px; }
                hr { border: 0; border-top: 1px dashed #cbd5e1; margin: 20px 0; }
                .row { display: flex; justify-content: space-between; margin: 12px 0; }
                .total { font-size: 18px; font-weight: bold; }
            </style>
        </head>
        <body>
            <h2>BENGKELIN</h2>
            <p class="muted">Nota servis kendaraan</p>
            <hr>
            <div class="row"><span>No. Servis</span><b>${item.invoice}</b></div>
            <div class="row"><span>Pelanggan</span><b>${item.customer}</b></div>
            <div class="row"><span>Kendaraan</span><b>${item.vehicle}</b></div>
            <div class="row"><span>Nomor Polisi</span><b>${item.plate}</b></div>
            <div class="row"><span>Mekanik</span><b>${item.mechanic}</b></div>
            <div class="row"><span>Jenis Servis</span><b>${item.service}</b></div>
            <div class="row"><span>Tanggal</span><b>${item.date}</b></div>
            <hr>
            <div class="row total"><span>Total</span><span>${formatRupiah(item.cost)}</span></div>
            <div class="row"><span>Pembayaran</span><b>${item.payment}</b></div>
            <div class="row"><span>Status</span><b>${item.status}</b></div>
            <hr>
            <p style="text-align:center">Terima kasih telah mempercayakan kendaraan Anda kepada kami.</p>
        </body>
        </html>
    `

    const printWindow = window.open('', '_blank')

    if (!printWindow) return

    printWindow.document.write(content)
    printWindow.document.close()
    printWindow.focus()
    printWindow.print()
}

const exportCsv = () => {
    const headers = [
        'No Servis',
        'Pelanggan',
        'Kendaraan',
        'Nomor Polisi',
        'Mekanik',
        'Jenis Servis',
        'Tanggal',
        'Pembayaran',
        'Status',
        'Biaya',
    ]

    const rows = filteredServices.value.map(item => [
        item.invoice,
        item.customer,
        item.vehicle,
        item.plate,
        item.mechanic,
        item.service,
        item.date,
        item.payment,
        item.status,
        item.cost,
    ])

    const csv = [headers, ...rows]
        .map(row => row.map(value => `"${String(value).replace(/"/g, '""')}"`).join(','))
        .join('\n')

    const blob = new Blob(['\uFEFF' + csv], {
        type: 'text/csv;charset=utf-8;',
    })

    const url = URL.createObjectURL(blob)
    const link = document.createElement('a')

    link.href = url
    link.download = 'riwayat-servis-selesai.csv'
    link.click()

    URL.revokeObjectURL(url)
}
</script>

<template>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-bold text-slate-800">
                    Servis Selesai
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Lihat riwayat pekerjaan servis yang telah diselesaikan.
                </p>
            </div>

            <button
                @click="exportCsv"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                <Download :size="18" />
                Download CSV
            </button>
        </div>

        <!-- Summary -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Servis Selesai</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-800">
                            {{ summary.total }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                        <CheckCircle2 :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Pekerjaan telah diselesaikan</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Pembayaran Lunas</p>
                        <h2 class="mt-2 text-2xl font-bold text-emerald-700">
                            {{ summary.paid }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                        <Wallet :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Transaksi telah dibayar</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Belum Lunas</p>
                        <h2 class="mt-2 text-2xl font-bold text-amber-600">
                            {{ summary.unpaid }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-amber-50 p-3 text-amber-600">
                        <Wallet :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Menunggu pembayaran</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Pendapatan</p>
                        <h2 class="mt-2 text-xl font-bold text-slate-800">
                            {{ formatRupiah(summary.revenue) }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                        <FileText :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Dari servis yang sudah lunas</p>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="border-b border-slate-100 p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-800">
                            Riwayat Servis
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Seluruh catatan servis yang telah selesai.
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
                            placeholder="Cari pelanggan atau kendaraan..."
                            class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                            @input="currentPage = 1"
                        />
                    </div>
                </div>

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
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1050px] text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-4">No. Servis</th>
                            <th class="px-5 py-4">Pelanggan</th>
                            <th class="px-5 py-4">Kendaraan</th>
                            <th class="px-5 py-4">Jenis Servis</th>
                            <th class="px-5 py-4">Mekanik</th>
                            <th class="px-5 py-4">Total Biaya</th>
                            <th class="px-5 py-4">Pembayaran</th>
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
                                    {{ item.date }}
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

                            <td class="px-5 py-4 text-sm font-semibold text-slate-700">
                                {{ formatRupiah(item.cost) }}
                            </td>

                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ item.payment }}
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
                                <div class="flex items-center justify-center">
                                    <button
                                        @click="selectedService = item"
                                        class="rounded-lg border border-slate-200 p-2 text-slate-500 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700"
                                        title="Lihat detail"
                                    >
                                        <Eye :size="17" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="paginatedServices.length === 0">
                            <td colspan="9" class="px-5 py-14 text-center">
                                <Search :size="30" class="mx-auto text-slate-300" />
                                <p class="mt-3 font-semibold text-slate-600">
                                    Riwayat servis tidak ditemukan
                                </p>
                                <p class="mt-1 text-sm text-slate-400">
                                    Coba gunakan kata kunci atau filter lainnya.
                                </p>
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
                            Detail Servis Selesai
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ selectedService.invoice }}
                        </p>
                    </div>

                    <button
                        @click="selectedService = null"
                        class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100"
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
                            <p class="text-xs text-slate-400">Waktu Selesai</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedService.completedAt }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400">Mekanik</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedService.mechanic }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400">Metode Pembayaran</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedService.payment }}
                            </p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs text-slate-400">Jenis Servis</p>
                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ selectedService.service }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between rounded-xl bg-slate-50 p-4">
                        <div>
                            <p class="text-sm text-slate-500">Total Biaya</p>
                            <p class="mt-1 text-lg font-bold text-slate-800">
                                {{ formatRupiah(selectedService.cost) }}
                            </p>
                        </div>

                        <span
                            class="rounded-full border px-3 py-1.5 text-xs font-semibold"
                            :class="statusClass(selectedService.status)"
                        >
                            {{ selectedService.status }}
                        </span>
                    </div>
                </div>

                <div class="flex gap-2 border-t border-slate-100 p-5">
                    <button
                        @click="printInvoice(selectedService)"
                        class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-800"
                    >
                        <Printer :size="17" />
                        Cetak Nota
                    </button>

                    <button
                        @click="selectedService = null"
                        class="rounded-xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

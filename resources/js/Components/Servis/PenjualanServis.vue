
<script setup>
import { ref, computed } from 'vue'
import {
    Search,
    Download,
    Eye,
    X,
    ReceiptText,
    Wallet,
    CheckCircle2,
    Clock3,
    XCircle,
    CalendarDays,
    Wrench,
    UserRound,
    CarFront,
    Phone,
    CreditCard,
    Banknote,
    Filter,
} from 'lucide-vue-next'

const search = ref('')
const activeFilter = ref('Semua')
const selectedTransaction = ref(null)
const selectedPeriod = ref('Semua')

const filters = ['Semua', 'Lunas', 'Belum Lunas', 'Dibatalkan']

const transactions = ref([
    {
        id: 1,
        invoice: 'SRV-20261116-001',
        date: '2026-11-16',
        time: '09:15',
        customer: 'Andi Pratama',
        phone: '081234567890',
        vehicle: 'Honda Vario 160',
        plate: 'AD 2345 AB',
        mechanic: 'Budi Santoso',
        service: 'Servis berkala',
        items: [
            { name: 'Jasa servis berkala', qty: 1, price: 150000 },
            { name: 'Oli Mesin MPX 2', qty: 1, price: 50000 },
            { name: 'Busi NGK', qty: 1, price: 30000 },
        ],
        subtotal: 230000,
        discount: 10000,
        tax: 0,
        total: 220000,
        payment: 'Tunai',
        status: 'Lunas',
        note: 'Servis berkala dan penggantian oli.',
    },
    {
        id: 2,
        invoice: 'SRV-20261116-002',
        date: '2026-11-16',
        time: '10:40',
        customer: 'Dimas Saputra',
        phone: '081298765432',
        vehicle: 'Yamaha NMAX',
        plate: 'AD 4567 CD',
        mechanic: 'Agus Setiawan',
        service: 'Ganti oli mesin',
        items: [
            { name: 'Jasa ganti oli', qty: 1, price: 25000 },
            { name: 'Oli Mesin Yamalube', qty: 1, price: 65000 },
        ],
        subtotal: 90000,
        discount: 0,
        tax: 0,
        total: 90000,
        payment: 'Transfer',
        status: 'Lunas',
        note: 'Penggantian oli mesin.',
    },
    {
        id: 3,
        invoice: 'SRV-20261115-003',
        date: '2026-11-15',
        time: '13:20',
        customer: 'Rizky Maulana',
        phone: '082123456789',
        vehicle: 'Honda Beat',
        plate: 'AD 7890 EF',
        mechanic: 'Budi Santoso',
        service: 'Pemeriksaan rem',
        items: [
            { name: 'Jasa pemeriksaan rem', qty: 1, price: 50000 },
            { name: 'Kampas Rem Depan', qty: 1, price: 60000 },
        ],
        subtotal: 110000,
        discount: 0,
        tax: 0,
        total: 110000,
        payment: 'QRIS',
        status: 'Belum Lunas',
        note: 'Menunggu pelunasan pelanggan.',
    },
    {
        id: 4,
        invoice: 'SRV-20261115-004',
        date: '2026-11-15',
        time: '15:10',
        customer: 'Fajar Nugroho',
        phone: '085123456789',
        vehicle: 'Yamaha Aerox',
        plate: 'AD 1122 GH',
        mechanic: 'Agus Setiawan',
        service: 'Servis CVT',
        items: [
            { name: 'Jasa servis CVT', qty: 1, price: 100000 },
            { name: 'Pembersih CVT', qty: 1, price: 25000 },
        ],
        subtotal: 125000,
        discount: 0,
        tax: 0,
        total: 125000,
        payment: 'Tunai',
        status: 'Lunas',
        note: 'Pembersihan dan pemeriksaan CVT.',
    },
    {
        id: 5,
        invoice: 'SRV-20261114-005',
        date: '2026-11-14',
        time: '11:30',
        customer: 'Agus Widodo',
        phone: '087812345678',
        vehicle: 'Honda Scoopy',
        plate: 'AD 3344 IJ',
        mechanic: 'Budi Santoso',
        service: 'Ganti oli mesin',
        items: [
            { name: 'Jasa ganti oli', qty: 1, price: 25000 },
            { name: 'Oli Mesin MPX 2', qty: 1, price: 50000 },
        ],
        subtotal: 75000,
        discount: 0,
        tax: 0,
        total: 75000,
        payment: 'Tunai',
        status: 'Dibatalkan',
        note: 'Transaksi dibatalkan oleh pelanggan.',
    },
    {
        id: 6,
        invoice: 'SRV-20261114-006',
        date: '2026-11-14',
        time: '14:00',
        customer: 'Rian Firmansyah',
        phone: '081345678901',
        vehicle: 'Honda PCX',
        plate: 'AD 5566 KL',
        mechanic: 'Agus Setiawan',
        service: 'Servis berkala',
        items: [
            { name: 'Jasa servis berkala', qty: 1, price: 150000 },
            { name: 'Filter Udara', qty: 1, price: 60000 },
        ],
        subtotal: 210000,
        discount: 10000,
        tax: 0,
        total: 200000,
        payment: 'Transfer',
        status: 'Lunas',
        note: 'Servis rutin kendaraan.',
    },
    {
        id: 7,
        invoice: 'SRV-20261113-007',
        date: '2026-11-13',
        time: '09:30',
        customer: 'Bayu Ramadhan',
        phone: '082234567890',
        vehicle: 'Yamaha Mio',
        plate: 'AD 7788 MN',
        mechanic: 'Rudi Hartono',
        service: 'Pemeriksaan mesin',
        items: [
            { name: 'Jasa pemeriksaan mesin', qty: 1, price: 75000 },
            { name: 'Busi NGK', qty: 1, price: 30000 },
        ],
        subtotal: 105000,
        discount: 0,
        tax: 0,
        total: 105000,
        payment: 'QRIS',
        status: 'Belum Lunas',
        note: 'Menunggu pembayaran.',
    },
])

const periods = [
    { label: 'Semua', value: 'Semua' },
    { label: 'Hari Ini', value: 'Hari Ini' },
    { label: '7 Hari Terakhir', value: '7 Hari Terakhir' },
    { label: '30 Hari Terakhir', value: '30 Hari Terakhir' },
]

const today = '2026-11-16'

const filteredTransactions = computed(() => {
    const keyword = search.value.toLowerCase().trim()

    return transactions.value.filter(item => {
        const matchSearch = [
            item.invoice,
            item.customer,
            item.phone,
            item.vehicle,
            item.plate,
            item.service,
            item.mechanic,
        ].some(value => value.toLowerCase().includes(keyword))

        const matchStatus =
            activeFilter.value === 'Semua' ||
            item.status === activeFilter.value

        let matchPeriod = true

        if (selectedPeriod.value === 'Hari Ini') {
            matchPeriod = item.date === today
        } else if (selectedPeriod.value === '7 Hari Terakhir') {
            matchPeriod = item.date >= '2026-11-10' && item.date <= today
        } else if (selectedPeriod.value === '30 Hari Terakhir') {
            matchPeriod = item.date >= '2026-10-18' && item.date <= today
        }

        return matchSearch && matchStatus && matchPeriod
    }).sort((a, b) =>
        `${b.date} ${b.time}`.localeCompare(`${a.date} ${a.time}`)
    )
})

const summary = computed(() => {
    const items = filteredTransactions.value

    return {
        total: items.length,
        revenue: items
            .filter(item => item.status === 'Lunas')
            .reduce((sum, item) => sum + item.total, 0),
        paid: items.filter(item => item.status === 'Lunas').length,
        unpaid: items.filter(item => item.status === 'Belum Lunas').length,
    }
})

const formatRupiah = value =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(value)

const formatDate = date =>
    new Date(`${date}T00:00:00`).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    })

const statusClass = status => {
    const classes = {
        Lunas: 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'Belum Lunas': 'border-amber-200 bg-amber-50 text-amber-700',
        Dibatalkan: 'border-rose-200 bg-rose-50 text-rose-700',
    }

    return classes[status] || 'border-slate-200 bg-slate-50 text-slate-600'
}

const paymentIcon = method => {
    if (method === 'Tunai') return Banknote
    if (method === 'Transfer') return Wallet
    return CreditCard
}

const changeStatus = (item, status) => {
    item.status = status
    selectedTransaction.value = null
}

const exportReport = () => {
    const rows = [
        [
            'No. Invoice',
            'Tanggal',
            'Pelanggan',
            'Kendaraan',
            'Nomor Polisi',
            'Jenis Servis',
            'Mekanik',
            'Metode Pembayaran',
            'Status',
            'Total',
        ],
        ...filteredTransactions.value.map(item => [
            item.invoice,
            item.date,
            item.customer,
            item.vehicle,
            item.plate,
            item.service,
            item.mechanic,
            item.payment,
            item.status,
            item.total,
        ]),
    ]

    const csv = rows
        .map(row =>
            row.map(value =>
                `"${String(value ?? '').replace(/"/g, '""')}"`
            ).join(',')
        )
        .join('\n')

    const blob = new Blob(['\uFEFF' + csv], {
        type: 'text/csv;charset=utf-8;',
    })

    const url = URL.createObjectURL(blob)
    const link = document.createElement('a')

    link.href = url
    link.download = 'laporan-penjualan-servis.csv'
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
                    Penjualan Servis
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Pantau seluruh transaksi dan pembayaran layanan servis bengkel.
                </p>
            </div>

            <button
                @click="exportReport"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-800"
            >
                <Download :size="18" />
                Export Laporan
            </button>
        </div>

        <!-- Summary -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Transaksi
                        </p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-800">
                            {{ summary.total }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                        <ReceiptText :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-400">
                    Jumlah transaksi sesuai filter
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Pendapatan
                        </p>
                        <h2 class="mt-2 text-xl font-bold text-slate-800">
                            {{ formatRupiah(summary.revenue) }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                        <Wallet :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-400">
                    Dari transaksi yang sudah lunas
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Transaksi Lunas
                        </p>
                        <h2 class="mt-2 text-2xl font-bold text-emerald-700">
                            {{ summary.paid }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                        <CheckCircle2 :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-400">
                    Pembayaran sudah diterima
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Belum Lunas
                        </p>
                        <h2 class="mt-2 text-2xl font-bold text-amber-600">
                            {{ summary.unpaid }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-amber-50 p-3 text-amber-600">
                        <Clock3 :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-400">
                    Menunggu pembayaran
                </p>
            </div>
        </div>

        <!-- Transactions -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="border-b border-slate-100 p-5">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <h2 class="font-bold text-slate-800">
                            Riwayat Penjualan Servis
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Daftar seluruh transaksi layanan servis.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <div class="relative">
                            <Search
                                :size="18"
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                            />
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Cari transaksi..."
                                class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 sm:w-64"
                            />
                        </div>

                        <div class="relative">
                            <CalendarDays
                                :size="17"
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                            />
                            <select
                                v-model="selectedPeriod"
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-9 text-sm text-slate-700 outline-none focus:border-emerald-600 sm:w-48"
                            >
                                <option
                                    v-for="period in periods"
                                    :key="period.value"
                                    :value="period.value"
                                >
                                    {{ period.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="mt-5 flex flex-wrap items-center gap-2">
                    <div class="mr-1 flex items-center gap-2 text-sm text-slate-500">
                        <Filter :size="16" />
                        Status:
                    </div>

                    <button
                        v-for="filter in filters"
                        :key="filter"
                        @click="activeFilter = filter"
                        class="rounded-lg border px-4 py-2 text-sm font-medium transition"
                        :class="activeFilter === filter
                            ? 'border-emerald-700 bg-emerald-700 text-white'
                            : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'"
                    >
                        {{ filter }}
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1050px] text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-4">Invoice</th>
                            <th class="px-5 py-4">Pelanggan</th>
                            <th class="px-5 py-4">Kendaraan</th>
                            <th class="px-5 py-4">Jenis Servis</th>
                            <th class="px-5 py-4">Tanggal</th>
                            <th class="px-5 py-4">Total</th>
                            <th class="px-5 py-4">Pembayaran</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="item in filteredTransactions"
                            :key="item.id"
                            class="transition hover:bg-slate-50/70"
                        >
                            <td class="px-5 py-4">
                                <p class="whitespace-nowrap text-sm font-semibold text-emerald-700">
                                    {{ item.invoice }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ item.time }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="text-sm font-semibold text-slate-700">
                                    {{ item.customer }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ item.phone }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="text-sm font-medium text-slate-700">
                                    {{ item.vehicle }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ item.plate }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ item.service }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                {{ formatDate(item.date) }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-800">
                                {{ formatRupiah(item.total) }}
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-2 text-sm text-slate-600">
                                    <component
                                        :is="paymentIcon(item.payment)"
                                        :size="16"
                                        class="text-slate-400"
                                    />
                                    {{ item.payment }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <span
                                    class="whitespace-nowrap rounded-full border px-3 py-1.5 text-xs font-semibold"
                                    :class="statusClass(item.status)"
                                >
                                    {{ item.status }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <button
                                    @click="selectedTransaction = item"
                                    class="rounded-lg border border-slate-200 p-2 text-slate-500 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700"
                                    title="Lihat detail"
                                >
                                    <Eye :size="17" />
                                </button>
                            </td>
                        </tr>

                        <tr v-if="filteredTransactions.length === 0">
                            <td colspan="9" class="px-5 py-14 text-center">
                                <ReceiptText :size="34" class="mx-auto text-slate-300" />
                                <p class="mt-3 font-semibold text-slate-600">
                                    Transaksi tidak ditemukan
                                </p>
                                <p class="mt-1 text-sm text-slate-400">
                                    Coba ubah kata kunci atau filter pencarian.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-2 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    Menampilkan
                    <span class="font-semibold text-slate-700">
                        {{ filteredTransactions.length }}
                    </span>
                    transaksi
                </p>
                <p class="text-sm text-slate-400">
                    Data transaksi servis
                </p>
            </div>
        </div>

        <!-- Detail Modal -->
        <div
            v-if="selectedTransaction"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-900/50 p-4"
            @click.self="selectedTransaction = null"
        >
            <div class="my-auto w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-100 p-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">
                            Detail Transaksi Servis
                        </h3>
                        <p class="mt-1 text-sm text-emerald-700">
                            {{ selectedTransaction.invoice }}
                        </p>
                    </div>

                    <button
                        @click="selectedTransaction = null"
                        class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100"
                    >
                        <X :size="20" />
                    </button>
                </div>

                <div class="max-h-[70vh] space-y-5 overflow-y-auto p-5">
                    <!-- Customer and Vehicle -->
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="flex items-center gap-2 text-slate-400">
                                <UserRound :size="17" />
                                <span class="text-xs font-medium">Pelanggan</span>
                            </div>
                            <p class="mt-2 font-semibold text-slate-800">
                                {{ selectedTransaction.customer }}
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ selectedTransaction.phone || '-' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="flex items-center gap-2 text-slate-400">
                                <CarFront :size="17" />
                                <span class="text-xs font-medium">Kendaraan</span>
                            </div>
                            <p class="mt-2 font-semibold text-slate-800">
                                {{ selectedTransaction.vehicle }}
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ selectedTransaction.plate }}
                            </p>
                        </div>
                    </div>

                    <!-- Transaction Info -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-400">Tanggal Transaksi</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ formatDate(selectedTransaction.date) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Jam</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedTransaction.time }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Mekanik</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedTransaction.mechanic }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Metode Pembayaran</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedTransaction.payment }}
                            </p>
                        </div>
                    </div>

                    <!-- Service Items -->
                    <div>
                        <h4 class="mb-3 font-semibold text-slate-800">
                            Rincian Servis dan Sparepart
                        </h4>

                        <div class="overflow-x-auto rounded-xl border border-slate-200">
                            <table class="w-full min-w-[400px] text-left">
                                <thead class="bg-slate-50">
                                    <tr class="text-xs font-semibold text-slate-500">
                                        <th class="px-4 py-3">Nama Item</th>
                                        <th class="px-4 py-3 text-center">Qty</th>
                                        <th class="px-4 py-3 text-right">Harga</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">
                                    <tr
                                        v-for="(item, index) in selectedTransaction.items"
                                        :key="index"
                                    >
                                        <td class="px-4 py-3 text-sm text-slate-700">
                                            {{ item.name }}
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-slate-600">
                                            {{ item.qty }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-medium text-slate-700">
                                            {{ formatRupiah(item.price * item.qty) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="space-y-3 rounded-xl bg-slate-50 p-4">
                        <div class="flex justify-between text-sm text-slate-600">
                            <span>Subtotal</span>
                            <span>{{ formatRupiah(selectedTransaction.subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-slate-600">
                            <span>Diskon</span>
                            <span>-{{ formatRupiah(selectedTransaction.discount) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-slate-600">
                            <span>Pajak</span>
                            <span>{{ formatRupiah(selectedTransaction.tax) }}</span>
                        </div>
                        <div class="flex justify-between border-t border-slate-200 pt-3">
                            <span class="font-bold text-slate-800">Total Pembayaran</span>
                            <span class="text-lg font-bold text-emerald-700">
                                {{ formatRupiah(selectedTransaction.total) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm font-medium text-slate-600">
                            Status Pembayaran
                        </span>
                        <span
                            class="rounded-full border px-3 py-1.5 text-xs font-semibold"
                            :class="statusClass(selectedTransaction.status)"
                        >
                            {{ selectedTransaction.status }}
                        </span>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs font-medium text-slate-400">
                            Catatan Transaksi
                        </p>
                        <p class="mt-1 text-sm text-slate-700">
                            {{ selectedTransaction.note || 'Tidak ada catatan.' }}
                        </p>
                    </div>

                    <div v-if="selectedTransaction.status !== 'Dibatalkan'">
                        <p class="mb-2 text-sm font-semibold text-slate-700">
                            Ubah Status Pembayaran
                        </p>

                        <div class="flex flex-wrap gap-2">
                            <button
                                @click="changeStatus(selectedTransaction, 'Lunas')"
                                class="inline-flex items-center gap-2 rounded-lg border border-emerald-200 px-4 py-2.5 text-sm font-semibold text-emerald-700 hover:bg-emerald-50"
                            >
                                <CheckCircle2 :size="16" />
                                Lunas
                            </button>

                            <button
                                @click="changeStatus(selectedTransaction, 'Belum Lunas')"
                                class="inline-flex items-center gap-2 rounded-lg border border-amber-200 px-4 py-2.5 text-sm font-semibold text-amber-700 hover:bg-amber-50"
                            >
                                <Clock3 :size="16" />
                                Belum Lunas
                            </button>

                            <button
                                @click="changeStatus(selectedTransaction, 'Dibatalkan')"
                                class="inline-flex items-center gap-2 rounded-lg border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-700 hover:bg-rose-50"
                            >
                                <XCircle :size="16" />
                                Batalkan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 p-5">
                    <button
                        @click="selectedTransaction = null"
                        class="w-full rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                    >
                        Tutup Detail
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

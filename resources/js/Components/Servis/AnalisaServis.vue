
<script setup>
import { ref, computed } from 'vue'
import {
    TrendingUp,
    TrendingDown,
    Wallet,
    Wrench,
    Users,
    ClipboardCheck,
    CalendarDays,
    Download,
    ArrowUpRight,
    ArrowDownRight,
    ChartNoAxesCombined,
    Trophy,
    Package,
    Clock3,
} from 'lucide-vue-next'

const selectedPeriod = ref('7 Hari Terakhir')

const periods = [
    '7 Hari Terakhir',
    '30 Hari Terakhir',
    '3 Bulan Terakhir',
    'Tahun Ini',
]

const periodData = {
    '7 Hari Terakhir': {
        revenue: 8750000,
        previousRevenue: 7200000,
        totalServices: 48,
        previousServices: 42,
        average: 182292,
        profit: 3650000,
        chart: [
            { day: 'Sen', revenue: 950000, count: 6 },
            { day: 'Sel', revenue: 1250000, count: 8 },
            { day: 'Rab', revenue: 850000, count: 5 },
            { day: 'Kam', revenue: 1450000, count: 9 },
            { day: 'Jum', revenue: 1100000, count: 7 },
            { day: 'Sab', revenue: 1850000, count: 8 },
            { day: 'Min', revenue: 1300000, count: 5 },
        ],
    },
    '30 Hari Terakhir': {
        revenue: 32500000,
        previousRevenue: 27800000,
        totalServices: 186,
        previousServices: 165,
        average: 174731,
        profit: 13900000,
        chart: [
            { day: 'Minggu 1', revenue: 6500000, count: 38 },
            { day: 'Minggu 2', revenue: 7800000, count: 45 },
            { day: 'Minggu 3', revenue: 8200000, count: 48 },
            { day: 'Minggu 4', revenue: 10000000, count: 55 },
        ],
    },
    '3 Bulan Terakhir': {
        revenue: 92800000,
        previousRevenue: 80500000,
        totalServices: 542,
        previousServices: 478,
        average: 171218,
        profit: 39700000,
        chart: [
            { day: 'Sep', revenue: 27500000, count: 160 },
            { day: 'Okt', revenue: 32900000, count: 190 },
            { day: 'Nov', revenue: 32500000, count: 192 },
        ],
    },
    'Tahun Ini': {
        revenue: 385000000,
        previousRevenue: 320000000,
        totalServices: 2240,
        previousServices: 1940,
        average: 171875,
        profit: 165000000,
        chart: [
            { day: 'Jan', revenue: 25000000, count: 145 },
            { day: 'Feb', revenue: 27000000, count: 155 },
            { day: 'Mar', revenue: 29000000, count: 170 },
            { day: 'Apr', revenue: 31000000, count: 180 },
            { day: 'Mei', revenue: 30000000, count: 175 },
            { day: 'Jun', revenue: 32000000, count: 185 },
            { day: 'Jul', revenue: 34000000, count: 195 },
            { day: 'Agu', revenue: 35000000, count: 200 },
            { day: 'Sep', revenue: 36000000, count: 210 },
            { day: 'Okt', revenue: 38000000, count: 220 },
            { day: 'Nov', revenue: 38500000, count: 225 },
        ],
    },
}

const mechanics = [
    {
        name: 'Budi Santoso',
        role: 'Mekanik Senior',
        services: 28,
        revenue: 4850000,
        percentage: 90,
    },
    {
        name: 'Agus Setiawan',
        role: 'Mekanik',
        services: 22,
        revenue: 3750000,
        percentage: 72,
    },
    {
        name: 'Rudi Hartono',
        role: 'Mekanik',
        services: 17,
        revenue: 2950000,
        percentage: 55,
    },
    {
        name: 'Dedi Kurniawan',
        role: 'Mekanik',
        services: 12,
        revenue: 2100000,
        percentage: 38,
    },
]

const popularServices = [
    { name: 'Ganti Oli Mesin', count: 86, percentage: 92, revenue: 6450000 },
    { name: 'Servis CVT', count: 64, percentage: 76, revenue: 9600000 },
    { name: 'Servis Berkala', count: 48, percentage: 60, revenue: 12000000 },
    { name: 'Ganti Kampas Rem', count: 35, percentage: 43, revenue: 3500000 },
    { name: 'Perbaikan Kelistrikan', count: 22, percentage: 28, revenue: 4400000 },
]

const topSpareparts = [
    { name: 'Oli Mesin MPX 2', sold: 54, revenue: 2700000 },
    { name: 'Kampas Rem Depan', sold: 32, revenue: 1920000 },
    { name: 'Busi NGK', sold: 28, revenue: 840000 },
    { name: 'Filter Udara', sold: 21, revenue: 1260000 },
]

const currentData = computed(() => periodData[selectedPeriod.value])

const revenueGrowth = computed(() => {
    const data = currentData.value
    return ((data.revenue - data.previousRevenue) / data.previousRevenue) * 100
})

const serviceGrowth = computed(() => {
    const data = currentData.value
    return ((data.totalServices - data.previousServices) / data.previousServices) * 100
})

const maxRevenue = computed(() =>
    Math.max(...currentData.value.chart.map(item => item.revenue), 1)
)

const formatRupiah = value =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(value)

const formatCompact = value => {
    if (value >= 1000000) {
        return `Rp ${(value / 1000000).toLocaleString('id-ID', {
            maximumFractionDigits: 1,
        })} jt`
    }

    return `Rp ${(value / 1000).toLocaleString('id-ID')} rb`
}

const exportReport = () => {
    const data = currentData.value

    const rows = [
        ['Laporan Analisa Servis', selectedPeriod.value],
        ['Total Pendapatan', data.revenue],
        ['Pendapatan Sebelumnya', data.previousRevenue],
        ['Total Servis', data.totalServices],
        ['Jumlah Servis Sebelumnya', data.previousServices],
        ['Rata-rata Transaksi', data.average],
        ['Estimasi Laba Kotor', data.profit],
        [],
        ['Mekanik', 'Jumlah Servis', 'Pendapatan'],
        ...mechanics.map(item => [item.name, item.services, item.revenue]),
        [],
        ['Jenis Servis', 'Jumlah', 'Pendapatan'],
        ...popularServices.map(item => [item.name, item.count, item.revenue]),
    ]

    const csv = rows
        .map(row => row.map(value => `"${String(value ?? '').replace(/"/g, '""')}"`).join(','))
        .join('\n')

    const blob = new Blob(['\uFEFF' + csv], {
        type: 'text/csv;charset=utf-8;',
    })

    const url = URL.createObjectURL(blob)
    const link = document.createElement('a')

    link.href = url
    link.download = 'analisa-servis.csv'
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
                    Analisa Servis
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Pantau performa servis dan perkembangan pendapatan bengkel.
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row">
                <select
                    v-model="selectedPeriod"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 outline-none focus:border-emerald-600"
                >
                    <option v-for="period in periods" :key="period" :value="period">
                        {{ period }}
                    </option>
                </select>

                <button
                    @click="exportReport"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-800"
                >
                    <Download :size="17" />
                    Export Laporan
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Pendapatan
                        </p>
                        <h2 class="mt-2 text-xl font-bold text-slate-800">
                            {{ formatRupiah(currentData.revenue) }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                        <Wallet :size="22" />
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-1.5 text-sm">
                    <TrendingUp
                        :size="16"
                        class="text-emerald-600"
                    />
                    <span class="font-semibold text-emerald-600">
                        +{{ revenueGrowth.toFixed(1) }}%
                    </span>
                    <span class="text-slate-400">dari periode sebelumnya</span>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Servis
                        </p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-800">
                            {{ currentData.totalServices }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                        <Wrench :size="22" />
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-1.5 text-sm">
                    <TrendingUp :size="16" class="text-emerald-600" />
                    <span class="font-semibold text-emerald-600">
                        +{{ serviceGrowth.toFixed(1) }}%
                    </span>
                    <span class="text-slate-400">dari periode sebelumnya</span>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Rata-rata Transaksi
                        </p>
                        <h2 class="mt-2 text-xl font-bold text-slate-800">
                            {{ formatRupiah(currentData.average) }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-violet-50 p-3 text-violet-600">
                        <ChartNoAxesCombined :size="22" />
                    </div>
                </div>

                <p class="mt-3 text-sm text-slate-400">
                    Rata-rata nilai setiap servis
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Estimasi Laba Kotor
                        </p>
                        <h2 class="mt-2 text-xl font-bold text-slate-800">
                            {{ formatRupiah(currentData.profit) }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-amber-50 p-3 text-amber-600">
                        <TrendingUp :size="22" />
                    </div>
                </div>

                <p class="mt-3 text-sm text-slate-400">
                    Estimasi sebelum biaya operasional
                </p>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-bold text-slate-800">
                        Grafik Pendapatan Servis
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Perkembangan pendapatan berdasarkan {{ selectedPeriod.toLowerCase() }}.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-600" />
                    Pendapatan
                </div>
            </div>

            <div class="mt-8 flex h-64 items-end gap-3 overflow-x-auto pb-2 sm:gap-5">
                <div
                    v-for="item in currentData.chart"
                    :key="item.day"
                    class="flex h-full min-w-0 flex-1 flex-col items-center justify-end gap-3"
                >
                    <span class="whitespace-nowrap text-xs font-medium text-slate-500">
                        {{ formatCompact(item.revenue) }}
                    </span>

                    <div class="flex h-full w-full items-end justify-center">
                        <div
                            class="group relative w-full max-w-16 rounded-t-xl bg-emerald-600 transition hover:bg-emerald-700"
                            :style="{
                                height: `${Math.max((item.revenue / maxRevenue) * 100, 5)}%`,
                            }"
                        >
                            <div class="absolute -top-10 left-1/2 hidden -translate-x-1/2 whitespace-nowrap rounded-lg bg-slate-800 px-2 py-1 text-xs text-white group-hover:block">
                                {{ formatRupiah(item.revenue) }}
                            </div>
                        </div>
                    </div>

                    <span class="whitespace-nowrap text-xs font-medium text-slate-500">
                        {{ item.day }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Performance -->
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            <!-- Mechanics -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-slate-800">
                            Performa Mekanik
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Produktivitas mekanik berdasarkan jumlah servis.
                        </p>
                    </div>
                    <div class="rounded-xl bg-amber-50 p-3 text-amber-600">
                        <Trophy :size="21" />
                    </div>
                </div>

                <div class="mt-5 space-y-5">
                    <div
                        v-for="(mechanic, index) in mechanics"
                        :key="mechanic.name"
                    >
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex min-w-0 items-center gap-3">
                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-sm font-bold"
                                    :class="index === 0
                                        ? 'bg-amber-100 text-amber-700'
                                        : 'bg-slate-100 text-slate-600'"
                                >
                                    {{ index + 1 }}
                                </div>

                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-800">
                                        {{ mechanic.name }}
                                    </p>
                                    <p class="mt-0.5 text-xs text-slate-400">
                                        {{ mechanic.role }}
                                    </p>
                                </div>
                            </div>

                            <div class="shrink-0 text-right">
                                <p class="text-sm font-bold text-slate-800">
                                    {{ mechanic.services }} servis
                                </p>
                                <p class="mt-0.5 text-xs text-slate-400">
                                    {{ formatRupiah(mechanic.revenue) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100">
                            <div
                                class="h-full rounded-full bg-emerald-600 transition-all"
                                :style="{ width: `${mechanic.percentage}%` }"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular Services -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-slate-800">
                            Jenis Servis Terlaris
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Layanan yang paling sering dikerjakan.
                        </p>
                    </div>
                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                        <ClipboardCheck :size="21" />
                    </div>
                </div>

                <div class="mt-5 space-y-5">
                    <div
                        v-for="(item, index) in popularServices"
                        :key="item.name"
                    >
                        <div class="flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-slate-800">
                                    {{ item.name }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ item.count }} kali dikerjakan
                                </p>
                            </div>

                            <div class="shrink-0 text-right">
                                <p class="text-sm font-semibold text-slate-700">
                                    {{ formatRupiah(item.revenue) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100">
                            <div
                                class="h-full rounded-full transition-all"
                                :class="index === 0 ? 'bg-emerald-600' : 'bg-emerald-400'"
                                :style="{ width: `${item.percentage}%` }"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Spareparts -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h2 class="font-bold text-slate-800">
                        Sparepart Paling Banyak Digunakan
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Sparepart yang paling sering terjual melalui servis.
                    </p>
                </div>

                <div class="rounded-xl bg-violet-50 p-3 text-violet-600">
                    <Package :size="21" />
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[550px] text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-4">No.</th>
                            <th class="px-5 py-4">Nama Sparepart</th>
                            <th class="px-5 py-4">Jumlah Terpakai</th>
                            <th class="px-5 py-4">Total Penjualan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="(item, index) in topSpareparts"
                            :key="item.name"
                            class="hover:bg-slate-50/70"
                        >
                            <td class="px-5 py-4 text-sm text-slate-500">
                                {{ index + 1 }}
                            </td>
                            <td class="px-5 py-4 text-sm font-semibold text-slate-700">
                                {{ item.name }}
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ item.sold }} pcs
                            </td>
                            <td class="px-5 py-4 text-sm font-semibold text-slate-700">
                                {{ formatRupiah(item.revenue) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Note -->
        <div class="flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 p-4">
            <ChartNoAxesCombined :size="20" class="mt-0.5 shrink-0 text-blue-600" />
            <div>
                <p class="text-sm font-semibold text-blue-800">
                    Informasi Analisa
                </p>
                <p class="mt-1 text-sm leading-relaxed text-blue-700">
                    Angka dan grafik pada halaman ini masih menggunakan data contoh.
                    Estimasi laba kotor bukan laba bersih karena belum memperhitungkan
                    biaya operasional, gaji, dan pengeluaran lainnya.
                </p>
            </div>
        </div>
    </div>
</template>

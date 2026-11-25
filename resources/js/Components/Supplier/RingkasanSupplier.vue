
<script setup>
import {
    Wallet,
    CalendarClock,
    Hourglass,
    ShoppingCart,
    PackageCheck,
    Truck,
} from 'lucide-vue-next'

const statistik = [
    {
        label: 'Total utang',
        nilai: 'Rp106.953.000',
        keterangan: 'Yang belum dibayar ke supplier',
        icon: Wallet,
        warna: 'text-emerald-600',
        link: 'Lihat →',
    },
    {
        label: 'Jatuh tempo',
        nilai: '2',
        keterangan: 'Rp15.000.000 dalam 7 hari',
        icon: CalendarClock,
        warna: 'text-amber-500',
        link: 'Lihat →',
    },
    {
        label: 'Lewat tempo',
        nilai: '36',
        keterangan: 'Rp91.758.000 sudah lewat',
        icon: Hourglass,
        warna: 'text-red-500',
        link: 'Lihat →',
    },
    {
        label: 'Belanja bulan ini',
        nilai: 'Rp0',
        keterangan: 'Pembelian yang sudah selesai',
        icon: ShoppingCart,
        warna: 'text-blue-500',
        link: 'Lihat →',
    },
    {
        label: 'Pesanan menunggu',
        nilai: '0',
        keterangan: 'Pesanan ke Supplier yang barangnya belum lengkap',
        icon: PackageCheck,
        warna: 'text-emerald-600',
        link: 'Lihat →',
    },
    {
        label: 'Lama barang datang',
        nilai: '—',
        keterangan: 'Rata-rata 90 hari terakhir, dari tanggal pesan',
        icon: Truck,
        warna: 'text-slate-500',
        link: null,
    },
]

const bulan = [
    { nama: 'Des', nilai: 0 },
    { nama: 'Jan', nilai: 0 },
    { nama: 'Feb', nilai: 0 },
    { nama: 'Mar', nilai: 0 },
    { nama: 'Apr', nilai: 0 },
    { nama: 'Mei', nilai: 0 },
    { nama: 'Jun', nilai: 0 },
    { nama: 'Jul', nilai: 165 },
    { nama: 'Agu', nilai: 120 },
    { nama: 'Sep', nilai: 55 },
    { nama: 'Okt', nilai: 25 },
    { nama: 'Nov', nilai: 0 },
]

const utangTerbesar = [
    { nama: 'Agen Oli Makmur Sentosa', kode: 'SUP-D02', nominal: 'Rp45.984.500' },
    { nama: 'Elektrik Mobil Nusantara', kode: 'SUP-D04', nominal: 'Rp40.044.000' },
    { nama: 'Toko Sparepart Jaya Motor', kode: 'SUP-D01', nominal: 'Rp18.259.500' },
    { nama: 'Sumber Rem & Kaki-kaki', kode: 'SUP-D03', nominal: 'Rp1.770.000' },
    { nama: 'Grosir Aksesoris Otomotif', kode: 'SUP-D05', nominal: 'Rp195.000' },
]

const belanjaTerbanyak = [
    { nama: 'Agen Oli Makmur Sentosa', kode: 'SUP-D02', nominal: 'Rp44.476.500' },
    { nama: 'Elektrik Mobil Nusantara', kode: 'SUP-D04', nominal: 'Rp28.953.000' },
    { nama: 'Toko Sparepart Jaya Motor', kode: 'SUP-D01', nominal: 'Rp26.109.000' },
    { nama: 'Sumber Rem & Kaki-kaki', kode: 'SUP-D03', nominal: 'Rp4.735.000' },
    { nama: 'Grosir Aksesoris Otomotif', kode: 'SUP-D05', nominal: 'Rp1.627.000' },
]
</script>

<template>
    <div class="space-y-5">

        <!-- STATISTIK -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <div
                v-for="item in statistik"
                :key="item.label"
                class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
            >
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-600">
                        {{ item.label }}
                    </p>

                    <component
                        :is="item.icon"
                        :size="19"
                        :class="item.warna"
                    />
                </div>

                <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">
                    {{ item.nilai }}
                </h3>

                <p class="mt-1 text-xs leading-relaxed text-slate-500">
                    {{ item.keterangan }}
                </p>

                <button
                    v-if="item.link"
                    type="button"
                    class="mt-3 text-xs font-semibold text-emerald-600 transition hover:text-emerald-700"
                >
                    {{ item.link }}
                </button>
            </div>
        </div>

        <!-- GRAFIK BELANJA PER BULAN -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5">
                <h3 class="font-bold text-slate-800">
                    Belanja per bulan
                </h3>
                <p class="mt-1 text-xs text-slate-500">
                    Total pembelian supplier setiap bulan
                </p>
            </div>

            <div class="flex gap-3">
                <!-- LABEL Y -->
                <div class="flex h-48 shrink-0 flex-col justify-between pb-7 text-right text-[11px] text-slate-400">
                    <span>Rp200 jt</span>
                    <span>Rp150 jt</span>
                    <span>Rp100 jt</span>
                    <span>Rp50 jt</span>
                    <span>Rp0</span>
                </div>

                <!-- AREA CHART -->
                <div class="relative min-w-0 flex-1">
                    <!-- GARIS GRID -->
                    <div class="pointer-events-none absolute inset-x-0 top-0 flex h-40 flex-col justify-between">
                        <div class="border-t border-dashed border-slate-100"></div>
                        <div class="border-t border-dashed border-slate-100"></div>
                        <div class="border-t border-dashed border-slate-100"></div>
                        <div class="border-t border-dashed border-slate-100"></div>
                        <div class="border-t border-slate-200"></div>
                    </div>

                    <!-- BAR -->
                    <div class="relative z-10 grid h-48 grid-cols-12 items-end gap-1 sm:gap-3">
                        <div
                            v-for="item in bulan"
                            :key="item.nama"
                            class="flex h-full min-w-0 flex-col items-center justify-end"
                        >
                            <div class="flex h-40 w-full items-end justify-center">
                                <div
                                    class="w-3/5 max-w-7 rounded-t-lg bg-emerald-500 transition-all duration-300 hover:bg-emerald-600 sm:w-7"
                                    :style="{
                                        height: `${(item.nilai / 200) * 100}%`,
                                        minHeight: item.nilai > 0 ? '3px' : '0px',
                                    }"
                                    :title="`${item.nama}: Rp${item.nilai} juta`"
                                ></div>
                            </div>

                            <span class="mt-2 text-[10px] text-slate-500 sm:text-xs">
                                {{ item.nama }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DAFTAR SUPPLIER -->
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">

            <!-- UTANG TERBESAR -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800">
                        Utang terbesar
                    </h3>

                    <span class="rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                        Top 5
                    </span>
                </div>

                <div
                    v-for="(item, index) in utangTerbesar"
                    :key="item.kode"
                    class="flex items-center justify-between gap-3 border-b border-slate-100 py-3 last:border-0"
                >
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="w-4 shrink-0 text-sm text-slate-400">
                            {{ index + 1 }}
                        </span>

                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-slate-800">
                                {{ item.nama }}
                            </p>
                            <p class="mt-0.5 text-xs text-slate-400">
                                {{ item.kode }}
                            </p>
                        </div>
                    </div>

                    <span class="shrink-0 text-right text-xs font-semibold text-slate-800 sm:text-sm">
                        {{ item.nominal }}
                    </span>
                </div>
            </div>

            <!-- BELANJA TERBANYAK -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800">
                        Belanja terbanyak (90 hari terakhir)
                    </h3>

                    <span class="rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                        Top 5
                    </span>
                </div>

                <div
                    v-for="(item, index) in belanjaTerbanyak"
                    :key="item.kode"
                    class="flex items-center justify-between gap-3 border-b border-slate-100 py-3 last:border-0"
                >
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="w-4 shrink-0 text-sm text-slate-400">
                            {{ index + 1 }}
                        </span>

                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-slate-800">
                                {{ item.nama }}
                            </p>
                            <p class="mt-0.5 text-xs text-slate-400">
                                {{ item.kode }}
                            </p>
                        </div>
                    </div>

                    <span class="shrink-0 text-right text-xs font-semibold text-slate-800 sm:text-sm">
                        {{ item.nominal }}
                    </span>
                </div>
            </div>

        </div>
    </div>
</template>

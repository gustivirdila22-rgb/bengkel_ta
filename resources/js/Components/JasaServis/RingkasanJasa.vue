
<script setup>
import { computed } from 'vue'
import {
    Wrench,
    Wallet,
    TrendingUp,
    Clock,
    Tags,
} from 'lucide-vue-next'

const props = defineProps({
    jasaServis: {
        type: Array,
        default: () => [],
    },
})

const rupiah = (angka) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka || 0)
}

const statistik = computed(() => {
    const jasaAktif = props.jasaServis.filter(item => item.aktif)

    const totalHarga = jasaAktif.reduce(
        (total, item) => total + Number(item.harga_standar || 0),
        0
    )

    const totalModal = jasaAktif.reduce(
        (total, item) => total + Number(item.modal || 0),
        0
    )

    const totalEstimasi = jasaAktif.reduce(
        (total, item) => total + Number(item.estimasi_menit || 0),
        0
    )

    const potensiKeuntungan = totalHarga - totalModal

    return {
        total: jasaAktif.length,
        totalHarga,
        totalModal,
        potensiKeuntungan,
        totalEstimasi,
        rataHarga: jasaAktif.length
            ? totalHarga / jasaAktif.length
            : 0,
        rataKeuntungan: jasaAktif.length
            ? potensiKeuntungan / jasaAktif.length
            : 0,
    }
})

const jasaTermahal = computed(() => {
    return [...props.jasaServis]
        .filter(item => item.aktif)
        .sort((a, b) => Number(b.harga_standar || 0) - Number(a.harga_standar || 0))
        .slice(0, 5)
})

const jasaTerbesarKeuntungan = computed(() => {
    return [...props.jasaServis]
        .filter(item => item.aktif)
        .sort((a, b) => {
            const untungA = Number(a.harga_standar || 0) - Number(a.modal || 0)
            const untungB = Number(b.harga_standar || 0) - Number(b.modal || 0)

            return untungB - untungA
        })
        .slice(0, 5)
})
</script>

<template>
    <div class="space-y-5">

        <!-- STATISTIK UTAMA -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Jasa Aktif</p>
                        <h3 class="mt-2 text-2xl font-bold text-slate-800">
                            {{ statistik.total }}
                        </h3>
                        <p class="mt-1 text-xs text-slate-400">
                            Jenis jasa tersedia
                        </p>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <Wrench :size="21" />
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Harga Standar</p>
                        <h3 class="mt-2 text-xl font-bold text-slate-800">
                            {{ rupiah(statistik.totalHarga) }}
                        </h3>
                        <p class="mt-1 text-xs text-slate-400">
                            Akumulasi harga jasa aktif
                        </p>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <Wallet :size="21" />
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Potensi Keuntungan</p>
                        <h3 class="mt-2 text-xl font-bold text-emerald-700">
                            {{ rupiah(statistik.potensiKeuntungan) }}
                        </h3>
                        <p class="mt-1 text-xs text-slate-400">
                            Harga dikurangi modal
                        </p>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <TrendingUp :size="21" />
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Rata-rata Harga</p>
                        <h3 class="mt-2 text-xl font-bold text-slate-800">
                            {{ rupiah(statistik.rataHarga) }}
                        </h3>
                        <p class="mt-1 text-xs text-slate-400">
                            Per jenis jasa aktif
                        </p>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <Tags :size="21" />
                    </div>
                </div>
            </div>

        </div>

        <!-- DETAIL RINGKASAN -->
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">

            <!-- JASA HARGA TERTINGGI -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5">

                <div class="mb-5">
                    <h3 class="text-base font-semibold text-slate-800">
                        Jasa dengan Harga Tertinggi
                    </h3>
                    <p class="mt-1 text-xs text-slate-500">
                        Lima jasa dengan harga standar paling tinggi
                    </p>
                </div>

                <div v-if="jasaTermahal.length" class="space-y-4">

                    <div
                        v-for="(item, index) in jasaTermahal"
                        :key="item.id"
                        class="flex items-center justify-between gap-3"
                    >
                        <div class="flex min-w-0 items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-sm font-semibold text-emerald-700">
                                {{ index + 1 }}
                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-800">
                                    {{ item.nama }}
                                </p>
                                <p class="mt-0.5 text-xs text-slate-400">
                                    {{ item.kode_jasa || 'Tanpa kode' }}
                                </p>
                            </div>
                        </div>

                        <p class="shrink-0 text-sm font-semibold text-slate-700">
                            {{ rupiah(item.harga_standar) }}
                        </p>
                    </div>

                </div>

                <div v-else class="py-10 text-center text-sm text-slate-400">
                    Belum ada data jasa aktif.
                </div>

            </div>

            <!-- KEUNTUNGAN TERBESAR -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5">

                <div class="mb-5">
                    <h3 class="text-base font-semibold text-slate-800">
                        Potensi Keuntungan Terbesar
                    </h3>
                    <p class="mt-1 text-xs text-slate-500">
                        Berdasarkan selisih harga standar dan modal
                    </p>
                </div>

                <div v-if="jasaTerbesarKeuntungan.length" class="space-y-4">

                    <div
                        v-for="(item, index) in jasaTerbesarKeuntungan"
                        :key="item.id"
                        class="flex items-center justify-between gap-3"
                    >
                        <div class="flex min-w-0 items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-sm font-semibold text-emerald-700">
                                {{ index + 1 }}
                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-800">
                                    {{ item.nama }}
                                </p>
                                <p class="mt-0.5 text-xs text-slate-400">
                                    Modal {{ rupiah(item.modal) }}
                                </p>
                            </div>
                        </div>

                        <p class="shrink-0 text-sm font-semibold text-emerald-700">
                            {{ rupiah(Number(item.harga_standar || 0) - Number(item.modal || 0)) }}
                        </p>
                    </div>

                </div>

                <div v-else class="py-10 text-center text-sm text-slate-400">
                    Belum ada data jasa aktif.
                </div>

            </div>

        </div>

        <!-- INFORMASI ESTIMASI -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5">

            <div class="flex items-center gap-3">
                <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                    <Clock :size="21" />
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-700">
                        Total Estimasi Waktu
                    </p>
                    <p class="mt-1 text-xl font-bold text-slate-800">
                        {{ statistik.totalEstimasi }} menit
                    </p>
                    <p class="mt-1 text-xs text-slate-400">
                        Akumulasi estimasi waktu seluruh jasa aktif, bukan durasi aktual pengerjaan.
                    </p>
                </div>
            </div>

        </div>

    </div>
</template>

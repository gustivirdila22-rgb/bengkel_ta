
<script setup>
import { computed } from 'vue'
import { Trophy, Wrench, ClipboardList, Wallet } from 'lucide-vue-next'

const props = defineProps({
    jasaTerlaris: {
        type: Array,
        default: () => [],
    },
})

const daftarJasa = computed(() => {
    return [...props.jasaTerlaris]
        .sort((a, b) => (b.total_pengerjaan ?? 0) - (a.total_pengerjaan ?? 0))
        .slice(0, 5)
})

const formatRupiah = (angka) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka ?? 0)
}

const formatAngka = (angka) => {
    return new Intl.NumberFormat('id-ID').format(angka ?? 0)
}

const totalPengerjaan = computed(() => {
    return props.jasaTerlaris.reduce(
        (total, item) => total + Number(item.total_pengerjaan ?? 0),
        0,
    )
})

const totalPendapatan = computed(() => {
    return props.jasaTerlaris.reduce(
        (total, item) => total + Number(item.total_pendapatan ?? 0),
        0,
    )
})
</script>

<template>
    <div class="space-y-6">

        <!-- HEADER -->
        <div>
            <h3 class="text-lg font-semibold text-slate-900">
                Jasa Paling Laku
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Daftar jasa servis dengan jumlah pengerjaan terbanyak.
            </p>
        </div>

        <!-- RINGKASAN -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <ClipboardList :size="21" />
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">
                            Total Pengerjaan
                        </p>
                        <p class="mt-1 text-xl font-bold text-slate-900">
                            {{ formatAngka(totalPengerjaan) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                        <Wallet :size="21" />
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">
                            Total Pendapatan
                        </p>
                        <p class="mt-1 text-xl font-bold text-slate-900">
                            {{ formatRupiah(totalPendapatan) }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- DAFTAR JASA -->
        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div>
                    <h4 class="font-semibold text-slate-900">
                        Peringkat Jasa Servis
                    </h4>
                    <p class="mt-1 text-xs text-slate-500">
                        Berdasarkan jumlah pengerjaan.
                    </p>
                </div>

                <div class="rounded-xl bg-amber-50 p-2.5 text-amber-600">
                    <Trophy :size="20" />
                </div>
            </div>

            <div v-if="daftarJasa.length" class="divide-y divide-slate-100">

                <div
                    v-for="(jasa, index) in daftarJasa"
                    :key="jasa.id ?? jasa.kode_jasa ?? index"
                    class="flex items-center gap-4 px-6 py-5 transition hover:bg-slate-50"
                >
                    <!-- PERINGKAT -->
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-sm font-bold"
                        :class="[
                            index === 0
                                ? 'bg-amber-100 text-amber-700'
                                : index === 1
                                    ? 'bg-slate-200 text-slate-600'
                                    : index === 2
                                        ? 'bg-orange-100 text-orange-700'
                                        : 'bg-slate-100 text-slate-500'
                        ]"
                    >
                        {{ String(index + 1).padStart(2, '0') }}
                    </div>

                    <!-- INFORMASI JASA -->
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-slate-800">
                            {{ jasa.nama }}
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            {{ jasa.kode_jasa || 'Jasa Servis' }}
                        </p>
                    </div>

                    <!-- JUMLAH PENGERJAAN -->
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-800">
                            {{ formatAngka(jasa.total_pengerjaan) }}x
                        </p>
                        <p class="mt-1 text-xs text-slate-400">
                            Pengerjaan
                        </p>
                    </div>

                    <!-- PENDAPATAN -->
                    <div class="hidden min-w-32 text-right sm:block">
                        <p class="text-sm font-semibold text-emerald-600">
                            {{ formatRupiah(jasa.total_pendapatan) }}
                        </p>
                        <p class="mt-1 text-xs text-slate-400">
                            Pendapatan
                        </p>
                    </div>
                </div>

            </div>

            <!-- EMPTY STATE -->
            <div v-else class="flex flex-col items-center px-6 py-14 text-center">
                <div class="mb-4 rounded-2xl bg-slate-100 p-4 text-slate-400">
                    <Wrench :size="28" />
                </div>

                <h4 class="font-semibold text-slate-800">
                    Belum Ada Data Pengerjaan
                </h4>

                <p class="mt-2 max-w-sm text-sm leading-relaxed text-slate-500">
                    Data jasa paling laku akan muncul setelah transaksi servis
                    tercatat dan terhubung dengan jasa servis.
                </p>
            </div>

        </div>
    </div>
</template>

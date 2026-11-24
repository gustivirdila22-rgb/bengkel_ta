
<script setup>
import { computed, ref } from 'vue'
import { Users, CarFront, Wrench, Wallet, TrendingUp } from 'lucide-vue-next'

const periode = ref('Bulan ini')

const statistik = [
    { label: 'Total pelanggan', nilai: '46', keterangan: 'Pelanggan terdaftar', icon: Users },
    { label: 'Total kendaraan', nilai: '49', keterangan: 'Kendaraan terdaftar', icon: CarFront },
    { label: 'Total servis', nilai: '128', keterangan: 'Transaksi servis', icon: Wrench },
    { label: 'Total transaksi', nilai: 'Rp 18,5 jt', keterangan: 'Nilai transaksi', icon: Wallet },
]

const pelangganTeratas = [
    { nama: 'Agung Nugroho', kendaraan: 'B 3344 EFG', servis: 13, transaksi: 'Rp 3.250.000' },
    { nama: 'Anita Rahmawati', kendaraan: 'B 3366 XYZ', servis: 12, transaksi: 'Rp 2.850.000' },
    { nama: 'Maya Puspita', kendaraan: 'B 1122 BCD', servis: 9, transaksi: 'Rp 2.100.000' },
    { nama: 'Ahmad Fauzi', kendaraan: 'B 9012 GHI', servis: 7, transaksi: 'Rp 1.750.000' },
]

const sumberPelanggan = [
    { label: 'Pelanggan baru', jumlah: 12, persen: 26 },
    { label: 'Pelanggan kembali', jumlah: 34, persen: 74 },
]
</script>

<template>
    <div class="space-y-5">

        <div class="flex justify-end">
            <select
                v-model="periode"
                class="rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-emerald-500"
            >
                <option>Bulan ini</option>
                <option>Bulan lalu</option>
                <option>Tahun ini</option>
            </select>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div
                v-for="item in statistik"
                :key="item.label"
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
            >
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-500">{{ item.label }}</p>
                    <div class="rounded-xl bg-emerald-50 p-2.5 text-emerald-600">
                        <component :is="item.icon" :size="19" />
                    </div>
                </div>

                <p class="mt-4 text-xl font-bold text-slate-800">
                    {{ item.nilai }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    {{ item.keterangan }}
                </p>
            </div>
        </div>

        <div class="grid gap-5 xl:grid-cols-2">

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-800">
                    Komposisi pelanggan
                </h2>

                <div class="mt-5 space-y-5">
                    <div v-for="item in sumberPelanggan" :key="item.label">
                        <div class="mb-2 flex justify-between">
                            <span class="text-sm text-slate-600">{{ item.label }}</span>
                            <span class="text-sm font-semibold text-slate-800">
                                {{ item.jumlah }} pelanggan
                            </span>
                        </div>

                        <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                            <div
                                class="h-full rounded-full bg-emerald-500"
                                :style="{ width: item.persen + '%' }"
                            />
                        </div>
                    </div>
                </div>

                <div class="mt-6 rounded-xl bg-emerald-50 p-4">
                    <div class="flex items-center gap-2 text-emerald-700">
                        <TrendingUp :size="18" />
                        <span class="text-sm font-semibold">
                            Pelanggan kembali mendominasi
                        </span>
                    </div>
                    <p class="mt-1 text-sm text-emerald-700">
                        74% pelanggan sudah pernah melakukan servis sebelumnya.
                    </p>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="mb-4 text-sm font-semibold text-slate-800">
                    Pelanggan paling aktif
                </h2>

                <div class="divide-y divide-slate-100">
                    <div
                        v-for="(item, index) in pelangganTeratas"
                        :key="item.nama"
                        class="flex items-center justify-between gap-3 py-3"
                    >
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-sm font-semibold text-slate-600">
                                {{ index + 1 }}
                            </span>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-800">
                                    {{ item.nama }}
                                </p>
                                <p class="text-xs text-slate-400">
                                    {{ item.kendaraan }} · {{ item.servis }} kali servis
                                </p>
                            </div>
                        </div>

                        <span class="shrink-0 text-sm font-medium text-slate-700">
                            {{ item.transaksi }}
                        </span>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

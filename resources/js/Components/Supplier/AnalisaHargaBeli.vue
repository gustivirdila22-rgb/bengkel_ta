
<script setup>
import { ref, computed } from 'vue'
import { Search } from 'lucide-vue-next'

const cari = ref('')

const dataAnalisa = ref([
    {
        kode: 'BRG-000076',
        nama: 'Timing Belt',
        jumlahSupplier: 2,
        termurah: 120000,
        supplierTermurah: 'Agen Oli Makmur Sentosa',
        termahal: 120000,
        supplierTermahal: 'Agen Oli Makmur Sentosa',
        terakhir: 120000,
        supplierTerakhir: 'Agen Oli Makmur Sentosa',
        tanggal: '30 Oktober 2026',
    },
])

const formatRupiah = (angka) =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka)

const dataTerfilter = computed(() =>
    dataAnalisa.value.filter(item =>
        `${item.nama} ${item.kode}`.toLowerCase().includes(cari.value.toLowerCase())
    )
)
</script>

<template>
    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="relative mb-6 max-w-sm">
            <Search class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" :size="18" />
            <input
                v-model="cari"
                type="text"
                placeholder="Cari sparepart atau supplier..."
                class="w-full rounded-xl border border-slate-200 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
            />
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1000px] text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-500">
                        <th class="px-4 py-4 text-left font-medium">Sparepart</th>
                        <th class="px-4 py-4 text-right font-medium">Termurah</th>
                        <th class="px-4 py-4 text-right font-medium">Termahal</th>
                        <th class="px-4 py-4 text-center font-medium">Selisih</th>
                        <th class="px-4 py-4 text-right font-medium">Terakhir beli</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="item in dataTerfilter"
                        :key="item.kode"
                        class="border-b border-slate-100 hover:bg-slate-50/70"
                    >
                        <td class="px-4 py-6">
                            <p class="font-medium text-slate-800">{{ item.nama }}</p>
                            <p class="mt-1 text-xs text-slate-400">
                                {{ item.kode }} · {{ item.jumlahSupplier }} supplier
                            </p>
                        </td>

                        <td class="px-4 py-6 text-right">
                            <p class="font-semibold text-emerald-600">{{ formatRupiah(item.termurah) }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ item.supplierTermurah }}</p>
                        </td>

                        <td class="px-4 py-6 text-right">
                            <p class="font-semibold text-red-500">{{ formatRupiah(item.termahal) }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ item.supplierTermahal }}</p>
                        </td>

                        <td class="px-4 py-6 text-center">
                            <p class="font-semibold text-slate-800">{{ formatRupiah(item.termahal - item.termurah) }}</p>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ item.termurah ? ((item.termahal - item.termurah) / item.termurah * 100).toFixed(1) : 0 }}%
                            </p>
                        </td>

                        <td class="px-4 py-6 text-right">
                            <p class="font-medium text-slate-700">{{ formatRupiah(item.terakhir) }}</p>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ item.supplierTerakhir }} · {{ item.tanggal }}
                            </p>
                            <span class="mt-2 inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
                                ● Sudah termurah
                            </span>
                        </td>
                    </tr>

                    <tr v-if="dataTerfilter.length === 0">
                        <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                            Data tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-5 flex flex-wrap items-center justify-between gap-3 text-sm text-slate-500">
            <span>Menampilkan 1–{{ dataTerfilter.length }} dari {{ dataTerfilter.length }} data</span>
            <span class="rounded-lg bg-slate-50 px-3 py-2">Halaman 1</span>
        </div>
    </div>
</template>

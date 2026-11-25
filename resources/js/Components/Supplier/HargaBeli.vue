
<script setup>
import { ref, computed } from 'vue'
import { Search } from 'lucide-vue-next'

const cari = ref('')

const dataHarga = ref([
    { kode: 'BRG-D048', nama: 'Aki GS Astra NS60 45Ah', supplier: 'Agen Oli Makmur Sentosa', harga: 817500, perubahan: 6.6, tanggal: '29 Agustus 2026' },
    { kode: 'BRG-D049', nama: 'Aki Incoe N50 50Ah', supplier: 'Agen Oli Makmur Sentosa', harga: 693500, perubahan: -2.3, tanggal: '12 September 2026' },
    { kode: 'BRG-D050', nama: 'Alternator / dinamo ampere Avanza', supplier: 'Agen Oli Makmur Sentosa', harga: 1278500, perubahan: 0.7, tanggal: '07 September 2026' },
    { kode: 'BRG-D068', nama: 'Amplas halus lembar', supplier: 'Agen Oli Makmur Sentosa', harga: 6000, perubahan: 0, tanggal: '27 Juli 2026' },
    { kode: 'BRG-D029', nama: 'Ball joint bawah Avanza', supplier: 'Toko Sparepart Jaya Motor', harga: 166500, perubahan: 1.2, tanggal: '02 September 2026' },
])

const formatRupiah = (angka) =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka)

const dataTerfilter = computed(() =>
    dataHarga.value.filter(item =>
        `${item.nama} ${item.kode} ${item.supplier}`.toLowerCase().includes(cari.value.toLowerCase())
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
            <table class="w-full min-w-[850px] text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-500">
                        <th class="px-4 py-4 text-left font-medium">Sparepart</th>
                        <th class="px-4 py-4 text-left font-medium">Supplier</th>
                        <th class="px-4 py-4 text-right font-medium">Harga beli terakhir</th>
                        <th class="px-4 py-4 text-center font-medium">Dibanding sebelumnya</th>
                        <th class="px-4 py-4 text-left font-medium">Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="item in dataTerfilter"
                        :key="item.kode"
                        class="border-b border-slate-100 hover:bg-slate-50/70"
                    >
                        <td class="px-4 py-5">
                            <p class="font-medium text-slate-800">{{ item.nama }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ item.kode }}</p>
                        </td>
                        <td class="max-w-[210px] px-4 py-5 text-slate-600">{{ item.supplier }}</td>
                        <td class="whitespace-nowrap px-4 py-5 text-right font-medium text-slate-700">{{ formatRupiah(item.harga) }}</td>
                        <td class="whitespace-nowrap px-4 py-5 text-center">
                            <span v-if="item.perubahan > 0" class="font-medium text-red-500">↑ {{ item.perubahan }}%</span>
                            <span v-else-if="item.perubahan < 0" class="font-medium text-emerald-600">↓ {{ Math.abs(item.perubahan) }}%</span>
                            <span v-else class="text-slate-400">—</span>
                        </td>
                        <td class="whitespace-nowrap px-4 py-5 text-slate-600">{{ item.tanggal }}</td>
                    </tr>

                    <tr v-if="dataTerfilter.length === 0">
                        <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                            Data tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

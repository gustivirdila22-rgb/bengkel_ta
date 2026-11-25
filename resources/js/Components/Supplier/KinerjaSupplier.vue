
<script setup>
import { ref, computed } from 'vue'
import { Search, Info } from 'lucide-vue-next'

const cari = ref('')

const suppliers = ref([
    { kode: 'SUP-D02', nama: 'Agen Oli Makmur Sentosa', pembelian: 11, total: 44476500, lama: '—', menunggu: 0, utang: 45984500 },
    { kode: 'SUP-D04', nama: 'Elektrik Mobil Nusantara', pembelian: 8, total: 28953000, lama: '—', menunggu: 0, utang: 40044000 },
    { kode: 'SUP-D01', nama: 'Toko Sparepart Jaya Motor', pembelian: 8, total: 26109000, lama: '—', menunggu: 0, utang: 18959500 },
    { kode: 'SUP-D03', nama: 'Sumber Rem & Kaki-kaki', pembelian: 5, total: 4735000, lama: '—', menunggu: 0, utang: 1770000 },
    { kode: 'SUP-D05', nama: 'Grosir Aksesoris Otomotif', pembelian: 4, total: 1627000, lama: '—', menunggu: 0, utang: 195000 },
])

const formatRupiah = (angka) =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka)

const dataTerfilter = computed(() =>
    suppliers.value.filter(item =>
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
                placeholder="Cari nama atau kode supplier..."
                class="w-full rounded-xl border border-slate-200 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
            />
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-500">
                        <th class="px-4 py-4 text-left font-medium">Supplier</th>
                        <th class="px-4 py-4 text-center font-medium">Pembelian</th>
                        <th class="px-4 py-4 text-right font-medium">Total belanja</th>
                        <th class="px-4 py-4 text-center font-medium">Lama datang</th>
                        <th class="px-4 py-4 text-center font-medium">Pesanan menunggu</th>
                        <th class="px-4 py-4 text-center font-medium"><Info :size="15" class="inline" /></th>
                        <th class="px-4 py-4 text-right font-medium">Sisa utang</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="item in dataTerfilter"
                        :key="item.kode"
                        class="border-b border-slate-100 transition hover:bg-slate-50/70"
                    >
                        <td class="px-4 py-5">
                            <p class="font-medium text-slate-800">{{ item.nama }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ item.kode }}</p>
                        </td>
                        <td class="px-4 py-5 text-center text-slate-600">{{ item.pembelian }}</td>
                        <td class="px-4 py-5 text-right font-medium text-slate-700">{{ formatRupiah(item.total) }}</td>
                        <td class="px-4 py-5 text-center text-slate-500">{{ item.lama }}</td>
                        <td class="px-4 py-5 text-center text-slate-600">{{ item.menunggu }}</td>
                        <td class="px-4 py-5 text-center text-slate-400"> </td>
                        <td class="px-4 py-5 text-right font-medium text-slate-700">{{ formatRupiah(item.utang) }}</td>
                    </tr>

                    <tr v-if="dataTerfilter.length === 0">
                        <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                            Supplier tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

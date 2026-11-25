
<script setup>
import { ref, computed } from 'vue'

const search = ref('')
const currentPage = ref(1)
const perPage = ref(20)

const dataKinerja = ref([
    {
        nama: 'Cecep Hasanudin',
        kode: 'KRY-000001',
        servisSelesai: 5,
        nilaiJasa: 400000,
        jamKerja: '4 jam',
        sedangDikerjakan: 1
    }
])

const filteredData = computed(() => {
    return dataKinerja.value.filter(item =>
        item.nama.toLowerCase().includes(search.value.toLowerCase()) ||
        item.kode.toLowerCase().includes(search.value.toLowerCase())
    )
})

const formatRupiah = (angka) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    }).format(angka)
}
</script>

<template>
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <!-- Search -->
        <div class="mb-6">
            <div class="relative w-full sm:w-[352px]">
                <span class="absolute left-3 top-2.5 text-slate-400">
                    ⌕
                </span>

                <input
                    v-model="search"
                    type="text"
                    placeholder="Cari nama mekanik..."
                    class="w-full rounded-lg border border-slate-200 py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-green-500 focus:ring-1 focus:ring-green-500"
                />
            </div>
        </div>

        <!-- Tabel Kinerja -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-xs text-slate-500">
                        <th class="px-4 py-4 font-medium">
                            Mekanik
                        </th>

                        <th class="px-4 py-4 text-center font-medium">
                            <span class="inline-flex items-center gap-1">
                                <span class="text-green-600">↕</span>
                                Servis selesai
                            </span>
                        </th>

                        <th class="px-4 py-4 text-center font-medium">
                            Nilai jasa
                        </th>

                        <th class="px-4 py-4 text-center font-medium">
                            Jam kerja
                        </th>

                        <th class="px-4 py-4 text-center font-medium">
                            Sedang dikerjakan
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="item in filteredData"
                        :key="item.kode"
                        class="border-b border-slate-100 transition hover:bg-slate-50"
                    >
                        <td class="px-4 py-5">
                            <p class="font-medium text-slate-900">
                                {{ item.nama }}
                            </p>

                            <p class="text-xs text-slate-500">
                                {{ item.kode }}
                            </p>
                        </td>

                        <td class="px-4 py-5 text-center text-slate-700">
                            {{ item.servisSelesai }}
                        </td>

                        <td class="px-4 py-5 text-center text-slate-700">
                            {{ formatRupiah(item.nilaiJasa) }}
                        </td>

                        <td class="px-4 py-5 text-center text-slate-700">
                            {{ item.jamKerja }}
                        </td>

                        <td class="px-4 py-5 text-center text-slate-700">
                            {{ item.sedangDikerjakan }}
                        </td>
                    </tr>

                    <tr v-if="filteredData.length === 0">
                        <td
                            colspan="5"
                            class="py-10 text-center text-slate-400"
                        >
                            Data mekanik tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-5 flex flex-wrap items-center justify-between gap-3 text-sm text-slate-500">

            <div class="flex flex-wrap items-center gap-2">
                <span>Tampilkan</span>

                <select
                    v-model="perPage"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 outline-none focus:border-green-500"
                >
                    <option :value="20">20</option>
                    <option :value="50">50</option>
                    <option :value="100">100</option>
                </select>

                <span>per halaman</span>
                <span>·</span>

                <span>
                    Menampilkan {{ filteredData.length ? 1 : 0 }}–{{ filteredData.length }}
                    dari {{ filteredData.length }} data
                </span>
            </div>

            <div class="flex items-center gap-2">
                <button
                    disabled
                    class="rounded-lg border border-slate-200 px-3 py-2 opacity-50"
                >
                    ‹
                </button>

                <button
                    class="rounded-lg bg-green-600 px-4 py-2 font-medium text-white"
                >
                    {{ currentPage }}
                </button>

                <button
                    disabled
                    class="rounded-lg border border-slate-200 px-3 py-2 opacity-50"
                >
                    ›
                </button>
            </div>

        </div>
    </div>
</template>

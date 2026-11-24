
<script setup>
import { ref, computed } from 'vue'
import { Search, Info, AlertCircle } from 'lucide-vue-next'

const activeSubTab = ref('belum-lunas')
const search = ref('')

const tagihan = ref([
    { id: 1, nota: 'TG-000378', pelanggan: 'Hendra Gunawan', tanggal: '10 September 2026', umur: 75, total: 2480000, dibayar: 0 },
    { id: 2, nota: 'TG-000379', pelanggan: 'Maya Puspita', tanggal: '10 September 2026', umur: 75, total: 1450000, dibayar: 0 },
    { id: 3, nota: 'TG-000403', pelanggan: 'Pramana Setiawan', tanggal: '27 Oktober 2026', umur: 28, total: 1380000, dibayar: 0 },
])

const uangMuka = ref([
    { id: 1, nota: 'DP-000021', pelanggan: 'Agung Nugroho', tanggal: '17 November 2026', jumlah: 500000, status: 'Digunakan' },
    { id: 2, nota: 'DP-000022', pelanggan: 'Ahmad Fauzi', tanggal: '18 November 2026', jumlah: 350000, status: 'Tersedia' },
    { id: 3, nota: 'DP-000023', pelanggan: 'Anita Rahmawati', tanggal: '19 November 2026', jumlah: 750000, status: 'Tersedia' },
])

const formatRupiah = (angka) =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka)

const totalBelumDibayar = computed(() =>
    tagihan.value.reduce((total, item) => total + item.total - item.dibayar, 0)
)

const totalTerlambat = computed(() =>
    tagihan.value.filter(item => item.umur > 30).length
)

const filteredTagihan = computed(() => {
    const keyword = search.value.toLowerCase()

    return tagihan.value.filter(item =>
        item.nota.toLowerCase().includes(keyword) ||
        item.pelanggan.toLowerCase().includes(keyword)
    )
})

const filteredDp = computed(() => {
    const keyword = search.value.toLowerCase()

    return uangMuka.value.filter(item =>
        item.nota.toLowerCase().includes(keyword) ||
        item.pelanggan.toLowerCase().includes(keyword)
    )
})
</script>

<template>
    <div class="space-y-4">

        <!-- SUMMARY -->
        <div class="flex flex-wrap gap-2">
            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="text-sm font-bold text-slate-800">
                    {{ formatRupiah(totalBelumDibayar) }}
                </span>
                <span class="ml-2 text-sm text-slate-500">belum dibayar</span>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="text-sm font-bold text-slate-800">
                    {{ tagihan.length }}
                </span>
                <span class="ml-2 text-sm text-slate-500">nota</span>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="mr-2 inline-block h-2.5 w-2.5 rounded-full bg-amber-500" />
                <span class="text-sm font-bold text-slate-800">
                    {{ totalTerlambat }}
                </span>
                <span class="ml-1 text-sm text-slate-500">lebih dari 30 hari</span>
            </div>
        </div>

        <!-- SUB TABS -->
        <div class="inline-flex rounded-xl bg-slate-100 p-1">
            <button
                type="button"
                @click="activeSubTab = 'belum-lunas'; search = ''"
                class="rounded-lg px-4 py-2 text-sm font-medium transition"
                :class="activeSubTab === 'belum-lunas'
                    ? 'bg-white text-emerald-700 shadow-sm'
                    : 'text-slate-500 hover:text-slate-800'"
            >
                Nota Belum Lunas
                <Info class="ml-1 inline" :size="14" />
            </button>

            <button
                type="button"
                @click="activeSubTab = 'dp'; search = ''"
                class="rounded-lg px-4 py-2 text-sm font-medium transition"
                :class="activeSubTab === 'dp'
                    ? 'bg-white text-emerald-700 shadow-sm'
                    : 'text-slate-500 hover:text-slate-800'"
            >
                Uang Muka (DP)
            </button>
        </div>

        <!-- TABLE -->
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="relative mb-5 w-full max-w-md">
                <Search :size="17" class="absolute left-3 top-3 text-slate-400" />

                <input
                    v-model="search"
                    placeholder="Cari nomor nota atau nama pelanggan..."
                    class="w-full rounded-xl border border-slate-200 py-2.5 pl-10 pr-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                />
            </div>

            <!-- NOTA BELUM LUNAS -->
            <div v-if="activeSubTab === 'belum-lunas'" class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left">
                    <thead>
                        <tr class="border-b border-slate-200 text-sm text-slate-500">
                            <th class="px-3 py-3 font-medium">Nota</th>
                            <th class="px-3 py-3 font-medium">Pelanggan</th>
                            <th class="px-3 py-3 font-medium">Tanggal</th>
                            <th class="px-3 py-3 text-center font-medium">Umur Tagihan</th>
                            <th class="px-3 py-3 text-right font-medium">Total nota</th>
                            <th class="px-3 py-3 text-right font-medium">Belum dibayar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="item in filteredTagihan"
                            :key="item.id"
                            class="border-b border-slate-100 hover:bg-slate-50"
                        >
                            <td class="px-3 py-5 text-sm font-medium text-emerald-700">
                                {{ item.nota }}
                            </td>

                            <td class="px-3 py-5 text-sm text-slate-700">
                                {{ item.pelanggan }}
                            </td>

                            <td class="px-3 py-5 text-sm text-slate-600">
                                {{ item.tanggal }}
                            </td>

                            <td class="px-3 py-5 text-center">
                                <span
                                    class="text-sm"
                                    :class="item.umur > 30 ? 'font-medium text-red-600' : 'text-slate-600'"
                                >
                                    {{ item.umur }} hari
                                    <span v-if="item.umur > 30" class="block text-xs">
                                        (terlambat)
                                    </span>
                                </span>
                            </td>

                            <td class="px-3 py-5 text-right text-sm text-slate-700">
                                {{ formatRupiah(item.total) }}
                            </td>

                            <td class="px-3 py-5 text-right text-sm font-medium text-slate-800">
                                {{ formatRupiah(item.total - item.dibayar) }}
                            </td>
                        </tr>

                        <tr v-if="filteredTagihan.length === 0">
                            <td colspan="6" class="py-12 text-center text-sm text-slate-500">
                                Tagihan tidak ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- UANG MUKA -->
            <div v-else class="overflow-x-auto">
                <table class="w-full min-w-[650px] text-left">
                    <thead>
                        <tr class="border-b border-slate-200 text-sm text-slate-500">
                            <th class="px-3 py-3 font-medium">Nomor DP</th>
                            <th class="px-3 py-3 font-medium">Pelanggan</th>
                            <th class="px-3 py-3 font-medium">Tanggal</th>
                            <th class="px-3 py-3 text-right font-medium">Jumlah DP</th>
                            <th class="px-3 py-3 text-center font-medium">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="item in filteredDp"
                            :key="item.id"
                            class="border-b border-slate-100 hover:bg-slate-50"
                        >
                            <td class="px-3 py-5 text-sm font-medium text-emerald-700">
                                {{ item.nota }}
                            </td>

                            <td class="px-3 py-5 text-sm text-slate-700">
                                {{ item.pelanggan }}
                            </td>

                            <td class="px-3 py-5 text-sm text-slate-600">
                                {{ item.tanggal }}
                            </td>

                            <td class="px-3 py-5 text-right text-sm font-medium text-slate-800">
                                {{ formatRupiah(item.jumlah) }}
                            </td>

                            <td class="px-3 py-5 text-center">
                                <span
                                    class="rounded-full px-3 py-1 text-xs font-medium"
                                    :class="item.status === 'Tersedia'
                                        ? 'bg-emerald-50 text-emerald-700'
                                        : 'bg-slate-100 text-slate-600'"
                                >
                                    {{ item.status }}
                                </span>
                            </td>
                        </tr>

                        <tr v-if="filteredDp.length === 0">
                            <td colspan="5" class="py-12 text-center text-sm text-slate-500">
                                Data uang muka tidak ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>

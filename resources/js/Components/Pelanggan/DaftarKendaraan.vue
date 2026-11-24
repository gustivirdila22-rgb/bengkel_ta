<script setup>
import { ref, computed } from 'vue'
import { Search, CarFront } from 'lucide-vue-next'

const props = defineProps({
    kendaraans: {
        type: Array,
        default: () => [],
    },
})

const search = ref('')
const currentPage = ref(1)
const perPage = ref(10)

const filteredData = computed(() => {
    const keyword = search.value.toLowerCase().trim()

    return props.kendaraans.filter(item => {
        const pemilik = item.pelanggan?.nama ?? ''

        const kendaraan = [
            item.nomor_polisi,
            item.merek,
            item.tipe,
            item.tahun,
            item.warna,
            pemilik,
        ]

        return kendaraan.some(value =>
            String(value ?? '').toLowerCase().includes(keyword)
        )
    })
})

const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredData.value.length / perPage.value))
)

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value

    return filteredData.value.slice(start, start + perPage.value)
})

const formatDetailKendaraan = (item) => {
    return [
        item.merek,
        item.tipe,
        item.tahun,
        item.warna,
    ].filter(value => value).join(' · ') || 'Detail kendaraan belum tersedia'
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <!-- SEARCH -->
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
            <div class="relative w-full max-w-md">
                <Search
                    :size="17"
                    class="absolute left-3 top-3 text-slate-400"
                />

                <input
                    v-model="search"
                    @input="currentPage = 1"
                    placeholder="Cari nomor polisi, kendaraan, atau pemilik..."
                    class="w-full rounded-xl border border-slate-200 py-2.5 pl-10 pr-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                />
            </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-sm text-slate-500">
                        <th class="px-3 py-3 font-medium">Kendaraan</th>
                        <th class="px-3 py-3 font-medium">Pemilik</th>
                        <th class="px-3 py-3 font-medium">Catatan</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="item in paginatedData"
                        :key="item.id"
                        class="border-b border-slate-100 transition hover:bg-slate-50"
                    >
                        <!-- KENDARAAN -->
                        <td class="px-3 py-4">
                            <p class="text-sm font-semibold text-slate-800">
                                {{ item.nomor_polisi }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                {{ formatDetailKendaraan(item) }}
                            </p>
                        </td>

                        <!-- PEMILIK -->
                        <td class="px-3 py-4">
                            <p class="text-sm font-medium text-emerald-700">
                                {{ item.pelanggan?.nama ?? 'Pelanggan tidak ditemukan' }}
                            </p>
                        </td>

                        <!-- CATATAN -->
                        <td class="px-3 py-4">
                            <p
                                class="max-w-xs truncate text-sm text-slate-600"
                                :title="item.catatan"
                            >
                                {{ item.catatan || '-' }}
                            </p>
                        </td>
                    </tr>

                    <!-- EMPTY STATE -->
                    <tr v-if="paginatedData.length === 0">
                        <td colspan="3" class="py-12 text-center">
                            <CarFront
                                class="mx-auto mb-2 text-slate-300"
                                :size="30"
                            />

                            <p class="text-sm font-medium text-slate-600">
                                {{ search
                                    ? 'Kendaraan tidak ditemukan'
                                    : 'Belum ada data kendaraan'
                                }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Data kendaraan yang ditambahkan akan muncul di sini.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <span>Tampilkan</span>

                <select
                    v-model.number="perPage"
                    @change="currentPage = 1"
                    class="rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm"
                >
                    <option :value="10">10</option>
                    <option :value="20">20</option>
                    <option :value="50">50</option>
                </select>

                <span>
                    per halaman · Menampilkan
                    {{ filteredData.length
                        ? (currentPage - 1) * perPage + 1
                        : 0
                    }}–{{ Math.min(currentPage * perPage, filteredData.length) }}
                    dari {{ filteredData.length }} data
                </span>
            </div>

            <div class="flex items-center gap-1">
                <button
                    type="button"
                    @click="currentPage = Math.max(1, currentPage - 1)"
                    :disabled="currentPage === 1"
                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm disabled:opacity-40"
                >
                    ‹
                </button>

                <button
                    v-for="page in totalPages"
                    :key="page"
                    type="button"
                    @click="currentPage = page"
                    class="h-9 min-w-9 rounded-lg border px-3 text-sm"
                    :class="currentPage === page
                        ? 'border-emerald-600 bg-emerald-600 text-white'
                        : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                >
                    {{ page }}
                </button>

                <button
                    type="button"
                    @click="currentPage = Math.min(totalPages, currentPage + 1)"
                    :disabled="currentPage === totalPages"
                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm disabled:opacity-40"
                >
                    ›
                </button>
            </div>
        </div>
    </section>
</template>
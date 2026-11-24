
<script setup>
import { ref, computed } from 'vue'
import {
    Search,
    Plus,
    Pencil,
    Trash2,
    Tags,
    Wrench,
    CircleCheck,
    CircleX,
} from 'lucide-vue-next'

const props = defineProps({
    kategoriJasa: {
        type: Array,
        default: () => [],
    },
    jasaServis: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits([
    'tambah',
    'edit',
    'hapus',
])

const pencarian = ref('')

const kategoriTerfilter = computed(() => {
    const keyword = pencarian.value.toLowerCase().trim()

    if (!keyword) return props.kategoriJasa

    return props.kategoriJasa.filter(kategori =>
        kategori.nama?.toLowerCase().includes(keyword) ||
        kategori.kode_kategori?.toLowerCase().includes(keyword)
    )
})

const jumlahJasa = (kategoriId) => {
    return props.jasaServis.filter(
        jasa => Number(jasa.kategori_id) === Number(kategoriId)
    ).length
}
</script>

<template>
    <div class="space-y-5">

        <!-- RINGKASAN -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Kategori</p>
                        <p class="mt-2 text-2xl font-bold text-slate-800">
                            {{ kategoriJasa.length }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <Tags :size="21" />
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Kategori Aktif</p>
                        <p class="mt-2 text-2xl font-bold text-emerald-700">
                            {{ kategoriJasa.filter(item => item.aktif).length }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <CircleCheck :size="21" />
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Jenis Jasa</p>
                        <p class="mt-2 text-2xl font-bold text-slate-800">
                            {{ jasaServis.length }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <Wrench :size="21" />
                    </div>
                </div>
            </div>

        </div>

        <!-- DAFTAR KATEGORI -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">

            <div class="flex flex-col justify-between gap-4 border-b border-slate-100 p-5 sm:flex-row sm:items-center">

                <div>
                    <h3 class="text-base font-semibold text-slate-800">
                        Daftar Kategori Jasa
                    </h3>
                    <p class="mt-1 text-xs text-slate-500">
                        Kelola pengelompokan pekerjaan servis bengkel.
                    </p>
                </div>

                <button
                    type="button"
                    @click="emit('tambah')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                >
                    <Plus :size="17" />
                    Tambah Kategori
                </button>

            </div>

            <!-- PENCARIAN -->
            <div class="border-b border-slate-100 p-5">
                <div class="relative max-w-sm">
                    <Search
                        :size="17"
                        class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"
                    />

                    <input
                        v-model="pencarian"
                        type="text"
                        placeholder="Cari kategori..."
                        class="w-full rounded-xl border border-slate-200 py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    />
                </div>
            </div>

            <!-- TABEL -->
            <div class="overflow-x-auto">

                <table class="w-full min-w-[700px] text-left">

                    <thead class="bg-slate-50">
                        <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-4">Kategori</th>
                            <th class="px-5 py-4">Kode</th>
                            <th class="px-5 py-4 text-center">Jumlah Jasa</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        <tr
                            v-for="kategori in kategoriTerfilter"
                            :key="kategori.id"
                            class="transition hover:bg-slate-50/70"
                        >
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                        <Tags :size="19" />
                                    </div>

                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">
                                            {{ kategori.nama }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-400">
                                            {{ kategori.keterangan || 'Tidak ada keterangan' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                    {{ kategori.kode_kategori || '-' }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                    <Wrench :size="14" class="text-slate-400" />
                                    {{ jumlahJasa(kategori.id) }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <span
                                    v-if="kategori.aktif"
                                    class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700"
                                >
                                    <CircleCheck :size="13" />
                                    Aktif
                                </span>

                                <span
                                    v-else
                                    class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-500"
                                >
                                    <CircleX :size="13" />
                                    Nonaktif
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    <button
                                        type="button"
                                        @click="emit('edit', kategori)"
                                        class="rounded-lg border border-slate-200 p-2 text-slate-500 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700"
                                        title="Edit kategori"
                                    >
                                        <Pencil :size="15" />
                                    </button>

                                    <button
                                        type="button"
                                        @click="emit('hapus', kategori)"
                                        class="rounded-lg border border-slate-200 p-2 text-slate-500 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600"
                                        title="Hapus kategori"
                                    >
                                        <Trash2 :size="15" />
                                    </button>

                                </div>
                            </td>
                        </tr>

                        <tr v-if="kategoriTerfilter.length === 0">
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                    <Tags :size="22" />
                                </div>

                                <p class="mt-3 text-sm font-medium text-slate-700">
                                    {{ pencarian ? 'Kategori tidak ditemukan' : 'Belum ada kategori jasa' }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ pencarian ? 'Coba kata kunci lainnya.' : 'Tambahkan kategori untuk mengelompokkan jasa servis.' }}
                                </p>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>

            <div class="border-t border-slate-100 px-5 py-3">
                <p class="text-xs text-slate-400">
                    Menampilkan {{ kategoriTerfilter.length }} dari {{ kategoriJasa.length }} kategori
                </p>
            </div>

        </div>

    </div>
</template>

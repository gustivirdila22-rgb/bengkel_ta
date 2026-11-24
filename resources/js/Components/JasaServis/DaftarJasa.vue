
<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import {
    Search,
    Plus,
    Pencil,
    Trash2,
    ChevronRight,
    FileDown,
    Info,
} from 'lucide-vue-next'

const props = defineProps({
    jasaServis: {
        type: Array,
        default: () => [],
    },
    kategoriJasa: {
        type: Array,
        default: () => [],
    },
})

const pencarian = ref('')
const filterStatus = ref('semua')
const menuTerbuka = ref(null)
const jasaAkanDihapus = ref(null)
const sedangMenghapus = ref(false)

const emit = defineEmits(['notify'])

// JUMLAH STATUS
const jumlahStatus = computed(() => ({
    semua: props.jasaServis.length,
    aktif: props.jasaServis.filter(item => item.aktif).length,
    nonaktif: props.jasaServis.filter(item => !item.aktif).length,
}))

// FILTER JASA
const jasaTerfilter = computed(() => {
    return props.jasaServis.filter(item => {
        const kata = pencarian.value.toLowerCase()

        const cocokCari =
            (item.nama || '').toLowerCase().includes(kata) ||
            (item.kode_jasa || '').toLowerCase().includes(kata) ||
            (item.kategori?.nama || '').toLowerCase().includes(kata)

        const cocokStatus =
            filterStatus.value === 'semua' ||
            (filterStatus.value === 'aktif' && item.aktif) ||
            (filterStatus.value === 'nonaktif' && !item.aktif)

        return cocokCari && cocokStatus
    })
})

// FORMAT RUPIAH
const rupiah = (angka) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka || 0)
}

// TAMBAH JASA
const tambahJasa = () => {
    router.visit('/jasa-servis/create')
}

// EDIT JASA
const editJasa = (item) => {
    router.visit(`/jasa-servis/${item.id}/edit`)
}

// HAPUS JASA
const mintaHapusJasa = (item) => {
    jasaAkanDihapus.value = item
}

const batalkanHapusJasa = () => {
    if (sedangMenghapus.value) return
    jasaAkanDihapus.value = null
}

const konfirmasiHapusJasa = () => {
    const item = jasaAkanDihapus.value

    if (!item || sedangMenghapus.value) return

    router.delete(`/jasa-servis/${item.id}`, {
        preserveScroll: true,
        onStart: () => {
            sedangMenghapus.value = true
        },
        onSuccess: () => {
            jasaAkanDihapus.value = null
        },
        onError: (errors) => {
            jasaAkanDihapus.value = null
            emit('notify', {
                type: 'error',
                message: errors.delete
                    ?? Object.values(errors).find(error => typeof error === 'string')
                    ?? 'Jasa servis gagal dihapus. Silakan coba lagi.',
            })
        },
        onFinish: () => {
            sedangMenghapus.value = false
        },
    })
}
</script>

<template>
    <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">

        <!-- TOOLBAR -->
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div class="relative w-full max-w-sm">
                <Search
                    :size="17"
                    class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                />

                <input
                    v-model="pencarian"
                    type="text"
                    placeholder="Cari nama jasa..."
                    class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                />
            </div>

            <div class="flex flex-wrap items-center gap-2">

                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                >
                    <FileDown :size="17" />
                    Dokumen
                </button>

                <button
                    type="button"
                    @click="tambahJasa"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                >
                    <Plus :size="18" />
                    Tambah Jasa Servis
                </button>

            </div>
        </div>

        <!-- FILTER STATUS -->
        <div class="mb-5 flex flex-wrap items-center gap-2">

            <button
                v-for="status in [
                    { id: 'semua', label: 'Semua' },
                    { id: 'aktif', label: 'Aktif' },
                    { id: 'nonaktif', label: 'Nonaktif' },
                ]"
                :key="status.id"
                type="button"
                @click="filterStatus = status.id"
                class="rounded-full border px-3.5 py-1.5 text-sm font-medium transition"
                :class="filterStatus === status.id
                    ? 'border-emerald-300 bg-emerald-50 text-emerald-700'
                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'"
            >
                {{ status.label }}
                <span class="ml-1">{{ jumlahStatus[status.id] }}</span>
            </button>

            <Info :size="15" class="text-slate-400" />

        </div>

        <!-- TABEL -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left">

                <thead>
                    <tr class="border-b border-slate-200 text-xs text-slate-500">
                        <th class="w-10 px-3 py-4"></th>
                        <th class="px-3 py-4 font-medium">Nama Jasa</th>
                        <th class="px-3 py-4 font-medium">Kategori</th>
                        <th class="px-3 py-4 font-medium">Modal</th>
                        <th class="px-3 py-4 font-medium">Harga Standar</th>
                        <th class="px-3 py-4 font-medium">Status</th>
                        <th class="px-3 py-4 text-right font-medium">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="item in jasaTerfilter"
                        :key="item.id"
                        class="border-b border-slate-100 transition hover:bg-slate-50/70"
                    >
                        <!-- DETAIL -->
                        <td class="px-3 py-5">
                            <button
                                type="button"
                                @click="menuTerbuka = menuTerbuka === item.id ? null : item.id"
                                class="rounded-lg p-1 text-slate-400 hover:bg-slate-100"
                            >
                                <ChevronRight
                                    :size="18"
                                    :class="menuTerbuka === item.id ? 'rotate-90' : ''"
                                    class="transition"
                                />
                            </button>
                        </td>

                        <!-- NAMA JASA -->
                        <td class="px-3 py-5">
                            <p class="text-sm font-medium text-slate-800">
                                {{ item.nama }}
                            </p>

                            <p class="mt-0.5 text-xs text-slate-500">
                                {{ item.kode_jasa }}
                            </p>

                            <div
                                v-if="menuTerbuka === item.id"
                                class="mt-3 rounded-xl bg-slate-50 p-3 text-xs text-slate-600"
                            >
                                <p>
                                    Estimasi:
                                    {{ item.estimasi_menit ? item.estimasi_menit + ' menit' : 'Belum ditentukan' }}
                                </p>

                                <p class="mt-1">
                                    Keterangan:
                                    {{ item.keterangan || 'Tidak ada keterangan' }}
                                </p>
                            </div>
                        </td>

                        <!-- KATEGORI -->
                        <td class="px-3 py-5">
                            <span
                                v-if="item.kategori"
                                class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700"
                            >
                                {{ item.kategori.nama }}
                            </span>

                            <span v-else class="text-xs text-slate-400">
                                Tanpa kategori
                            </span>
                        </td>

                        <!-- MODAL -->
                        <td class="px-3 py-5 text-sm text-slate-700">
                            {{ rupiah(item.modal) }}
                        </td>

                        <!-- HARGA -->
                        <td class="px-3 py-5 text-sm text-slate-700">
                            {{ rupiah(item.harga_standar) }}
                        </td>

                        <!-- STATUS -->
                        <td class="px-3 py-5">
                            <span class="inline-flex items-center gap-2 text-sm text-slate-600">
                                <span
                                    class="h-2 w-2 rounded-full"
                                    :class="item.aktif ? 'bg-emerald-500' : 'bg-slate-400'"
                                ></span>

                                {{ item.aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>

                        <!-- AKSI -->
                        <td class="px-3 py-5">
                            <div class="flex items-center justify-end gap-2">

                                <button
                                    type="button"
                                    @click="editJasa(item)"
                                    class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-2 text-sm font-medium text-slate-600 transition hover:bg-emerald-50 hover:text-emerald-700"
                                >
                                    <Pencil :size="15" />
                                    Ubah
                                </button>

                                <button
                                    type="button"
                                    @click="mintaHapusJasa(item)"
                                    class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600"
                                    title="Hapus jasa"
                                >
                                    <Trash2 :size="16" />
                                </button>

                            </div>
                        </td>
                    </tr>

                    <!-- DATA KOSONG -->
                    <tr v-if="jasaTerfilter.length === 0">
                        <td colspan="7" class="px-4 py-14 text-center">
                            <div class="flex flex-col items-center">
                                <Search :size="30" class="mb-3 text-slate-300" />

                                <p class="text-sm font-medium text-slate-600">
                                    Tidak ada jasa servis ditemukan
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    Coba ubah kata pencarian atau filter.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- FOOTER -->
        <div class="mt-4 flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 pt-4">
            <p class="text-xs text-slate-500">
                Menampilkan {{ jasaTerfilter.length }} dari {{ jasaServis.length }} jasa
            </p>
        </div>

        <Teleport to="body">
            <div
                v-if="jasaAkanDihapus"
                class="fixed inset-0 z-[120] flex items-center justify-center bg-slate-950/50 p-4 backdrop-blur-[2px]"
                @click.self="batalkanHapusJasa"
                @keydown.esc.stop.prevent="batalkanHapusJasa"
            >
                <div
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="hapus-jasa-title"
                    class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl"
                >
                    <h2 id="hapus-jasa-title" class="text-lg font-semibold text-slate-900">
                        Hapus jasa servis?
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Yakin ingin menghapus jasa servis
                        <span class="font-semibold text-slate-800">{{ jasaAkanDihapus.nama }}</span>?
                        Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <div class="mt-6 flex justify-end gap-3">
                        <button
                            type="button"
                            :disabled="sedangMenghapus"
                            @click="batalkanHapusJasa"
                            class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            Batal
                        </button>
                        <button
                            type="button"
                            :disabled="sedangMenghapus"
                            @click="konfirmasiHapusJasa"
                            class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <Trash2 :size="16" />
                            {{ sedangMenghapus ? 'Menghapus...' : 'Hapus' }}
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>

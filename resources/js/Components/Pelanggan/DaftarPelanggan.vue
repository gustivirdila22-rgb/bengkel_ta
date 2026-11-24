
<script setup>
import { ref, computed, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import {
    Search, ChevronRight, Pencil, Plus, Info, CarFront, Trash2,
} from 'lucide-vue-next'

const props = defineProps({
    pelanggans: {
        type: Array,
        default: () => [],
    },
    kendaraans: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits([
    'tambah-kendaraan',
    'edit-pelanggan',
    'notify',
])

const search = ref('')
const filterStatus = ref('Semua')
const currentPage = ref(1)
const perPage = ref(10)
const expandedId = ref(null)
const pelangganAkanDihapus = ref(null)
const sedangMenghapus = ref(false)

const daftarPelanggan = computed(() => props.pelanggans)

const kendaraanPelanggan = (pelangganId) => {
    return props.kendaraans.filter(
        kendaraan => Number(kendaraan.pelanggan_id) === Number(pelangganId)
    )
}

const jumlahKendaraan = (item) => {
    return item.kendaraans_count ?? kendaraanPelanggan(item.id).length
}

const kodePelanggan = (id) => {
    return `PLG-${String(id).padStart(3, '0')}`
}

const statusPelanggan = (item) => {
    return item.aktif ? 'Aktif' : 'Nonaktif'
}

const filteredData = computed(() => {
    const keyword = search.value.toLowerCase().trim()

    return daftarPelanggan.value.filter(item => {
        const daftarKendaraan = kendaraanPelanggan(item.id)

        const cocokSearch = [
            item.nama,
            item.no_hp,
            item.alamat,
            kodePelanggan(item.id),
            ...daftarKendaraan.map(k => k.nomor_polisi),
        ].some(value => String(value ?? '').toLowerCase().includes(keyword))

        const cocokStatus =
            filterStatus.value === 'Semua' ||
            statusPelanggan(item) === filterStatus.value

        return cocokSearch && cocokStatus
    })
})

const totalAktif = computed(() =>
    daftarPelanggan.value.filter(item => item.aktif).length
)

const totalNonaktif = computed(() =>
    daftarPelanggan.value.filter(item => !item.aktif).length
)

const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredData.value.length / perPage.value))
)

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value

    return filteredData.value.slice(start, start + perPage.value)
})

watch([search, filterStatus, perPage], () => {
    currentPage.value = 1
})

const ubahFilter = (status) => {
    filterStatus.value = status
}

const toggleDetail = (id) => {
    expandedId.value = expandedId.value === id ? null : id
}

const mintaHapusPelanggan = (item) => {
    if (kendaraanPelanggan(item.id).length > 0) {
        emit('notify', {
            type: 'error',
            message: 'Pelanggan tidak bisa dihapus karena masih memiliki kendaraan.',
        })
        return
    }

    pelangganAkanDihapus.value = item
}

const batalkanHapusPelanggan = () => {
    if (sedangMenghapus.value) return
    pelangganAkanDihapus.value = null
}

const konfirmasiHapusPelanggan = () => {
    const item = pelangganAkanDihapus.value

    if (!item || sedangMenghapus.value) return

    router.delete(`/pelanggan/${item.id}`, {
        preserveScroll: true,
        onStart: () => {
            sedangMenghapus.value = true
        },
        onSuccess: () => {
            pelangganAkanDihapus.value = null
            emit('notify', {
                type: 'success',
                message: 'Pelanggan berhasil dihapus.',
            })
        },
        onError: (errors) => {
            pelangganAkanDihapus.value = null
            emit('notify', {
                type: 'error',
                message: errors.delete
                    ?? Object.values(errors).find(error => typeof error === 'string')
                    ?? 'Pelanggan gagal dihapus. Silakan coba lagi.',
            })
        },
        onFinish: () => {
            sedangMenghapus.value = false
        },
    })
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <!-- SEARCH -->
        <div class="mb-5">
            <div class="relative w-full max-w-md">
                <Search
                    :size="17"
                    class="absolute left-3 top-3 text-slate-400"
                />

                <input
                    v-model="search"
                    type="text"
                    placeholder="Cari nama, telepon, alamat, atau nomor polisi..."
                    class="w-full rounded-xl border border-slate-200 py-2.5 pl-10 pr-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                />
            </div>
        </div>

        <!-- FILTER -->
        <div class="mb-5 flex flex-wrap items-center gap-2">
            <button
                v-for="item in [
                    { label: 'Semua', count: daftarPelanggan.length },
                    { label: 'Aktif', count: totalAktif },
                    { label: 'Nonaktif', count: totalNonaktif },
                ]"
                :key="item.label"
                type="button"
                @click="ubahFilter(item.label)"
                class="rounded-full border px-3.5 py-2 text-sm font-medium transition"
                :class="filterStatus === item.label
                    ? 'border-emerald-600 bg-emerald-50 text-emerald-700'
                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'"
            >
                {{ item.label }}
                <span class="ml-1 text-xs">{{ item.count }}</span>
            </button>

            <Info :size="16" class="text-slate-400" />
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-sm text-slate-500">
                        <th class="w-10 px-3 py-3"></th>
                        <th class="px-3 py-3 font-medium">Nama Pelanggan</th>
                        <th class="px-3 py-3 font-medium">Tingkat Harga</th>
                        <th class="px-3 py-3 font-medium">Kendaraan</th>
                        <th class="px-3 py-3 font-medium">Status</th>
                        <th class="px-3 py-3 text-right font-medium">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <template
                        v-for="item in paginatedData"
                        :key="item.id"
                    >
                        <tr class="border-b border-slate-100 transition hover:bg-slate-50">
                            <!-- EXPAND -->
                            <td class="px-3 py-4">
                                <button
                                    type="button"
                                    @click="toggleDetail(item.id)"
                                    class="rounded-lg p-1 text-slate-500 hover:bg-slate-100"
                                >
                                    <ChevronRight
                                        :size="18"
                                        :class="expandedId === item.id ? 'rotate-90' : ''"
                                        class="transition-transform"
                                    />
                                </button>
                            </td>

                            <!-- CUSTOMER -->
                            <td class="px-3 py-4">
                                <p class="text-sm font-semibold text-slate-800">
                                    {{ item.nama }}
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ kodePelanggan(item.id) }}
                                    ·
                                    {{ item.no_hp || 'Tidak ada nomor telepon' }}
                                </p>
                            </td>

                            <!-- PRICE LEVEL -->
                            <td class="px-3 py-4 text-sm text-slate-600">
                                {{ item.tingkat_harga || 'Umum' }}
                            </td>

                            <!-- VEHICLES -->
                            <td class="px-3 py-4">
                                <div class="flex flex-wrap items-center gap-2">
                                    <template v-if="kendaraanPelanggan(item.id).length">
                                        <span
                                            v-for="kendaraan in kendaraanPelanggan(item.id).slice(0, 2)"
                                            :key="kendaraan.id"
                                            class="rounded-full bg-cyan-50 px-3 py-1 text-sm font-medium text-cyan-700"
                                        >
                                            {{ kendaraan.nomor_polisi }}
                                        </span>
                                    </template>

                                    <span
                                        v-else
                                        class="text-sm text-slate-400"
                                    >
                                        Belum ada kendaraan
                                    </span>

                                    <span
                                        v-if="jumlahKendaraan(item) > 2"
                                        class="text-xs text-slate-500"
                                    >
                                        +{{ jumlahKendaraan(item) - 2 }} lainnya
                                    </span>
                                </div>
                            </td>

                            <!-- STATUS -->
                            <td class="px-3 py-4">
                                <span class="inline-flex items-center gap-2 text-sm">
                                    <span
                                        class="h-2.5 w-2.5 rounded-full"
                                        :class="item.aktif ? 'bg-emerald-500' : 'bg-slate-300'"
                                    ></span>

                                    <span class="text-slate-700">
                                        {{ statusPelanggan(item) }}
                                    </span>
                                </span>
                            </td>

                            <!-- ACTION -->
                            <td class="px-3 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <button
                                        type="button"
                                        title="Tambah kendaraan"
                                        @click="emit('tambah-kendaraan', item.id)"
                                        class="rounded-lg bg-emerald-50 p-2.5 text-emerald-700 transition hover:bg-emerald-100"
                                    >
                                        <Plus :size="16" />
                                        <CarFront :size="15" class="inline" />
                                    </button>

                                    <button
                                        type="button"
                                        title="Ubah pelanggan"
                                        @click="emit('edit-pelanggan', item)"
                                        class="inline-flex items-center gap-2 rounded-lg px-2 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100"
                                    >
                                        <Pencil :size="16" />
                                        Ubah
                                    </button>

                                    <button
                                        type="button"
                                        title="Hapus pelanggan"
                                        @click="mintaHapusPelanggan(item)"
                                        class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600"
                                    >
                                        <Trash2 :size="17" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- DETAIL -->
                        <tr
                            v-if="expandedId === item.id"
                            class="border-b border-slate-100 bg-slate-50"
                        >
                            <td colspan="6" class="px-14 py-4">
                                <div class="grid gap-4 text-sm sm:grid-cols-3">
                                    <div>
                                        <p class="text-xs text-slate-400">
                                            Kode pelanggan
                                        </p>
                                        <p class="mt-1 font-medium text-slate-700">
                                            {{ kodePelanggan(item.id) }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">
                                            Jumlah kendaraan
                                        </p>
                                        <p class="mt-1 font-medium text-slate-700">
                                            {{ jumlahKendaraan(item) }} kendaraan
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">
                                            Alamat
                                        </p>
                                        <p class="mt-1 font-medium text-slate-700">
                                            {{ item.alamat || 'Belum ada alamat' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <!-- EMPTY -->
                    <tr v-if="paginatedData.length === 0">
                        <td colspan="6" class="px-4 py-12 text-center">
                            <p class="text-sm font-medium text-slate-600">
                                Pelanggan tidak ditemukan
                            </p>
                            <p class="mt-1 text-xs text-slate-400">
                                Belum ada data pelanggan atau kata kunci tidak cocok.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
                <span>Tampilkan</span>

                <select
                    v-model.number="perPage"
                    class="rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm outline-none focus:border-emerald-500"
                >
                    <option :value="5">5</option>
                    <option :value="10">10</option>
                    <option :value="20">20</option>
                </select>

                <span>per halaman</span>
                <span class="text-slate-300">·</span>

                <span>
                    Menampilkan
                    {{ filteredData.length ? (currentPage - 1) * perPage + 1 : 0 }}–{{ Math.min(currentPage * perPage, filteredData.length) }}
                    dari {{ filteredData.length }} data
                </span>
            </div>

            <div class="flex items-center gap-1">
                <button
                    type="button"
                    @click="currentPage = Math.max(1, currentPage - 1)"
                    :disabled="currentPage === 1"
                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                >
                    ‹
                </button>

                <button
                    v-for="page in totalPages"
                    :key="page"
                    type="button"
                    @click="currentPage = page"
                    class="h-9 min-w-9 rounded-lg border px-3 text-sm font-medium transition"
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
                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                >
                    ›
                </button>
            </div>
        </div>
    </section>

    <Teleport to="body">
        <div
            v-if="pelangganAkanDihapus"
            class="fixed inset-0 z-[120] flex items-center justify-center bg-slate-950/50 p-4 backdrop-blur-[2px]"
            @click.self="batalkanHapusPelanggan"
            @keydown.esc.stop.prevent="batalkanHapusPelanggan"
        >
            <div
                role="dialog"
                aria-modal="true"
                aria-labelledby="hapus-pelanggan-title"
                class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl"
            >
                <h2 id="hapus-pelanggan-title" class="text-lg font-semibold text-slate-900">
                    Hapus pelanggan?
                </h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Yakin ingin menghapus pelanggan
                    <span class="font-semibold text-slate-800">{{ pelangganAkanDihapus.nama }}</span>?
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <button
                        type="button"
                        :disabled="sedangMenghapus"
                        @click="batalkanHapusPelanggan"
                        class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        Batal
                    </button>
                    <button
                        type="button"
                        :disabled="sedangMenghapus"
                        @click="konfirmasiHapusPelanggan"
                        class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <Trash2 :size="16" />
                        {{ sedangMenghapus ? 'Menghapus...' : 'Hapus' }}
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

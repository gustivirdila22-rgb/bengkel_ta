
<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import {
    Search,
    ChevronRight,
    Pencil,
    MoreVertical,
    Columns3,
    Info,
    X,
    Eye,
    Trash2,
    Phone,
    MapPin,
    Building2,
} from 'lucide-vue-next'

const props = defineProps({
    suppliers: {
        type: Array,
        default: () => [],
    },
})

// DATA SUPPLIER DARI DATABASE
const suppliers = computed(() => {
    return props.suppliers.map((item) => ({
        id: item.id,
        kode: item.kode_supplier,
        nama: item.nama_supplier,
        kontak: item.nama_kontak || '-',
        telepon: item.telepon || '-',
        alamat: item.alamat || '-',
        keadaan: 'Dipakai',
        catatan: item.catatan || '-',
        tempo_bayar: item.tempo_bayar ?? 0,
        lama_pengiriman: item.lama_pengiriman ?? 0,
        nama_bank: item.nama_bank || '-',
        nomor_rekening: item.nomor_rekening || '-',
        atas_nama: item.atas_nama || '-',
    }))
})

const pencarian = ref('')
const filterAktif = ref('semua')
const supplierTerbuka = ref(null)
const menuAksi = ref(null)
const modalDetail = ref(null)
const kolomTerbuka = ref(false)

const kolom = ref([
    { id: 'kode', label: 'Kode', tampil: true },
    { id: 'nama', label: 'Nama Supplier', tampil: true },
    { id: 'alamat', label: 'Alamat', tampil: true },
    { id: 'keadaan', label: 'Keadaan', tampil: true },
    { id: 'aksi', label: 'Aksi', tampil: true },
])

// PENCARIAN DAN FILTER
const supplierTampil = computed(() => {
    return suppliers.value.filter((item) => {
        const cocokPencarian = [
            item.kode,
            item.nama,
            item.kontak,
            item.telepon,
            item.alamat,
        ].some((nilai) =>
            String(nilai).toLowerCase().includes(pencarian.value.toLowerCase())
        )

        const cocokFilter =
            filterAktif.value === 'semua' ||
            (filterAktif.value === 'dipakai' && item.keadaan === 'Dipakai') ||
            (filterAktif.value === 'tidak' && item.keadaan === 'Tidak dipakai')

        return cocokPencarian && cocokFilter
    })
})

// JUMLAH SUPPLIER
const jumlahSupplier = (status) => {
    if (status === 'semua') return suppliers.value.length

    return suppliers.value.filter((item) =>
        status === 'dipakai'
            ? item.keadaan === 'Dipakai'
            : item.keadaan === 'Tidak dipakai'
    ).length
}

// BUKA DETAIL BARIS
const toggleDetail = (id) => {
    supplierTerbuka.value = supplierTerbuka.value === id ? null : id
}

const ubahSupplier = (item) => {
    router.visit(`/supplier/${item.id}/edit`)
    menuAksi.value = null
}

// HAPUS SUPPLIER
const hapusSupplier = (item) => {
    if (!confirm(`Yakin ingin menghapus ${item.nama}?`)) return

    router.delete(`/supplier/${item.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            menuAksi.value = null
            supplierTerbuka.value = null
            modalDetail.value = null
        },
    })
}

// MODAL DETAIL
const tampilkanDetail = (item) => {
    modalDetail.value = item
    menuAksi.value = null
}
</script>

<template>
    <div class="space-y-5">

        <!-- TOOLBAR -->
        <div class="flex flex-wrap items-center justify-between gap-3">

            <!-- SEARCH -->
            <div class="relative w-full max-w-md">
                <Search
                    :size="18"
                    class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                />

                <input
                    v-model="pencarian"
                    type="text"
                    placeholder="Cari nama, kode, telepon, atau alamat..."
                    class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                />
            </div>

            <!-- COLUMN BUTTON -->
            <div class="relative">
                <button
                    type="button"
                    @click="kolomTerbuka = !kolomTerbuka"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                >
                    <Columns3 :size="17" />
                    Kolom
                </button>

                <div
                    v-if="kolomTerbuka"
                    class="absolute right-0 top-full z-30 mt-2 w-52 rounded-xl border border-slate-200 bg-white p-3 shadow-xl"
                >
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-700">
                            Tampilkan Kolom
                        </p>

                        <button
                            type="button"
                            @click="kolomTerbuka = false"
                            class="text-slate-400 hover:text-slate-700"
                        >
                            <X :size="16" />
                        </button>
                    </div>

                    <label
                        v-for="item in kolom"
                        :key="item.id"
                        class="flex cursor-pointer items-center gap-2 rounded-lg px-2 py-2 text-sm text-slate-600 hover:bg-slate-50"
                    >
                        <input
                            v-model="item.tampil"
                            type="checkbox"
                            :disabled="item.id === 'nama'"
                            class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                        />
                        {{ item.label }}
                    </label>
                </div>
            </div>
        </div>

        <!-- FILTER -->
        <div class="flex flex-wrap items-center gap-2">
            <button
                v-for="filter in [
                    { id: 'semua', label: 'Semua' },
                    { id: 'dipakai', label: 'Dipakai' },
                    { id: 'tidak', label: 'Tidak dipakai' },
                ]"
                :key="filter.id"
                type="button"
                @click="filterAktif = filter.id"
                class="rounded-full border px-4 py-2 text-sm font-medium transition"
                :class="filterAktif === filter.id
                    ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'"
            >
                {{ filter.label }}
                <span class="ml-1">{{ jumlahSupplier(filter.id) }}</span>
            </button>

            <div class="group relative">
                <Info :size="16" class="cursor-help text-slate-400" />

                <div class="pointer-events-none absolute left-1/2 top-full z-20 mt-2 hidden w-56 -translate-x-1/2 rounded-xl bg-slate-800 p-3 text-xs leading-relaxed text-white shadow-xl group-hover:block">
                    Supplier yang tidak dipakai tetap tersimpan dan dapat digunakan kembali.
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] border-collapse text-left">

                <thead>
                    <tr class="border-b border-slate-200 text-xs font-semibold text-slate-500">
                        <th class="w-12 px-3 py-4"></th>

                        <th
                            v-for="item in kolom.filter(k => k.tampil)"
                            :key="item.id"
                            class="px-4 py-4"
                            :class="item.id === 'aksi' ? 'text-center' : ''"
                        >
                            {{ item.label }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <template v-for="item in supplierTampil" :key="item.id">

                        <tr
                            class="border-b border-slate-100 transition hover:bg-emerald-50/30"
                            :class="supplierTerbuka === item.id ? 'bg-emerald-50/30' : ''"
                        >
                            <!-- EXPAND -->
                            <td class="px-3 py-5">
                                <button
                                    type="button"
                                    @click="toggleDetail(item.id)"
                                    class="rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-emerald-600"
                                >
                                    <ChevronRight
                                        :size="18"
                                        class="transition-transform"
                                        :class="supplierTerbuka === item.id ? 'rotate-90' : ''"
                                    />
                                </button>
                            </td>

                            <!-- KODE -->
                            <td
                                v-if="kolom.find(k => k.id === 'kode')?.tampil"
                                class="px-4 py-5 text-sm font-medium text-slate-600"
                            >
                                {{ item.kode }}
                            </td>

                            <!-- NAMA -->
                            <td
                                v-if="kolom.find(k => k.id === 'nama')?.tampil"
                                class="px-4 py-5"
                            >
                                <p class="text-sm font-semibold text-slate-800">
                                    {{ item.nama }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ item.kontak }} · {{ item.telepon }}
                                </p>
                            </td>

                            <!-- ALAMAT -->
                            <td
                                v-if="kolom.find(k => k.id === 'alamat')?.tampil"
                                class="px-4 py-5 text-sm text-slate-600"
                            >
                                <div class="max-w-[220px]">
                                    {{ item.alamat }}
                                </div>
                            </td>

                            <!-- STATUS -->
                            <td
                                v-if="kolom.find(k => k.id === 'keadaan')?.tampil"
                                class="px-4 py-5"
                            >
                                <span class="inline-flex items-center gap-2 text-sm text-slate-600">
                                    <span
                                        class="h-2.5 w-2.5 rounded-full"
                                        :class="item.keadaan === 'Dipakai'
                                            ? 'bg-emerald-500'
                                            : 'bg-slate-300'"
                                    ></span>
                                    {{ item.keadaan }}
                                </span>
                            </td>

                            <!-- AKSI -->
                            <td
                                v-if="kolom.find(k => k.id === 'aksi')?.tampil"
                                class="px-4 py-5"
                            >
                                <div class="flex items-center justify-center gap-3">
                                    <button
                                        type="button"
                                        @click="ubahSupplier(item)"
                                        class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-emerald-600"
                                    >
                                        <Pencil :size="16" />
                                        Ubah
                                    </button>

                                    <div class="relative">
                                        <button
                                            type="button"
                                            @click="menuAksi = menuAksi === item.id ? null : item.id"
                                            class="rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                                        >
                                            <MoreVertical :size="19" />
                                        </button>

                                        <div
                                            v-if="menuAksi === item.id"
                                            class="absolute right-0 top-full z-20 mt-1 w-44 rounded-xl border border-slate-200 bg-white p-1.5 shadow-xl"
                                        >
                                            <button
                                                type="button"
                                                @click="tampilkanDetail(item)"
                                                class="flex w-full items-center gap-2 rounded-lg px-3 py-2.5 text-left text-sm text-slate-600 hover:bg-slate-50"
                                            >
                                                <Eye :size="16" />
                                                Lihat detail
                                            </button>

                                            <button
                                                type="button"
                                                @click="ubahSupplier(item)"
                                                class="flex w-full items-center gap-2 rounded-lg px-3 py-2.5 text-left text-sm text-slate-600 hover:bg-slate-50"
                                            >
                                                <Pencil :size="16" />
                                                Ubah supplier
                                            </button>

                                            <button
                                                type="button"
                                                @click="hapusSupplier(item)"
                                                class="flex w-full items-center gap-2 rounded-lg px-3 py-2.5 text-left text-sm text-red-600 hover:bg-red-50"
                                            >
                                                <Trash2 :size="16" />
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- DETAIL EXPAND -->
                        <tr
                            v-if="supplierTerbuka === item.id"
                            class="border-b border-slate-100 bg-slate-50/70"
                        >
                            <td colspan="6" class="px-8 py-5">
                                <div class="grid gap-5 md:grid-cols-3">
                                    <div>
                                        <p class="text-xs font-medium text-slate-400">
                                            Kontak Person
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ item.kontak }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs font-medium text-slate-400">
                                            Nomor Telepon
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ item.telepon }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs font-medium text-slate-400">
                                            Tempo Pembayaran
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ item.tempo_bayar }} hari
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs font-medium text-slate-400">
                                            Lama Pengiriman
                                        </p>
                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ item.lama_pengiriman }} hari
                                        </p>
                                    </div>

                                    <div class="md:col-span-2">
                                        <p class="text-xs font-medium text-slate-400">
                                            Catatan
                                        </p>
                                        <p class="mt-1 text-sm text-slate-600">
                                            {{ item.catatan }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </template>

                    <!-- EMPTY STATE -->
                    <tr v-if="supplierTampil.length === 0">
                        <td colspan="6" class="px-4 py-16 text-center">
                            <Search :size="30" class="mx-auto mb-3 text-slate-300" />
                            <p class="font-semibold text-slate-600">
                                Supplier tidak ditemukan
                            </p>
                            <p class="mt-1 text-sm text-slate-400">
                                Coba gunakan kata kunci pencarian lainnya.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- FOOTER -->
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-4">
            <p class="text-sm text-slate-500">
                Menampilkan
                <span class="font-semibold text-slate-700">{{ supplierTampil.length }}</span>
                dari
                <span class="font-semibold text-slate-700">{{ suppliers.length }}</span>
                supplier
            </p>

            <p class="text-xs text-slate-400">
                Data tersimpan di database
            </p>
        </div>

        <!-- MODAL DETAIL -->
        <div
            v-if="modalDetail"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm"
            @click.self="modalDetail = null"
        >
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">
                            Detail Supplier
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Informasi lengkap supplier
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="modalDetail = null"
                        class="rounded-lg p-2 text-slate-400 hover:bg-slate-100"
                    >
                        <X :size="19" />
                    </button>
                </div>

                <div class="mb-5 flex items-center gap-3 rounded-xl bg-emerald-50 p-4">
                    <div class="rounded-xl bg-white p-3 text-emerald-600">
                        <Building2 :size="23" />
                    </div>

                    <div>
                        <p class="font-bold text-slate-800">
                            {{ modalDetail.nama }}
                        </p>
                        <p class="text-sm text-slate-500">
                            {{ modalDetail.kode }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-400">Kontak Person</p>
                        <p class="mt-1 text-sm font-medium text-slate-700">
                            {{ modalDetail.kontak }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">Nomor Telepon</p>
                        <p class="mt-1 flex items-center gap-2 text-sm font-medium text-slate-700">
                            <Phone :size="15" />
                            {{ modalDetail.telepon }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">Alamat</p>
                        <p class="mt-1 flex items-start gap-2 text-sm font-medium text-slate-700">
                            <MapPin :size="15" class="mt-0.5 shrink-0" />
                            {{ modalDetail.alamat }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">Informasi Rekening</p>
                        <p class="mt-1 text-sm font-medium text-slate-700">
                            {{ modalDetail.nama_bank }} · {{ modalDetail.nomor_rekening }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            Atas nama: {{ modalDetail.atas_nama }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">Catatan</p>
                        <p class="mt-1 text-sm text-slate-700">
                            {{ modalDetail.catatan }}
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    @click="modalDetail = null"
                    class="mt-6 w-full rounded-xl bg-emerald-600 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700"
                >
                    Tutup
                </button>
            </div>
        </div>

    </div>
</template>

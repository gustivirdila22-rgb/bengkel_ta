
<script setup>
import { ref, computed } from 'vue'
import RingkasanMekanik from '@/Components/Mekanik/RingkasanMekanik.vue'
import Kinerja from '@/Components/Mekanik/Kinerja.vue'
import KomisiKasBon from '@/Components/Mekanik/KomisiKasBon.vue'

const activeTab = ref('daftar')
const activeSubTab = ref('mekanik')
const activeFilter = ref('semua')
const search = ref('')
const showColumns = ref(false)
const currentPage = ref(1)
const perPage = ref(20)
const showDetail = ref(null)

const mekanik = ref([
    {
        id: 1,
        nama: 'Cecep Hasanudin',
        kode: 'KRY-000001',
        jabatan: 'Mekanik',
        telepon: '0811-2345-6789',
        servis: 9,
        keterangan: 'spesialis bongkar mesin',
        status: 'Aktif'
    }
])

const filteredMekanik = computed(() => {
    return mekanik.value.filter(item => {
        const cocokSearch =
            item.nama.toLowerCase().includes(search.value.toLowerCase()) ||
            item.kode.toLowerCase().includes(search.value.toLowerCase())

        const cocokFilter =
            activeFilter.value === 'semua' ||
            (activeFilter.value === 'aktif' && item.status === 'Aktif') ||
            (activeFilter.value === 'nonaktif' && item.status === 'Nonaktif')

        return cocokSearch && cocokFilter
    })
})

const totalAktif = computed(() =>
    mekanik.value.filter(item => item.status === 'Aktif').length
)

const totalNonaktif = computed(() =>
    mekanik.value.filter(item => item.status === 'Nonaktif').length
)

const totalMekanik = computed(() => mekanik.value.length)

const toggleDetail = (id) => {
    showDetail.value = showDetail.value === id ? null : id
}
</script>

<template>
    <div class="space-y-6 text-slate-700">

        <!-- Header Tombol -->
        <div class="flex justify-end gap-2">
            <button
                class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50"
            >
                <span>♧</span>
                Dokumen
                <span>⌄</span>
            </button>

            <button
                class="flex items-center gap-2 rounded-lg bg-[#009966] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#00875B]"
            >
                <span class="text-lg">+</span>
                Tambah Mekanik
            </button>
        </div>

        <!-- Statistik -->
        <div class="flex flex-wrap gap-2">
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-100 px-3 py-2 text-sm">
                <span class="font-semibold text-slate-900">{{ totalMekanik }}</span>
                <span>mekanik</span>
                <span>›</span>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-100 px-3 py-2 text-sm">
                <span class="h-2 w-2 rounded-full bg-[#009966]"></span>
                <span class="font-semibold text-slate-900">{{ totalAktif }}</span>
                <span>masih aktif</span>
                <span>›</span>
            </div>
        </div>

        <!-- Navigasi Utama -->
        <div class="flex gap-7 border-b border-slate-200">
            <button
                @click="activeTab = 'daftar'"
                :class="activeTab === 'daftar'
                    ? 'border-b-2 border-[#009966] text-[#009966]'
                    : 'text-slate-500'"
                class="px-4 pb-3 text-sm font-medium"
            >
                Daftar & Ringkasan
            </button>

            <button
                @click="activeTab = 'kinerja'"
                :class="activeTab === 'kinerja'
                    ? 'border-b-2 border-[#009966] text-[#009966]'
                    : 'text-slate-500'"
                class="px-4 pb-3 text-sm font-medium"
            >
                Kinerja
            </button>

            <button
                @click="activeTab = 'komisi'"
                :class="activeTab === 'komisi'
                    ? 'border-b-2 border-[#009966] text-[#009966]'
                    : 'text-slate-500'"
                class="px-4 pb-3 text-sm font-medium"
            >
                ♙ Komisi & Kas Bon
            </button>
        </div>

        <!-- Daftar & Ringkasan -->
        <template v-if="activeTab === 'daftar'">

            <!-- Sub Navigasi -->
            <div class="inline-flex rounded-xl bg-slate-100 p-1">
                <button
                    @click="activeSubTab = 'mekanik'"
                    :class="activeSubTab === 'mekanik'
                        ? 'bg-white text-[#009966] shadow-sm'
                        : 'text-slate-500'"
                    class="rounded-lg px-3 py-2 text-sm font-medium"
                >
                    Daftar Mekanik
                </button>

                <button
                    @click="activeSubTab = 'ringkasan'"
                    :class="activeSubTab === 'ringkasan'
                        ? 'bg-white text-[#009966] shadow-sm'
                        : 'text-slate-500'"
                    class="rounded-lg px-3 py-2 text-sm font-medium"
                >
                    Ringkasan
                </button>
            </div>

            <!-- Ringkasan Mekanik -->
            <RingkasanMekanik v-if="activeSubTab === 'ringkasan'" />

            <!-- Tabel Daftar Mekanik -->
            <div
                v-else
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
            >

                <!-- Search dan Kolom -->
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="relative w-full sm:w-[352px]">
                        <span class="absolute left-3 top-2.5 text-slate-400">⌕</span>

                        <input
                            v-model="search"
                            type="text"
                            placeholder="Cari nama atau kode mekanik..."
                            class="w-full rounded-lg border border-slate-200 py-2.5 pl-9 pr-3 text-sm outline-none focus:border-[#009966] focus:ring-1 focus:ring-[#009966]"
                        />
                    </div>

                    <div class="relative">
                        <button
                            @click="showColumns = !showColumns"
                            class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm hover:bg-slate-50"
                        >
                            ▥ Kolom
                        </button>

                        <div
                            v-if="showColumns"
                            class="absolute right-0 z-10 mt-2 w-40 rounded-lg border border-slate-200 bg-white p-3 shadow-lg"
                        >
                            <p class="text-sm">Pengaturan kolom</p>
                        </div>
                    </div>
                </div>

                <!-- Filter -->
                <div class="mt-3 flex flex-wrap items-center gap-2">
                    <button
                        @click="activeFilter = 'semua'"
                        :class="activeFilter === 'semua'
                            ? 'border-[#009966] bg-[#E6F5F0] text-[#009966]'
                            : 'border-slate-200 text-slate-600'"
                        class="rounded-full border px-3 py-1.5 text-sm"
                    >
                        Semua {{ totalMekanik }}
                    </button>

                    <button
                        @click="activeFilter = 'aktif'"
                        :class="activeFilter === 'aktif'
                            ? 'border-[#009966] bg-[#E6F5F0] text-[#009966]'
                            : 'border-slate-200 text-slate-600'"
                        class="rounded-full border px-3 py-1.5 text-sm"
                    >
                        Aktif {{ totalAktif }}
                    </button>

                    <button
                        @click="activeFilter = 'nonaktif'"
                        :class="activeFilter === 'nonaktif'
                            ? 'border-[#009966] bg-[#E6F5F0] text-[#009966]'
                            : 'border-slate-200 text-slate-600'"
                        class="rounded-full border px-3 py-1.5 text-sm"
                    >
                        Nonaktif {{ totalNonaktif }}
                    </button>

                    <span class="text-slate-400" title="Filter berdasarkan status">
                        ⓘ
                    </span>
                </div>

                <!-- Tabel -->
                <div class="mt-5 overflow-x-auto">
                    <table class="w-full min-w-[850px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs text-slate-500">
                                <th class="w-12 px-4 py-4"></th>
                                <th class="px-4 py-4 font-medium">Nama Mekanik</th>
                                <th class="px-4 py-4 font-medium">Jabatan</th>
                                <th class="px-4 py-4 font-medium">Telepon</th>
                                <th class="px-4 py-4 text-center font-medium">
                                    Servis Ditangani
                                </th>
                                <th class="px-4 py-4 font-medium">Status</th>
                                <th class="px-4 py-4 text-center font-medium">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <template
                                v-for="item in filteredMekanik"
                                :key="item.id"
                            >
                                <!-- Baris Mekanik -->
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="px-4 py-4">
                                        <button
                                            @click="toggleDetail(item.id)"
                                            class="text-lg text-slate-500"
                                        >
                                            {{ showDetail === item.id ? '⌄' : '›' }}
                                        </button>
                                    </td>

                                    <td class="px-4 py-4">
                                        <p class="font-medium text-slate-900">
                                            {{ item.nama }}
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            {{ item.kode }}
                                        </p>
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ item.jabatan }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ item.telepon }}
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        {{ item.servis }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-2">
                                            <span
                                                :class="item.status === 'Aktif'
                                                    ? 'bg-[#009966]'
                                                    : 'bg-gray-400'"
                                                class="h-2 w-2 rounded-full"
                                            ></span>
                                            {{ item.status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <button
                                            class="font-medium text-slate-700 hover:text-[#009966]"
                                        >
                                            ✎ Ubah
                                        </button>
                                    </td>
                                </tr>

                                <!-- Dropdown Detail Mekanik -->
                                <tr
                                    v-if="showDetail === item.id"
                                    :key="`detail-${item.id}`"
                                >
                                    <td colspan="7" class="bg-slate-50 px-5 py-5">
                                        <div class="grid grid-cols-1 gap-x-12 gap-y-5 md:grid-cols-2">

                                            <div>
                                                <p class="mb-1 text-xs text-slate-500">
                                                    Kode
                                                </p>
                                                <p class="text-sm font-medium text-slate-900">
                                                    {{ item.kode }}
                                                </p>
                                            </div>

                                            <div>
                                                <p class="mb-1 text-xs text-slate-500">
                                                    Jabatan
                                                </p>
                                                <p class="text-sm font-medium text-slate-900">
                                                    {{ item.jabatan }}
                                                </p>
                                            </div>

                                            <div>
                                                <p class="mb-1 text-xs text-slate-500">
                                                    Telepon
                                                </p>
                                                <p class="text-sm font-medium text-slate-900">
                                                    {{ item.telepon }}
                                                </p>
                                            </div>

                                            <div>
                                                <p class="mb-1 text-xs text-slate-500">
                                                    Servis ditangani
                                                </p>
                                                <p class="text-sm font-medium text-slate-900">
                                                    {{ item.servis }} servis
                                                </p>
                                            </div>

                                            <div>
                                                <p class="mb-1 text-xs text-slate-500">
                                                    Keterangan
                                                </p>
                                                <p class="text-sm font-medium text-slate-900">
                                                    {{ item.keterangan || '-' }}
                                                </p>
                                            </div>

                                            <div>
                                                <p class="mb-1 text-xs text-slate-500">
                                                    Status
                                                </p>
                                                <div class="flex items-center gap-2 text-sm font-medium text-slate-900">
                                                    <span
                                                        :class="item.status === 'Aktif'
                                                            ? 'bg-[#009966]'
                                                            : 'bg-gray-400'"
                                                        class="h-2 w-2 rounded-full"
                                                    ></span>
                                                    {{ item.status }}
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            </template>

                            <!-- Data Kosong -->
                            <tr v-if="filteredMekanik.length === 0">
                                <td colspan="7" class="py-10 text-center text-slate-400">
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
                            class="rounded-lg border border-slate-200 bg-white px-3 py-2 outline-none focus:border-[#009966]"
                        >
                            <option :value="20">20</option>
                            <option :value="50">50</option>
                            <option :value="100">100</option>
                        </select>

                        <span>per halaman</span>
                        <span>·</span>

                        <span>
                            Menampilkan {{ filteredMekanik.length ? 1 : 0 }}–{{ filteredMekanik.length }}
                            dari {{ filteredMekanik.length }} data
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
                            class="rounded-lg bg-[#009966] px-4 py-2 font-medium text-white"
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

        <!-- Halaman Kinerja -->
        <Kinerja v-if="activeTab === 'kinerja'" />

        <!-- Halaman Komisi & Kas Bon -->
        <KomisiKasBon v-if="activeTab === 'komisi'" />
    </div>
</template>

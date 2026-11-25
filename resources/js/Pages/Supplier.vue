
<script setup>
import { ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

import {
    FileDown,
    FileSpreadsheet,
    Plus,
    Truck,
    ChevronDown,
    ChevronRight,
    Upload,
} from 'lucide-vue-next'

import TabSupplier from '@/Components/Supplier/TabSupplier.vue'
import DaftarSupplier from '@/Components/Supplier/DaftarSupplier.vue'
import RingkasanSupplier from '@/Components/Supplier/RingkasanSupplier.vue'
import KartuUtang from '@/Components/Supplier/KartuUtang.vue'
import KinerjaSupplier from '@/Components/Supplier/KinerjaSupplier.vue'
import HargaBeli from '@/Components/Supplier/HargaBeli.vue'
import AnalisaHargaBeli from '@/Components/Supplier/AnalisaHargaBeli.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    suppliers: {
        type: Array,
        default: () => [],
    },
})

const tabAktif = ref('daftar')
const subTabAktif = ref('daftar')

const dokumenTerbuka = ref(false)
const inputExcel = ref(null)

const gantiTab = (tab) => {
    tabAktif.value = tab
    dokumenTerbuka.value = false

    if (tab === 'daftar') {
        subTabAktif.value = 'daftar'
    } else if (tab === 'kinerja') {
        subTabAktif.value = 'kinerja'
    }
}

const gantiSubTab = (tab) => {
    subTabAktif.value = tab
}

const tambahSupplier = () => {
    router.visit('/supplier/create')
}

const downloadExcel = () => {
    alert('Fitur download Excel akan kita buat berikutnya.')
    dokumenTerbuka.value = false
}

const bukaUploadExcel = () => {
    inputExcel.value?.click()
    dokumenTerbuka.value = false
}

const pilihFileExcel = (event) => {
    const file = event.target.files[0]

    if (!file) return

    alert(`File ${file.name} berhasil dipilih. Fitur upload akan kita buat berikutnya.`)

    event.target.value = ''
}

const catatUtangLama = () => {
    alert('Form catat utang lama akan dibuat berikutnya.')
}

const bayarSupplier = () => {
    alert('Form pembayaran supplier akan dibuat berikutnya.')
}
</script>

<template>
    <Head title="Supplier" />

    <div class="min-h-screen space-y-6 bg-slate-50/50 p-5">

        <!-- HEADER SUPPLIER -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800">
                    Supplier
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola data supplier, utang, dan kinerja pembelian
                </p>
            </div>

            <!-- ACTION SUPPLIER -->
            <div
                v-if="tabAktif === 'daftar'"
                class="flex items-center gap-3"
            >
                <div class="relative">
                    <button
                        type="button"
                        @click="dokumenTerbuka = !dokumenTerbuka"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                    >
                        <FileDown :size="17" />
                        Dokumen
                        <ChevronDown
                            :size="15"
                            :class="dokumenTerbuka ? 'rotate-180' : ''"
                        />
                    </button>

                    <div
                        v-if="dokumenTerbuka"
                        class="absolute right-0 top-full z-50 mt-2 w-[360px] max-w-[calc(100vw-2rem)] overflow-hidden rounded-2xl border border-slate-200 bg-white p-3 shadow-xl"
                    >
                        <button
                            type="button"
                            @click="downloadExcel"
                            class="flex w-full items-start gap-3 rounded-xl p-3 text-left transition hover:bg-slate-50"
                        >
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <FileSpreadsheet :size="20" />
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-800">
                                    Download Excel
                                </p>
                                <p class="mt-1 text-sm leading-relaxed text-slate-500">
                                    Semua supplier beserta tempo bayar, rekening, utang aktif, dan uang muka. Bisa diedit lalu di-upload kembali.
                                </p>
                            </div>
                        </button>

                        <button
                            type="button"
                            @click="bukaUploadExcel"
                            class="flex w-full items-start gap-3 rounded-xl p-3 text-left transition hover:bg-slate-50"
                        >
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <Upload :size="20" />
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-800">
                                    Upload Excel
                                </p>
                                <p class="mt-1 text-sm leading-relaxed text-slate-500">
                                    Upload berkas yang sudah diisi — supplier baru ditambah, yang kodenya sudah ada diperbarui. Diperiksa dulu sebelum disimpan.
                                </p>
                            </div>
                        </button>
                    </div>

                    <input
                        ref="inputExcel"
                        type="file"
                        accept=".xlsx,.xls"
                        class="hidden"
                        @change="pilihFileExcel"
                    />
                </div>

                <button
                    type="button"
                    @click="tambahSupplier"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                >
                    <Plus :size="18" />
                    Tambah Supplier
                </button>
            </div>

            <!-- ACTION UTANG -->
            <div
                v-else-if="tabAktif === 'utang'"
                class="flex flex-wrap items-center gap-3"
            >
                <div class="relative">
                    <button
                        type="button"
                        @click="dokumenTerbuka = !dokumenTerbuka"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                    >
                        <FileDown :size="17" />
                        Dokumen
                        <ChevronDown
                            :size="15"
                            :class="dokumenTerbuka ? 'rotate-180' : ''"
                        />
                    </button>

                    <div
                        v-if="dokumenTerbuka"
                        class="absolute right-0 top-full z-50 mt-2 w-[320px] overflow-hidden rounded-2xl border border-slate-200 bg-white p-3 shadow-xl"
                    >
                        <button
                            type="button"
                            @click="downloadExcel"
                            class="flex w-full items-start gap-3 rounded-xl p-3 text-left transition hover:bg-slate-50"
                        >
                            <FileSpreadsheet :size="20" class="shrink-0 text-emerald-600" />
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Download Excel</p>
                                <p class="mt-1 text-sm text-slate-500">Unduh riwayat kartu utang supplier.</p>
                            </div>
                        </button>

                        <button
                            type="button"
                            @click="bukaUploadExcel"
                            class="flex w-full items-start gap-3 rounded-xl p-3 text-left transition hover:bg-slate-50"
                        >
                            <Upload :size="20" class="shrink-0 text-blue-600" />
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Upload Excel</p>
                                <p class="mt-1 text-sm text-slate-500">Impor data riwayat utang dari Excel.</p>
                            </div>
                        </button>
                    </div>

                    <input
                        ref="inputExcel"
                        type="file"
                        accept=".xlsx,.xls"
                        class="hidden"
                        @change="pilihFileExcel"
                    />
                </div>

                <button
                    type="button"
                    @click="catatUtangLama"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                >
                    Catat Utang Lama
                </button>

                <button
                    type="button"
                    @click="bayarSupplier"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                >
                    <Plus :size="17" />
                    Bayar Supplier Ini
                </button>
            </div>

            <!-- ACTION HARGA & KINERJA -->
            <div
                v-else-if="tabAktif === 'kinerja'"
                class="flex items-center gap-3"
            >
                <div class="relative">
                    <button
                        type="button"
                        @click="dokumenTerbuka = !dokumenTerbuka"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                    >
                        <FileDown :size="17" />
                        Dokumen
                        <ChevronDown
                            :size="15"
                            :class="dokumenTerbuka ? 'rotate-180' : ''"
                        />
                    </button>

                    <div
                        v-if="dokumenTerbuka"
                        class="absolute right-0 top-full z-50 mt-2 w-[320px] overflow-hidden rounded-2xl border border-slate-200 bg-white p-3 shadow-xl"
                    >
                        <button
                            type="button"
                            @click="downloadExcel"
                            class="flex w-full items-start gap-3 rounded-xl p-3 text-left transition hover:bg-slate-50"
                        >
                            <FileSpreadsheet :size="20" class="shrink-0 text-emerald-600" />
                            <div>
                                <p class="text-sm font-semibold text-slate-800">
                                    Download Excel
                                </p>
                                <p class="mt-1 text-sm text-slate-500">
                                    Unduh data kinerja dan riwayat harga pembelian supplier.
                                </p>
                            </div>
                        </button>

                        <button
                            type="button"
                            @click="bukaUploadExcel"
                            class="flex w-full items-start gap-3 rounded-xl p-3 text-left transition hover:bg-slate-50"
                        >
                            <Upload :size="20" class="shrink-0 text-blue-600" />
                            <div>
                                <p class="text-sm font-semibold text-slate-800">
                                    Upload Excel
                                </p>
                                <p class="mt-1 text-sm text-slate-500">
                                    Impor data kinerja dan harga pembelian supplier dari Excel.
                                </p>
                            </div>
                        </button>
                    </div>

                    <input
                        ref="inputExcel"
                        type="file"
                        accept=".xlsx,.xls"
                        class="hidden"
                        @change="pilihFileExcel"
                    />
                </div>
            </div>
        </div>

        <!-- SUMMARY SUPPLIER -->
        <div
            v-if="tabAktif === 'daftar'"
            class="flex flex-wrap items-center gap-2"
        >
            <!-- TOTAL SUPPLIER -->
            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                <span class="font-bold text-slate-800">
                    {{ props.suppliers.length }}
                </span>
                <span class="ml-1 text-slate-500">supplier</span>
                <ChevronRight :size="14" class="ml-2 inline text-slate-400" />
            </div>

            <!-- MASIH DIPAKAI -->
            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                <span class="mr-2 inline-block h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                <span class="font-bold text-slate-800">
                    {{ props.suppliers.length }}
                </span>
                <span class="ml-1 text-slate-500">masih dipakai</span>
                <ChevronRight :size="14" class="ml-2 inline text-slate-400" />
            </div>

            <!-- PERNAH DIBELI -->
            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                <span class="font-bold text-slate-800">
                    {{ props.suppliers.length }}
                </span>
                <span class="ml-1 text-slate-500">pernah dibeli</span>
            </div>
        </div>

        <!-- SUMMARY UTANG -->
        <div
            v-if="tabAktif === 'utang'"
            class="flex flex-wrap items-center gap-2"
        >
            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                <strong class="text-slate-800">Rp 51.984.500</strong>
                <span class="ml-2 text-slate-500">utang aktif awal</span>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                <strong class="text-slate-800">Rp 0</strong>
                <span class="ml-2 text-slate-500">utang masuk</span>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                <span class="mr-2 inline-block h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                <strong class="text-slate-800">Rp 6.000.000</strong>
                <span class="ml-2 text-slate-500">dibayar</span>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                <strong class="text-slate-800">Rp 45.984.500</strong>
                <span class="ml-2 text-slate-500">utang aktif akhir</span>
            </div>
        </div>

        <!-- TAB NAVIGATION -->
        <TabSupplier
            :active-tab="tabAktif"
            :active-sub-tab="subTabAktif"
            @change-tab="gantiTab"
            @change-sub-tab="gantiSubTab"
        />

        <!-- CONTENT -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">

            <!-- DAFTAR & RINGKASAN -->
            <template v-if="tabAktif === 'daftar'">
                <div v-if="subTabAktif === 'daftar'">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                Daftar Supplier
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Informasi dan daftar seluruh supplier bengkel
                            </p>
                        </div>

                        <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                            <Truck :size="22" />
                        </div>
                    </div>

                    <DaftarSupplier :suppliers="props.suppliers" />
                </div>

                <div v-else>
                    <RingkasanSupplier :suppliers="props.suppliers" />
                </div>
            </template>

            <!-- KARTU UTANG -->
            <template v-else-if="tabAktif === 'utang'">
                <KartuUtang />
            </template>

            <!-- HARGA & KINERJA -->
            <template v-else-if="tabAktif === 'kinerja'">
                <KinerjaSupplier v-if="subTabAktif === 'kinerja'" />
                <HargaBeli v-else-if="subTabAktif === 'harga'" />
                <AnalisaHargaBeli v-else-if="subTabAktif === 'analisa'" />
            </template>
        </div>
    </div>
</template>

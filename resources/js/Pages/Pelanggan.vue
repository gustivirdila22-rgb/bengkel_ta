
<script setup>
import { ref, computed, onBeforeUnmount } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

import DaftarPelanggan from '@/Components/Pelanggan/DaftarPelanggan.vue'
import RingkasanPelanggan from '@/Components/Pelanggan/RingkasanPelanggan.vue'
import DaftarKendaraan from '@/Components/Pelanggan/DaftarKendaraan.vue'
import TagihanPelanggan from '@/Components/Pelanggan/TagihanPelanggan.vue'

import {
    Users, CarFront, Receipt, Plus, FileDown, X, Info,
} from 'lucide-vue-next'

defineOptions({ layout: AppLayout })

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

const activeTab = ref('daftar')
const activeSubTab = ref('pelanggan')

const showModalPelanggan = ref(false)
const showModalKendaraan = ref(false)
const notification = ref(null)
let notificationTimeout

const tampilkanNotifikasi = ({ type, message }) => {
    notification.value = { type, message }

    clearTimeout(notificationTimeout)
    notificationTimeout = setTimeout(() => {
        notification.value = null
    }, 4000)
}

const tutupNotifikasi = () => {
    clearTimeout(notificationTimeout)
    notification.value = null
}

onBeforeUnmount(tutupNotifikasi)

const pelangganDieditId = ref(null)

const modeEditPelanggan = computed(
    () => pelangganDieditId.value !== null
)

const tabs = [
    { id: 'daftar', label: 'Daftar & Ringkasan', icon: Users },
    { id: 'kendaraan', label: 'Kendaraan', icon: CarFront },
    { id: 'tagihan', label: 'Tagihan & DP', icon: Receipt },
]

const judulAksi = computed(() => {
    if (activeTab.value === 'daftar') return 'Tambah Pelanggan'
    if (activeTab.value === 'kendaraan') return 'Tambah Kendaraan'
    return 'Catat Tagihan'
})

const formPelanggan = useForm({
    nama: '',
    no_hp: '',
    alamat: '',
    tingkat_harga: 'Umum',
    aktif: true,
})

const formKendaraan = useForm({
    pelanggan_id: '',
    nomor_polisi: '',
    merek: '',
    tipe: '',
    tahun: '',
    warna: '',
    catatan: '',
})

const ubahTab = (tab) => {
    activeTab.value = tab
}

const bukaModalTambahPelanggan = () => {
    pelangganDieditId.value = null

    formPelanggan.reset()
    formPelanggan.clearErrors()

    formPelanggan.aktif = true
    formPelanggan.tingkat_harga = 'Umum'

    showModalPelanggan.value = true
}

const bukaModalTambahKendaraan = (pelangganId) => {
    formKendaraan.reset()
    formKendaraan.clearErrors()
    formKendaraan.pelanggan_id = pelangganId

    showModalKendaraan.value = true
}

const editPelanggan = (item) => {
    pelangganDieditId.value = item.id

    formPelanggan.clearErrors()

    formPelanggan.nama = item.nama ?? ''
    formPelanggan.no_hp = item.no_hp ?? ''
    formPelanggan.alamat = item.alamat ?? ''
    formPelanggan.tingkat_harga = item.tingkat_harga ?? 'Umum'
    formPelanggan.aktif = Boolean(item.aktif)

    showModalPelanggan.value = true
}

const simpanPelanggan = () => {
    if (modeEditPelanggan.value) {
        formPelanggan.put(`/pelanggan/${pelangganDieditId.value}`, {
            preserveScroll: true,
            onSuccess: () => {
                showModalPelanggan.value = false
                pelangganDieditId.value = null

                formPelanggan.reset()
                formPelanggan.aktif = true
                formPelanggan.tingkat_harga = 'Umum'
                tampilkanNotifikasi({
                    type: 'success',
                    message: 'Pelanggan berhasil diperbarui.',
                })
            },
        })
    } else {
        formPelanggan.post('/pelanggan', {
            preserveScroll: true,
            onSuccess: () => {
                showModalPelanggan.value = false

                formPelanggan.reset()
                formPelanggan.aktif = true
                formPelanggan.tingkat_harga = 'Umum'
                tampilkanNotifikasi({
                    type: 'success',
                    message: 'Pelanggan berhasil ditambahkan.',
                })
            },
        })
    }
}

const simpanKendaraan = () => {
    if (props.pelanggans.length === 0) {
        formKendaraan.setError(
            'pelanggan_id',
            'Tambahkan pelanggan terlebih dahulu sebelum menambah kendaraan.',
        )
        return
    }

    formKendaraan.post('/kendaraan', {
        preserveScroll: true,
        onSuccess: () => {
            showModalKendaraan.value = false
            formKendaraan.reset()
            formKendaraan.clearErrors()
            tampilkanNotifikasi({
                type: 'success',
                message: 'Kendaraan berhasil ditambahkan.',
            })
        },
    })
}

const bukaModalPelangganDariKendaraan = () => {
    showModalKendaraan.value = false
    activeTab.value = 'daftar'
    activeSubTab.value = 'pelanggan'

    pelangganDieditId.value = null
    formPelanggan.reset()
    formPelanggan.clearErrors()
    formPelanggan.aktif = true
    formPelanggan.tingkat_harga = 'Umum'
    showModalPelanggan.value = true
}

const tutupModal = () => {
    showModalPelanggan.value = false
    showModalKendaraan.value = false

    formPelanggan.clearErrors()
    formKendaraan.clearErrors()

    pelangganDieditId.value = null
}
</script>

<template>
    <div class="min-h-screen bg-[#f6f8fb] p-5">

        <!-- ACTION HEADER -->
        <div class="mb-5 flex flex-wrap items-center justify-end gap-3">

            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
            >
                <FileDown :size="17" />
                Dokumen
            </button>

            <button
                v-if="activeTab === 'daftar'"
                type="button"
                @click="bukaModalTambahPelanggan"
                class="relative z-10 inline-flex cursor-pointer items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
            >
                <Plus :size="17" />
                {{ judulAksi }}
            </button>

        </div>

        <Teleport to="body">
            <div
                v-if="notification"
                class="fixed right-4 top-4 z-[200] flex w-[calc(100%-2rem)] max-w-sm items-start justify-between gap-4 rounded-xl border bg-white p-4 shadow-lg"
                :class="notification.type === 'error'
                    ? 'border-red-200 text-red-800'
                    : 'border-emerald-200 text-emerald-800'"
                :role="notification.type === 'error' ? 'alert' : 'status'"
                aria-live="polite"
            >
                <p class="text-sm font-medium">{{ notification.message }}</p>
                <button
                    type="button"
                    aria-label="Tutup notifikasi"
                    @click="tutupNotifikasi"
                    class="shrink-0 rounded-md p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                >
                    <X :size="16" />
                </button>
            </div>
        </Teleport>

        <!-- SUMMARY COUNTERS -->
        <div class="mb-5 flex flex-wrap gap-2">

            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="text-sm font-bold text-slate-800">
                    {{ props.pelanggans.length }}
                </span>
                <span class="ml-2 text-sm text-slate-500">
                    pelanggan
                </span>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                <span class="text-sm font-bold text-slate-800">
                    {{ props.kendaraans.length }}
                </span>
                <span class="ml-2 text-sm text-slate-500">
                    kendaraan
                </span>
            </div>

        </div>

        <!-- MAIN TABS -->
        <div class="mb-4 flex gap-1 overflow-x-auto border-b border-slate-200">

            <button
                v-for="tab in tabs"
                :key="tab.id"
                type="button"
                @click="ubahTab(tab.id)"
                class="inline-flex shrink-0 items-center gap-2 border-b-2 px-4 py-3 text-sm font-medium transition"
                :class="activeTab === tab.id
                    ? 'border-emerald-600 text-emerald-700'
                    : 'border-transparent text-slate-500 hover:text-slate-800'"
            >
                <component :is="tab.icon" :size="17" />
                {{ tab.label }}
            </button>

        </div>

        <!-- SUB TABS -->
        <div
            v-if="activeTab === 'daftar'"
            class="mb-4 inline-flex rounded-xl bg-slate-100 p-1"
        >

            <button
                type="button"
                @click="activeSubTab = 'pelanggan'"
                class="rounded-lg px-4 py-2 text-sm font-medium transition"
                :class="activeSubTab === 'pelanggan'
                    ? 'bg-white text-emerald-700 shadow-sm'
                    : 'text-slate-500 hover:text-slate-800'"
            >
                Daftar Pelanggan
            </button>

            <button
                type="button"
                @click="activeSubTab = 'ringkasan'"
                class="rounded-lg px-4 py-2 text-sm font-medium transition"
                :class="activeSubTab === 'ringkasan'
                    ? 'bg-white text-emerald-700 shadow-sm'
                    : 'text-slate-500 hover:text-slate-800'"
            >
                Ringkasan
            </button>

        </div>

        <!-- CONTENT -->
        <DaftarPelanggan
            v-if="activeTab === 'daftar' && activeSubTab === 'pelanggan'"
            :pelanggans="props.pelanggans"
            :kendaraans="props.kendaraans"
            @edit-pelanggan="editPelanggan"
            @tambah-kendaraan="bukaModalTambahKendaraan"
            @notify="tampilkanNotifikasi"
        />

        <RingkasanPelanggan
            v-else-if="activeTab === 'daftar' && activeSubTab === 'ringkasan'"
        />

        <DaftarKendaraan
            v-else-if="activeTab === 'kendaraan'"
            :kendaraans="props.kendaraans"
        />

        <TagihanPelanggan
            v-else-if="activeTab === 'tagihan'"
        />

        <!-- MODAL PELANGGAN -->
        <Teleport to="body">
            <div
                v-if="showModalPelanggan"
                class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-950/50 p-4 backdrop-blur-[2px]"
                @click.self="tutupModal"
                @keydown.esc="tutupModal"
            >
                <div class="my-auto w-full max-w-xl overflow-hidden rounded-3xl bg-white shadow-2xl">

                    <div class="flex items-center justify-between border-b border-slate-100 px-7 py-5">

                        <h2 class="text-xl font-semibold text-slate-900">
                            {{ modeEditPelanggan ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}
                        </h2>

                        <button
                            type="button"
                            @click="tutupModal"
                            class="rounded-full bg-slate-100 p-2.5 text-slate-500 transition hover:bg-slate-200"
                        >
                            <X :size="20" />
                        </button>

                    </div>

                    <form @submit.prevent="simpanPelanggan">

                        <div class="space-y-5 px-7 py-6">

                            <div>
                                <label class="mb-2 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                    Nama pelanggan
                                    <span class="text-red-500">*</span>
                                    <Info :size="15" class="text-slate-400" />
                                </label>

                                <input
                                    v-model="formPelanggan.nama"
                                    type="text"
                                    autofocus
                                    placeholder="Masukkan nama pelanggan"
                                    class="w-full rounded-xl border px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                    :class="formPelanggan.errors.nama ? 'border-red-400' : 'border-slate-200'"
                                />

                                <p
                                    v-if="formPelanggan.errors.nama"
                                    class="mt-1.5 text-xs text-red-500"
                                >
                                    {{ formPelanggan.errors.nama }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                    Nomor HP / WhatsApp
                                    <Info :size="15" class="text-slate-400" />
                                </label>

                                <input
                                    v-model="formPelanggan.no_hp"
                                    type="text"
                                    placeholder="0812-3456-7890"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                />

                                <p class="mt-1.5 text-xs text-slate-500">
                                    Contoh: 0812-3456-7890 — boleh diketik 08..., 62..., atau +62....
                                </p>

                                <p
                                    v-if="formPelanggan.errors.no_hp"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ formPelanggan.errors.no_hp }}
                                </p>
                            </div>

                            <div>
                                <label class="mb-2 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                    Alamat
                                    <Info :size="15" class="text-slate-400" />
                                </label>

                                <textarea
                                    v-model="formPelanggan.alamat"
                                    rows="2"
                                    placeholder="Masukkan alamat pelanggan"
                                    class="w-full resize-none rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                />
                            </div>

                            <div>
                                <label class="mb-2 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                    Tingkat harga
                                    <Info :size="15" class="text-slate-400" />
                                </label>

                                <select
                                    v-model="formPelanggan.tingkat_harga"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                >
                                    <option value="Umum">Umum</option>
                                    <option value="Grosir">Grosir</option>
                                    <option value="Distributor">Distributor</option>
                                </select>
                            </div>

                            <label class="flex cursor-pointer items-center gap-3">
                                <input
                                    v-model="formPelanggan.aktif"
                                    type="checkbox"
                                    class="h-5 w-5 rounded accent-emerald-600"
                                />

                                <span class="text-sm text-slate-700">
                                    Pelanggan masih aktif
                                </span>

                                <Info :size="15" class="text-slate-400" />
                            </label>

                        </div>

                        <div class="flex justify-end gap-3 border-t border-slate-100 px-7 py-5">

                            <button
                                type="button"
                                @click="tutupModal"
                                class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                            >
                                Batal
                            </button>

                            <button
                                type="submit"
                                :disabled="formPelanggan.processing"
                                class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-60"
                            >
                                {{
                                    formPelanggan.processing
                                        ? 'Menyimpan...'
                                        : modeEditPelanggan
                                            ? 'Simpan Perubahan'
                                            : 'Simpan'
                                }}
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </Teleport>

        <!-- MODAL KENDARAAN -->
        <Teleport to="body">
            <div
                v-if="showModalKendaraan"
                class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-950/50 p-4 backdrop-blur-[2px]"
                @click.self="tutupModal"
                @keydown.esc="tutupModal"
            >
                <div class="my-auto w-full max-w-2xl overflow-hidden rounded-3xl bg-white shadow-2xl">

                    <div class="border-b border-slate-100 px-7 py-5">

                        <div class="flex items-center justify-between">

                            <h2 class="text-xl font-semibold text-slate-900">
                                Tambah Kendaraan
                            </h2>

                            <button
                                type="button"
                                @click="tutupModal"
                                class="rounded-full bg-slate-100 p-2.5 text-slate-500 transition hover:bg-slate-200"
                            >
                                <X :size="20" />
                            </button>

                        </div>

                        <p class="mt-1 text-sm text-slate-500">
                            Masukkan informasi kendaraan pelanggan.
                        </p>

                    </div>

                    <form @submit.prevent="simpanKendaraan">

                        <div class="space-y-5 px-7 py-6">

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Pemilik kendaraan
                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    v-model="formKendaraan.pelanggan_id"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                >
                                    <option value="">Pilih pelanggan</option>

                                    <option
                                        v-for="pelanggan in props.pelanggans"
                                        :key="pelanggan.id"
                                        :value="pelanggan.id"
                                    >
                                        {{ pelanggan.nama }}
                                    </option>

                                </select>

                                <p
                                    v-if="formKendaraan.errors.pelanggan_id"
                                    class="mt-1.5 text-xs text-red-500"
                                >
                                    {{ formKendaraan.errors.pelanggan_id }}
                                </p>

                                <button
                                    v-if="props.pelanggans.length === 0"
                                    type="button"
                                    @click="bukaModalPelangganDariKendaraan"
                                    class="mt-2 text-xs font-semibold text-emerald-700 hover:text-emerald-800"
                                >
                                    Tambah pelanggan terlebih dahulu
                                </button>
                            </div>

                            <div>
                                <label class="mb-2 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                    Nomor Polisi
                                    <span class="text-red-500">*</span>
                                    <Info :size="15" class="text-slate-400" />
                                </label>

                                <input
                                    v-model="formKendaraan.nomor_polisi"
                                    type="text"
                                    required
                                    placeholder="B 1234 ABC"
                                    class="w-full rounded-xl border px-4 py-3 text-sm uppercase outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                    :class="formKendaraan.errors.nomor_polisi ? 'border-red-400' : 'border-slate-200'"
                                />

                                <p class="mt-1.5 text-xs text-slate-500">
                                    Contoh: B 1234 XYZ — huruf depan 1–2, angka 1–4, huruf belakang 1–3.
                                </p>

                                <p
                                    v-if="formKendaraan.errors.nomor_polisi"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ formKendaraan.errors.nomor_polisi }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                <div>
                                    <label class="mb-2 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                        Merek
                                        <Info :size="15" class="text-slate-400" />
                                    </label>

                                    <input
                                        v-model="formKendaraan.merek"
                                        type="text"
                                        placeholder="Toyota"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                    />
                                </div>

                                <div>
                                    <label class="mb-2 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                        Tipe
                                        <Info :size="15" class="text-slate-400" />
                                    </label>

                                    <input
                                        v-model="formKendaraan.tipe"
                                        type="text"
                                        placeholder="Avanza"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                    />
                                </div>

                                <div>
                                    <label class="mb-2 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                        Tahun
                                        <Info :size="15" class="text-slate-400" />
                                    </label>

                                    <input
                                        v-model="formKendaraan.tahun"
                                        type="number"
                                        min="1900"
                                        max="2100"
                                        placeholder="Opsional, mis. 2022"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                    />

                                    <p
                                        v-if="formKendaraan.errors.tahun"
                                        class="mt-1 text-xs text-red-500"
                                    >
                                        {{ formKendaraan.errors.tahun }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                        Warna
                                        <Info :size="15" class="text-slate-400" />
                                    </label>

                                    <input
                                        v-model="formKendaraan.warna"
                                        type="text"
                                        placeholder="Hitam"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                    />
                                </div>

                            </div>

                            <div>
                                <label class="mb-2 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                    Catatan
                                    <Info :size="15" class="text-slate-400" />
                                </label>

                                <textarea
                                    v-model="formKendaraan.catatan"
                                    rows="3"
                                    placeholder="Tambahkan catatan kendaraan jika diperlukan"
                                    class="w-full resize-none rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                />

                                <p class="mt-1.5 text-xs text-slate-400">
                                    Shift+Enter untuk baris baru
                                </p>
                            </div>

                        </div>

                        <div class="flex justify-end gap-3 border-t border-slate-100 px-7 py-5">

                            <button
                                type="button"
                                @click="tutupModal"
                                class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                            >
                                Batal
                            </button>

                            <button
                                type="submit"
                                :disabled="formKendaraan.processing"
                                class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-60"
                            >
                                {{ formKendaraan.processing ? 'Menyimpan...' : 'Simpan Kendaraan' }}
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </Teleport>

    </div>
</template>


<script setup>
import { computed } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import {
    ArrowLeft,
    Save,
    Wrench,
    Clock3,
    Tag,
    Wallet,
    CircleDollarSign,
    FileText,
} from 'lucide-vue-next'

defineOptions({ layout: AppLayout })

const props = defineProps({
    kategoriJasa: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    nama: '',
    kategori_jasa_id: '',
    estimasi_menit: '',
    harga_standar: '',
    modal: 0,
    keterangan: '',
    aktif: true,
})

// KODE OTOMATIS
const kodeJasa = computed(() => 'JS-XXXX')

const formatRupiah = (value) => {
    if (value === '' || value === null || value === undefined) return ''
    return new Intl.NumberFormat('id-ID').format(value)
}

const ubahNominal = (field, value) => {
    const angka = String(value).replace(/\D/g, '')
    form[field] = angka === '' ? '' : Number(angka)
}

const simpanJasa = () => {
    form.post('/jasa-servis', {
        preserveScroll: true,
    })
}

const kembali = () => {
    router.visit('/jasa-servis')
}
</script>

<template>
    <div class="mx-auto max-w-5xl space-y-6">

        <!-- HEADER HALAMAN -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <button
                    type="button"
                    @click="kembali"
                    class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-emerald-600"
                >
                    <ArrowLeft :size="17" />
                    Kembali ke daftar jasa
                </button>

                <h1 class="text-2xl font-bold tracking-tight text-slate-800">
                    Tambah Jasa Servis
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Tambahkan jenis layanan servis baru ke daftar jasa bengkel.
                </p>
            </div>
        </div>

        <form @submit.prevent="simpanJasa" class="space-y-6">

            <!-- INFORMASI JASA -->
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <Wrench :size="20" />
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Informasi Jasa
                        </h2>
                        <p class="text-xs text-slate-500">
                            Informasi dasar layanan servis
                        </p>
                    </div>
                </div>

                <div class="grid gap-5 p-6 md:grid-cols-2">

                    <!-- KODE JASA -->
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Kode Jasa
                        </label>

                        <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <Tag :size="17" class="text-slate-400" />

                            <div>
                                <p class="text-sm font-semibold text-slate-700">
                                    {{ kodeJasa }}
                                </p>
                                <p class="text-xs text-slate-400">
                                    Kode dibuat otomatis saat data disimpan
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- NAMA JASA -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Nama Jasa <span class="text-red-500">*</span>
                        </label>

                        <input
                            v-model="form.nama"
                            type="text"
                            placeholder="Contoh: Ganti Oli Mesin"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            :class="{ 'border-red-400': form.errors.nama }"
                        />

                        <p v-if="form.errors.nama" class="mt-1.5 text-xs text-red-500">
                            {{ form.errors.nama }}
                        </p>
                    </div>

                    <!-- KATEGORI -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Kategori Jasa
                        </label>

                        <select
                            v-model="form.kategori_jasa_id"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            :class="{ 'border-red-400': form.errors.kategori_jasa_id }"
                        >
                            <option value="">Pilih kategori jasa</option>

                            <option
                                v-for="kategori in kategoriJasa"
                                :key="kategori.id"
                                :value="kategori.id"
                            >
                                {{ kategori.nama }}
                            </option>
                        </select>

                        <p v-if="form.errors.kategori_jasa_id" class="mt-1.5 text-xs text-red-500">
                            {{ form.errors.kategori_jasa_id }}
                        </p>
                    </div>

                    <!-- ESTIMASI -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Estimasi Pengerjaan
                        </label>

                        <div class="relative">
                            <Clock3
                                :size="17"
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                            />

                            <input
                                v-model="form.estimasi_menit"
                                type="number"
                                min="1"
                                placeholder="Contoh: 30"
                                class="w-full rounded-xl border border-slate-200 py-3 pl-11 pr-16 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                :class="{ 'border-red-400': form.errors.estimasi_menit }"
                            />

                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400">
                                Menit
                            </span>
                        </div>

                        <p v-if="form.errors.estimasi_menit" class="mt-1.5 text-xs text-red-500">
                            {{ form.errors.estimasi_menit }}
                        </p>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Status Jasa
                        </label>

                        <button
                            type="button"
                            @click="form.aktif = !form.aktif"
                            class="flex w-full items-center justify-between rounded-xl border border-slate-200 px-4 py-3 transition hover:bg-slate-50"
                        >
                            <span class="text-sm font-medium text-slate-700">
                                {{ form.aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>

                            <span
                                class="relative h-6 w-11 rounded-full transition"
                                :class="form.aktif ? 'bg-emerald-500' : 'bg-slate-300'"
                            >
                                <span
                                    class="absolute top-1 h-4 w-4 rounded-full bg-white shadow-sm transition-all"
                                    :class="form.aktif ? 'left-6' : 'left-1'"
                                ></span>
                            </span>
                        </button>
                    </div>

                </div>
            </div>

            <!-- INFORMASI HARGA -->
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <Wallet :size="20" />
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Informasi Harga
                        </h2>
                        <p class="text-xs text-slate-500">
                            Atur modal dan harga layanan
                        </p>
                    </div>
                </div>

                <div class="grid gap-5 p-6 md:grid-cols-2">

                    <!-- MODAL -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Modal Jasa
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400">
                                Rp
                            </span>

                            <input
                                type="text"
                                inputmode="numeric"
                                :value="formatRupiah(form.modal)"
                                @input="ubahNominal('modal', $event.target.value)"
                                placeholder="0"
                                class="w-full rounded-xl border border-slate-200 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                :class="{ 'border-red-400': form.errors.modal }"
                            />
                        </div>

                        <p v-if="form.errors.modal" class="mt-1.5 text-xs text-red-500">
                            {{ form.errors.modal }}
                        </p>
                    </div>

                    <!-- HARGA STANDAR -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Harga Standar <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400">
                                Rp
                            </span>

                            <input
                                type="text"
                                inputmode="numeric"
                                :value="formatRupiah(form.harga_standar)"
                                @input="ubahNominal('harga_standar', $event.target.value)"
                                placeholder="0"
                                class="w-full rounded-xl border border-slate-200 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                :class="{ 'border-red-400': form.errors.harga_standar }"
                            />
                        </div>

                        <p v-if="form.errors.harga_standar" class="mt-1.5 text-xs text-red-500">
                            {{ form.errors.harga_standar }}
                        </p>
                    </div>

                </div>
            </div>

            <!-- KETERANGAN -->
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <FileText :size="20" />
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Keterangan Tambahan
                        </h2>
                        <p class="text-xs text-slate-500">
                            Informasi tambahan mengenai jasa servis
                        </p>
                    </div>
                </div>

                <div class="p-6">
                    <textarea
                        v-model="form.keterangan"
                        rows="4"
                        placeholder="Tambahkan keterangan jasa servis jika diperlukan..."
                        class="w-full resize-none rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        :class="{ 'border-red-400': form.errors.keterangan }"
                    ></textarea>

                    <p v-if="form.errors.keterangan" class="mt-1.5 text-xs text-red-500">
                        {{ form.errors.keterangan }}
                    </p>
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">

                <button
                    type="button"
                    @click="kembali"
                    class="rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-7 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <Save :size="17" />
                    {{ form.processing ? 'Menyimpan...' : 'Simpan Jasa Servis' }}
                </button>

            </div>

        </form>
    </div>
</template>

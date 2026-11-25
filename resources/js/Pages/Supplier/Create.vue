
<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import {
    ArrowLeft,
    Save,
    Building2,
    User,
    Phone,
    MapPin,
    CreditCard,
    Truck,
    FileText,
} from 'lucide-vue-next'

defineOptions({
    layout: AppLayout,
})

const form = useForm({
    nama_supplier: '',
    nama_kontak: '',
    telepon: '',
    alamat: '',
    tempo_bayar: 0,
    lama_pengiriman: 0,
    nama_bank: '',
    nomor_rekening: '',
    atas_nama: '',
    catatan: '',
})

const kembali = () => {
    router.visit('/supplier')
}

const simpan = (aksi = 'selesai') => {
    form.transform((data) => ({
        ...data,
        aksi,
    })).post('/supplier', {
        preserveScroll: true,
        onSuccess: () => {
            if (aksi === 'tambah_lagi') {
                form.reset()
                form.clearErrors()
            }
        },
    })
}
</script>

<template>
    <Head title="Tambah Supplier" />

    <div class="space-y-6 pb-10">
        <!-- Judul halaman -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <button
                    type="button"
                    @click="kembali"
                    class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 transition hover:bg-gray-50"
                >
                    <ArrowLeft class="h-4 w-4" />
                </button>

                <div>
                    <h1 class="text-xl font-bold text-gray-900">
                        Tambah Supplier
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Tambahkan data supplier baru ke daftar supplier bengkel.
                    </p>
                </div>
            </div>
        </div>

        <form @submit.prevent="simpan('selesai')" class="space-y-5">
            <!-- Informasi Supplier -->
            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <Building2 class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">Informasi Supplier</h2>
                        <p class="text-xs text-gray-500">Identitas dan informasi kontak supplier</p>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Nama Supplier <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.nama_supplier"
                            type="text"
                            placeholder="Contoh: CV Sumber Makmur"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            :class="{ 'border-red-400': form.errors.nama_supplier }"
                        />
                        <p v-if="form.errors.nama_supplier" class="mt-1 text-xs text-red-500">
                            {{ form.errors.nama_supplier }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Nama Kontak
                        </label>
                        <div class="relative">
                            <User class="absolute left-3 top-3.5 h-4 w-4 text-gray-400" />
                            <input
                                v-model="form.nama_kontak"
                                type="text"
                                placeholder="Nama orang yang bisa dihubungi"
                                class="w-full rounded-xl border border-gray-200 py-3 pl-10 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <Phone class="absolute left-3 top-3.5 h-4 w-4 text-gray-400" />
                            <input
                                v-model="form.telepon"
                                type="text"
                                placeholder="Contoh: 081234567890"
                                class="w-full rounded-xl border border-gray-200 py-3 pl-10 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            />
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Alamat Supplier
                        </label>
                        <div class="relative">
                            <MapPin class="absolute left-3 top-3.5 h-4 w-4 text-gray-400" />
                            <textarea
                                v-model="form.alamat"
                                rows="3"
                                placeholder="Masukkan alamat lengkap supplier"
                                class="w-full resize-none rounded-xl border border-gray-200 py-3 pl-10 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            ></textarea>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Informasi Pembelian -->
            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <Truck class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">Informasi Pembelian</h2>
                        <p class="text-xs text-gray-500">Atur ketentuan pembayaran dan pengiriman</p>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Tempo Pembayaran
                        </label>
                        <div class="relative">
                            <input
                                v-model="form.tempo_bayar"
                                type="number"
                                min="0"
                                placeholder="0"
                                class="w-full rounded-xl border border-gray-200 px-4 py-3 pr-16 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            />
                            <span class="absolute right-4 top-3.5 text-xs text-gray-400">Hari</span>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Lama Pengiriman
                        </label>
                        <div class="relative">
                            <input
                                v-model="form.lama_pengiriman"
                                type="number"
                                min="0"
                                placeholder="0"
                                class="w-full rounded-xl border border-gray-200 px-4 py-3 pr-16 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            />
                            <span class="absolute right-4 top-3.5 text-xs text-gray-400">Hari</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Informasi Rekening -->
            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <CreditCard class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">Informasi Rekening</h2>
                        <p class="text-xs text-gray-500">Informasi rekening bank milik supplier</p>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Nama Bank
                        </label>
                        <input
                            v-model="form.nama_bank"
                            type="text"
                            placeholder="Contoh: BCA"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Nomor Rekening
                        </label>
                        <input
                            v-model="form.nomor_rekening"
                            type="text"
                            placeholder="Masukkan nomor rekening"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        />
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Atas Nama
                        </label>
                        <input
                            v-model="form.atas_nama"
                            type="text"
                            placeholder="Nama pemilik rekening"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        />
                    </div>
                </div>
            </section>

            <!-- Catatan -->
            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                        <FileText class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">Catatan</h2>
                        <p class="text-xs text-gray-500">Informasi tambahan mengenai supplier</p>
                    </div>
                </div>

                <div class="p-5">
                    <textarea
                        v-model="form.catatan"
                        rows="4"
                        placeholder="Tambahkan catatan jika diperlukan..."
                        class="w-full resize-none rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    ></textarea>
                </div>
            </section>

            <!-- Tombol -->
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    @click="kembali"
                    class="rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
                >
                    Batal
                </button>

                <button
                    type="button"
                    @click="simpan('tambah_lagi')"
                    :disabled="form.processing"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Simpan & Tambah Lagi
                </button>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <Save class="h-4 w-4" />
                    {{ form.processing ? 'Menyimpan...' : 'Simpan Supplier' }}
                </button>
            </div>
        </form>
    </div>
</template>

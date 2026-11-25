
<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import {
    ArrowLeft,
    Building2,
    User,
    Phone,
    MapPin,
    CreditCard,
    Truck,
    FileText,
    Save,
} from 'lucide-vue-next'

defineOptions({
    layout: AppLayout,
})

const props = defineProps({
    supplier: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    nama_supplier: props.supplier.nama_supplier ?? '',
    nama_kontak: props.supplier.nama_kontak ?? '',
    telepon: props.supplier.telepon ?? '',
    alamat: props.supplier.alamat ?? '',
    tempo_bayar: props.supplier.tempo_bayar ?? 0,
    lama_pengiriman: props.supplier.lama_pengiriman ?? 0,
    nama_bank: props.supplier.nama_bank ?? '',
    nomor_rekening: props.supplier.nomor_rekening ?? '',
    atas_nama: props.supplier.atas_nama ?? '',
    catatan: props.supplier.catatan ?? '',
})

const kembali = () => {
    router.visit('/supplier')
}

const simpan = () => {
    form.put(`/supplier/${props.supplier.id}`, {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Ubah Supplier" />

    <div class="space-y-6">
        <!-- HEADER -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <button
                    type="button"
                    @click="kembali"
                    class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-emerald-600"
                >
                    <ArrowLeft :size="17" />
                    Kembali ke daftar supplier
                </button>

                <h1 class="text-xl font-bold text-slate-800">
                    Ubah Supplier
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Perbarui informasi supplier {{ supplier.nama_supplier }}.
                </p>
            </div>
        </div>

        <form @submit.prevent="simpan" class="space-y-5">

            <!-- INFORMASI SUPPLIER -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 md:p-6">
                <div class="mb-5 flex items-center gap-3">
                    <div class="rounded-xl bg-emerald-50 p-2.5 text-emerald-600">
                        <Building2 :size="20" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Informasi Supplier
                        </h2>
                        <p class="text-xs text-slate-400">
                            Informasi dasar supplier
                        </p>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Nama Supplier <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.nama_supplier"
                            type="text"
                            placeholder="Masukkan nama supplier"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        />
                        <p v-if="form.errors.nama_supplier" class="mt-1 text-xs text-red-500">
                            {{ form.errors.nama_supplier }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Nama Kontak
                        </label>
                        <div class="relative">
                            <User :size="17" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                            <input
                                v-model="form.nama_kontak"
                                type="text"
                                placeholder="Nama kontak person"
                                class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            />
                        </div>
                        <p v-if="form.errors.nama_kontak" class="mt-1 text-xs text-red-500">
                            {{ form.errors.nama_kontak }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <Phone :size="17" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                            <input
                                v-model="form.telepon"
                                type="text"
                                placeholder="Nomor telepon supplier"
                                class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            />
                        </div>
                        <p v-if="form.errors.telepon" class="mt-1 text-xs text-red-500">
                            {{ form.errors.telepon }}
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Alamat
                        </label>
                        <div class="relative">
                            <MapPin :size="17" class="absolute left-3 top-3 text-slate-400" />
                            <textarea
                                v-model="form.alamat"
                                rows="3"
                                placeholder="Alamat lengkap supplier"
                                class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                            ></textarea>
                        </div>
                        <p v-if="form.errors.alamat" class="mt-1 text-xs text-red-500">
                            {{ form.errors.alamat }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- INFORMASI PEMBELIAN -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 md:p-6">
                <div class="mb-5 flex items-center gap-3">
                    <div class="rounded-xl bg-blue-50 p-2.5 text-blue-600">
                        <Truck :size="20" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Informasi Pembelian
                        </h2>
                        <p class="text-xs text-slate-400">
                            Pengaturan pembayaran dan pengiriman
                        </p>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Tempo Pembayaran (Hari)
                        </label>
                        <input
                            v-model="form.tempo_bayar"
                            type="number"
                            min="0"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        />
                        <p v-if="form.errors.tempo_bayar" class="mt-1 text-xs text-red-500">
                            {{ form.errors.tempo_bayar }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Lama Pengiriman (Hari)
                        </label>
                        <input
                            v-model="form.lama_pengiriman"
                            type="number"
                            min="0"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        />
                        <p v-if="form.errors.lama_pengiriman" class="mt-1 text-xs text-red-500">
                            {{ form.errors.lama_pengiriman }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- INFORMASI REKENING -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 md:p-6">
                <div class="mb-5 flex items-center gap-3">
                    <div class="rounded-xl bg-violet-50 p-2.5 text-violet-600">
                        <CreditCard :size="20" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Informasi Rekening
                        </h2>
                        <p class="text-xs text-slate-400">
                            Informasi rekening pembayaran supplier
                        </p>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Nama Bank
                        </label>
                        <input
                            v-model="form.nama_bank"
                            type="text"
                            placeholder="Contoh: BCA"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        />
                        <p v-if="form.errors.nama_bank" class="mt-1 text-xs text-red-500">
                            {{ form.errors.nama_bank }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Nomor Rekening
                        </label>
                        <input
                            v-model="form.nomor_rekening"
                            type="text"
                            placeholder="Nomor rekening"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        />
                        <p v-if="form.errors.nomor_rekening" class="mt-1 text-xs text-red-500">
                            {{ form.errors.nomor_rekening }}
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Atas Nama
                        </label>
                        <input
                            v-model="form.atas_nama"
                            type="text"
                            placeholder="Nama pemilik rekening"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        />
                        <p v-if="form.errors.atas_nama" class="mt-1 text-xs text-red-500">
                            {{ form.errors.atas_nama }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- CATATAN -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 md:p-6">
                <div class="mb-5 flex items-center gap-3">
                    <div class="rounded-xl bg-amber-50 p-2.5 text-amber-600">
                        <FileText :size="20" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Catatan
                        </h2>
                        <p class="text-xs text-slate-400">
                            Informasi tambahan mengenai supplier
                        </p>
                    </div>
                </div>

                <textarea
                    v-model="form.catatan"
                    rows="4"
                    placeholder="Tambahkan catatan jika diperlukan..."
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                ></textarea>
                <p v-if="form.errors.catatan" class="mt-1 text-xs text-red-500">
                    {{ form.errors.catatan }}
                </p>
            </div>

            <!-- BUTTON -->
            <div class="flex flex-wrap justify-end gap-3">
                <button
                    type="button"
                    @click="kembali"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <Save :size="17" />
                    {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                </button>
            </div>

        </form>
    </div>
</template>

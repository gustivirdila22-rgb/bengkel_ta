
<script setup>
import { watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { X, Tag } from 'lucide-vue-next'

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    kategori: {
        type: Object,
        default: null,
    },
})

const emit = defineEmits(['close', 'saved'])

const form = useForm({
    nama: '',
})

watch(
    () => [props.show, props.kategori],
    ([show, kategori]) => {
        if (!show) return

        form.clearErrors()

        form.nama = kategori?.nama ?? ''
    },
    { immediate: true },
)

const simpan = () => {
    const options = {
        preserveScroll: true,
        onSuccess: () => {
            emit('saved')
            form.reset()
        },
    }

    if (props.kategori) {
        form.put(`/kategori-jasa/${props.kategori.id}`, options)
    } else {
        form.post('/kategori-jasa', options)
    }
}

const tutup = () => {
    if (form.processing) return

    form.reset()
    form.clearErrors()
    emit('close')
}
</script>

<template>
    <Teleport to="body">
        <div
            v-if="show"
            class="fixed inset-0 z-[110] flex items-center justify-center bg-slate-950/50 p-4 backdrop-blur-[2px]"
            @click.self="tutup"
            @keydown.esc="tutup"
        >
            <div class="w-full max-w-md overflow-hidden rounded-3xl bg-white shadow-2xl">

                <!-- HEADER -->
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            {{ kategori ? 'Edit Kategori' : 'Tambah Kategori' }}
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Masukkan nama kategori jasa servis.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="tutup"
                        class="rounded-full bg-slate-100 p-2.5 text-slate-500 transition hover:bg-slate-200"
                    >
                        <X :size="19" />
                    </button>
                </div>

                <!-- FORM -->
                <form @submit.prevent="simpan">
                    <div class="p-6">
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Nama Kategori
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">
                            <Tag
                                :size="17"
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                            />

                            <input
                                v-model="form.nama"
                                type="text"
                                required
                                autofocus
                                placeholder="Contoh: Servis Mesin"
                                class="w-full rounded-xl border px-4 py-3 pl-11 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                :class="form.errors.nama
                                    ? 'border-red-400'
                                    : 'border-slate-200'"
                            />
                        </div>

                        <p
                            v-if="form.errors.nama"
                            class="mt-1.5 text-xs text-red-500"
                        >
                            {{ form.errors.nama }}
                        </p>
                    </div>

                    <!-- FOOTER -->
                    <div class="flex justify-end gap-3 border-t border-slate-100 px-6 py-5">
                        <button
                            type="button"
                            @click="tutup"
                            :disabled="form.processing"
                            class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:opacity-50"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Kategori' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Teleport>
</template>

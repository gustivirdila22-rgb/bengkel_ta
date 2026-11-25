
<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { FileDown, Plus } from 'lucide-vue-next'

const props = defineProps({
    activeTab: {
        type: String,
        default: 'daftar',
    },
})

const emit = defineEmits(['update:activeTab'])

const tabs = [
    { id: 'daftar', label: 'Daftar & Ringkasan' },
    { id: 'kategori', label: 'Kategori' },
    { id: 'paling-laku', label: 'Paling Laku' },
]

const tabAktif = computed({
    get: () => props.activeTab,
    set: (value) => emit('update:activeTab', value),
})

const tambahJasa = () => {
    router.visit('/jasa-servis/create')
}
</script>

<template>
    <div class="mb-4 flex items-center justify-between gap-4 border-b border-slate-200">

        <!-- TAB DI KIRI -->
        <div class="flex gap-1 overflow-x-auto">
            <button
                v-for="tab in tabs"
                :key="tab.id"
                type="button"
                @click="tabAktif = tab.id"
                class="shrink-0 border-b-2 px-4 py-3 text-sm font-medium transition"
                :class="tabAktif === tab.id
                    ? 'border-emerald-600 text-emerald-700'
                    : 'border-transparent text-slate-500 hover:text-slate-800'"
            >
                {{ tab.label }}
            </button>
        </div>

        <!-- TOMBOL DI POJOK KANAN -->
      <div class="flex shrink-0 items-center gap-2 -mt-40">

            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
            >
                <FileDown :size="17" />
                Dokumen
            </button>

            <button
                type="button"
                @click="tambahJasa"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
            >
                <Plus :size="18" />
                Tambah Jasa Servis
            </button>

        </div>

    </div>
</template>

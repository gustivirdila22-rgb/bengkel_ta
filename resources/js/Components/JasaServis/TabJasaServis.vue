
<script setup>
import { computed } from 'vue'

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
</script>

<template>
    <div class="mb-4 flex gap-1 overflow-x-auto border-b border-slate-200">

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
</template>

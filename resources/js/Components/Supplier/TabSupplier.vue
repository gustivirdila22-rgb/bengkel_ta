
<script setup>
defineProps({
    activeTab: {
        type: String,
        default: 'daftar',
    },
    activeSubTab: {
        type: String,
        default: 'daftar',
    },
})

const emit = defineEmits(['change-tab', 'change-sub-tab'])

const tabs = [
    { id: 'daftar', label: 'Daftar & Ringkasan' },
    { id: 'utang', label: 'Kartu Utang' },
    { id: 'kinerja', label: 'Harga & Kinerja' },
]

const subTabs = {
    daftar: [
        { id: 'daftar', label: 'Daftar Supplier' },
        { id: 'ringkasan', label: 'Ringkasan' },
    ],
    kinerja: [
        { id: 'kinerja', label: 'Kinerja Supplier' },
        { id: 'harga', label: 'Harga Beli' },
        { id: 'analisa', label: 'Analisa Harga Beli' },
    ],
}
</script>

<template>
    <div class="border-b border-slate-200">
        <div class="flex flex-wrap items-center gap-2">
            <button
                v-for="tab in tabs"
                :key="tab.id"
                type="button"
                @click="emit('change-tab', tab.id)"
                class="relative px-4 py-3 text-sm font-medium transition"
                :class="activeTab === tab.id
                    ? 'text-emerald-600'
                    : 'text-slate-500 hover:text-slate-800'"
            >
                {{ tab.label }}

                <span
                    v-if="activeTab === tab.id"
                    class="absolute bottom-0 left-0 h-0.5 w-full rounded-full bg-emerald-600"
                />
            </button>
        </div>

        <div
            v-if="subTabs[activeTab]"
            class="flex flex-wrap items-center gap-2 py-3"
        >
            <button
                v-for="tab in subTabs[activeTab]"
                :key="tab.id"
                type="button"
                @click="emit('change-sub-tab', tab.id)"
                class="rounded-xl px-4 py-2.5 text-sm font-medium transition"
                :class="activeSubTab === tab.id
                    ? 'border border-slate-200 bg-white text-emerald-600 shadow-sm'
                    : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
            >
                {{ tab.label }}
            </button>
        </div>
    </div>
</template>

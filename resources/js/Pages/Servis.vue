
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'

import ServisAktif from '@/Components/Servis/ServisAktif.vue'
import ServisSelesai from '@/Components/Servis/ServisSelesai.vue'
import JadwalServis from '@/Components/Servis/JadwalServis.vue'
import AnalisaServis from '@/Components/Servis/AnalisaServis.vue'
import PenjualanServis from '@/Components/Servis/PenjualanServis.vue'

defineOptions({ layout: AppLayout })

const activeTab = ref('Servis Aktif')

const tabs = [
    'Servis Aktif',
    'Servis Selesai',
    'Jadwal Servis',
    'Analisa Servis',
    'Penjualan Servis',
]
</script>

<template>
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Servis</h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola seluruh aktivitas servis bengkel.
            </p>
        </div>

        <div class="mb-6 flex gap-2 overflow-x-auto border-b border-slate-200">
            <button
                v-for="tab in tabs"
                :key="tab"
                @click="activeTab = tab"
                class="whitespace-nowrap border-b-2 px-4 py-3 text-sm font-medium"
                :class="activeTab === tab
                    ? 'border-emerald-500 text-emerald-600'
                    : 'border-transparent text-slate-500 hover:text-slate-800'"
            >
                {{ tab }}
            </button>
        </div>

        <ServisAktif v-if="activeTab === 'Servis Aktif'" />
        <ServisSelesai v-else-if="activeTab === 'Servis Selesai'" />
        <JadwalServis v-else-if="activeTab === 'Jadwal Servis'" />
        <AnalisaServis v-else-if="activeTab === 'Analisa Servis'" />
        <PenjualanServis v-else-if="activeTab === 'Penjualan Servis'" />
    </div>
</template>

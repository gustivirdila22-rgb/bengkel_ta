
<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import {
    ShoppingCart,
    FileText,
    History,
} from 'lucide-vue-next'

import AppLayout from '@/Layouts/AppLayout.vue'

import KasirTransaksi from '@/Components/Kasir/KasirTransaksi.vue'
import NotaKasir from '@/Components/Kasir/NotaKasir.vue'
import RiwayatPembayaran from '@/Components/Kasir/RiwayatPembayaran.vue'

defineOptions({
    layout: AppLayout,
})

const activeTab = ref('Kasir Cepat')

const tabs = [
    {
        name: 'Kasir Cepat',
        icon: ShoppingCart,
    },
    {
        name: 'Nota Kasir',
        icon: FileText,
    },
    {
        name: 'Riwayat Pembayaran',
        icon: History,
    },
]
</script>

<template>
    <Head title="Kasir Cepat" />

    <div class="space-y-6">
        <!-- Judul Halaman -->
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-slate-400">
                <span>Dashboard</span>
                <span>/</span>
                <span class="text-slate-600">Kasir</span>
            </div>

            <h1 class="text-2xl font-bold text-slate-800">
                Kasir Cepat
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola transaksi dan pembayaran bengkel dengan mudah.
            </p>
        </div>

        <!-- Tab Navigasi -->
        <div class="border-b border-slate-200">
            <div class="flex flex-wrap gap-2">
                <button
                    v-for="tab in tabs"
                    :key="tab.name"
                    @click="activeTab = tab.name"
                    class="relative flex items-center gap-2 px-5 py-3 text-sm font-semibold transition"
                    :class="
                        activeTab === tab.name
                            ? 'border-b-2 border-emerald-600 text-emerald-700'
                            : 'text-slate-500 hover:text-emerald-600'
                    "
                >
                    <component :is="tab.icon" class="h-4 w-4" />
                    {{ tab.name }}
                </button>
            </div>
        </div>

        <!-- Konten Tab -->
        <div>
            <KasirTransaksi
                v-if="activeTab === 'Kasir Cepat'"
            />

            <NotaKasir
                v-else-if="activeTab === 'Nota Kasir'"
            />

            <RiwayatPembayaran
                v-else-if="activeTab === 'Riwayat Pembayaran'"
            />
        </div>
    </div>
</template>

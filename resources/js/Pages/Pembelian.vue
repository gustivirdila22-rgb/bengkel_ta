<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

import AppLayout from '@/Layouts/AppLayout.vue';

import DaftarPembelian from '@/Components/Pembelian/DaftarPembelian.vue';
import PesananSupplier from '@/Components/Pembelian/PesananSupplier.vue';
import TerimaBarang from '@/Components/Pembelian/TerimaBarang.vue';
import RiwayatHargaBeli from '@/Components/Pembelian/RiwayatHargaBeli.vue';
import Laporan from '@/Components/Pembelian/Laporan.vue';

// Daftar tab yang tersedia
const validTabs = [
    'pembelian',
    'pesanan',
    'terima',
    'riwayat',
    'laporan',
];

// Mengambil tab dari URL ketika halaman pertama kali dibuka
const getInitialTab = () => {
    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab');

    return validTabs.includes(tab) ? tab : 'pembelian';
};

// Tab aktif
const activeTab = ref(getInitialTab());

// Mengubah tab dan menyimpan pilihan ke URL
const changeTab = (tab) => {
    if (!validTabs.includes(tab)) {
        return;
    }

    activeTab.value = tab;

    const url = new URL(window.location.href);
    url.searchParams.set('tab', tab);

    window.history.replaceState(
        window.history.state,
        '',
        url.pathname + url.search + url.hash
    );
};

// Menangani perubahan URL dari tombol Back/Forward browser
const handlePopState = () => {
    activeTab.value = getInitialTab();
};

onMounted(() => {
    window.addEventListener('popstate', handlePopState);
});

onUnmounted(() => {
    window.removeEventListener('popstate', handlePopState);
});
</script>

<template>
    <AppLayout>
        <!-- Header Halaman -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                Pembelian
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola pembelian, pesanan supplier, penerimaan barang, dan laporan pembelian.
            </p>
        </div>

        <!-- Daftar Pembelian -->
        <DaftarPembelian
            v-if="activeTab === 'pembelian'"
            @change-tab="changeTab"
        />

        <!-- Pesanan Supplier -->
        <PesananSupplier
            v-else-if="activeTab === 'pesanan'"
            @change-tab="changeTab"
        />

        <!-- Terima Barang -->
        <TerimaBarang
            v-else-if="activeTab === 'terima'"
            @change-tab="changeTab"
        />

        <!-- Riwayat Harga Beli -->
        <RiwayatHargaBeli
            v-else-if="activeTab === 'riwayat'"
            @change-tab="changeTab"
        />

        <!-- Laporan -->
        <Laporan
            v-else-if="activeTab === 'laporan'"
            @change-tab="changeTab"
        />
    </AppLayout>
</template>
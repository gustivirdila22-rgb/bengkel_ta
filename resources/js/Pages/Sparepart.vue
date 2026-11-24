<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

import DaftarRingkasan from '@/Components/Sparepart/DaftarRingkasan.vue'
import RiwayatStok from '@/Components/Sparepart/RiwayatStok.vue'
import HitungStok from '@/Components/Sparepart/HitungStok.vue'
import HargaAturan from '@/Components/Sparepart/HargaAturan.vue'

const activeTab = ref('daftar')

const pindahMenu = (menu) => {
    activeTab.value = menu
}
</script>

<template>
    <AppLayout>
        <div class="p-6">

            <!-- DAFTAR & RINGKASAN -->
            <DaftarRingkasan
                v-if="activeTab === 'daftar'"
                @menu-change="pindahMenu"
                @riwayat-stok="pindahMenu('riwayat-stok')"
            />

            <!-- RIWAYAT STOK -->
            <RiwayatStok
                v-else-if="activeTab === 'riwayat-stok'"
                @menu-change="pindahMenu"
                @kembali="pindahMenu('daftar')"
            />

            <!-- HITUNG STOK -->
            <HitungStok
                v-else-if="activeTab === 'hitung-stok'"
                @menu-change="pindahMenu"
            />

            <!-- HARGA & ATURAN --> 
             <!-- HARGA & ATURAN -->
<HargaAturan
    v-else-if="activeTab === 'harga-aturan'"
    @menu-change="pindahMenu"
/>
        </div>
    </AppLayout>
</template>
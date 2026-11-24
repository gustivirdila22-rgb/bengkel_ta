
<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { X } from 'lucide-vue-next'

import RingkasanJasaServis from '@/Components/JasaServis/RingkasanJasaServis.vue'
import TabJasaServis from '@/Components/JasaServis/TabJasaServis.vue'
import DaftarJasa from '@/Components/JasaServis/DaftarJasa.vue'
import RingkasanJasa from '@/Components/JasaServis/RingkasanJasa.vue'
import KategoriJasa from '@/Components/JasaServis/KategoriJasa.vue'
import PalingLaku from '@/Components/JasaServis/PalingLaku.vue'
import ModalKategori from '@/Components/JasaServis/ModalKategori.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    jasaServis: {
        type: Array,
        default: () => [],
    },
    kategoriJasa: {
        type: Array,
        default: () => [],
    },
    ringkasan: {
        type: Object,
        default: () => ({
            total: 0,
            aktif: 0,
            nonaktif: 0,
            totalKategori: 0,
            kategoriDipakai: 0,
        }),
    },
    flash: {
        type: Object,
        default: () => ({}),
    },
})

const activeTab = ref('daftar')
const activeSubTab = ref('jasa')

const showModalKategori = ref(false)
const kategoriDiedit = ref(null)
const notification = ref(null)
let notificationTimeout

const tampilkanNotifikasi = ({ type, message }) => {
    notification.value = { type, message }

    clearTimeout(notificationTimeout)
    notificationTimeout = setTimeout(() => {
        notification.value = null
    }, 4000)
}

const tutupNotifikasi = () => {
    clearTimeout(notificationTimeout)
    notification.value = null
}

onBeforeUnmount(tutupNotifikasi)

const tampilkanFlashSukses = (message) => {
    if (message) {
        tampilkanNotifikasi({
            type: 'success',
            message,
        })
    }
}

onMounted(() => tampilkanFlashSukses(props.flash?.success))

watch(() => props.flash?.success, tampilkanFlashSukses)

// TAMBAH KATEGORI
const tambahKategori = () => {
    kategoriDiedit.value = null
    showModalKategori.value = true
}

// EDIT KATEGORI
const editKategori = (kategori) => {
    kategoriDiedit.value = kategori
    showModalKategori.value = true
}

// TUTUP MODAL KATEGORI
const tutupModalKategori = () => {
    showModalKategori.value = false
    kategoriDiedit.value = null
}
</script>

<template>
    <div class="min-h-screen bg-[#f6f8fb] p-5">
        <Teleport to="body">
            <div
                v-if="notification"
                class="fixed right-4 top-4 z-[200] flex w-[calc(100%-2rem)] max-w-sm items-start justify-between gap-4 rounded-xl border bg-white p-4 shadow-lg"
                :class="notification.type === 'error'
                    ? 'border-red-200 text-red-800'
                    : 'border-emerald-200 text-emerald-800'"
                :role="notification.type === 'error' ? 'alert' : 'status'"
                aria-live="polite"
            >
                <p class="text-sm font-medium">{{ notification.message }}</p>
                <button
                    type="button"
                    aria-label="Tutup notifikasi"
                    @click="tutupNotifikasi"
                    class="shrink-0 rounded-md p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                >
                    <X :size="16" />
                </button>
            </div>
        </Teleport>

        <!-- RINGKASAN -->
        <RingkasanJasaServis
            :ringkasan="props.ringkasan"
        />

        <!-- TAB UTAMA -->
        <TabJasaServis
            v-model:active-tab="activeTab"
        />

        <!-- DAFTAR & RINGKASAN -->
        <template v-if="activeTab === 'daftar'">

            <div class="mb-4 inline-flex rounded-xl bg-slate-100 p-1">
                <button
                    type="button"
                    @click="activeSubTab = 'jasa'"
                    class="rounded-lg px-4 py-2 text-sm font-medium transition"
                    :class="activeSubTab === 'jasa'
                        ? 'bg-white text-emerald-700 shadow-sm'
                        : 'text-slate-500 hover:text-slate-800'"
                >
                    Daftar Jasa
                </button>

                <button
                    type="button"
                    @click="activeSubTab = 'ringkasan'"
                    class="rounded-lg px-4 py-2 text-sm font-medium transition"
                    :class="activeSubTab === 'ringkasan'
                        ? 'bg-white text-emerald-700 shadow-sm'
                        : 'text-slate-500 hover:text-slate-800'"
                >
                    Ringkasan
                </button>
            </div>

            <!-- DAFTAR JASA -->
            <DaftarJasa
                v-if="activeSubTab === 'jasa'"
                :jasa-servis="props.jasaServis"
                :kategori-jasa="props.kategoriJasa"
                @notify="tampilkanNotifikasi"
            />

            <!-- RINGKASAN JASA -->
            <RingkasanJasa
                v-else
                :jasa-servis="props.jasaServis"
            />

        </template>

        <!-- KATEGORI -->
        <KategoriJasa
            v-else-if="activeTab === 'kategori'"
            :kategori-jasa="props.kategoriJasa"
            :jasa-servis="props.jasaServis"
            @tambah="tambahKategori"
            @edit="editKategori"
        />

        <!-- PALING LAKU -->
        <PalingLaku
            v-else-if="activeTab === 'paling-laku'"
            :jasa-servis="props.jasaServis"
        />

        <!-- MODAL KATEGORI -->
        <ModalKategori
            :show="showModalKategori"
            :kategori="kategoriDiedit"
            @close="tutupModalKategori"
            @saved="tutupModalKategori"
        />

    </div>
</template>

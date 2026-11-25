
<script setup>
import { ref } from 'vue'

const mekanik = ref(1)
const servisSelesaiBulanIni = ref(0)
const nilaiServisBulanIni = ref(0)
const servisBerjalan = ref(1)
const servisTanpaMekanik = ref(0)

const servisTerbanyak = ref([
    {
        ranking: 1,
        nama: 'Cecep Hasanudin',
        kode: 'KRY-000001',
        jumlahServis: 5,
        total: 500000
    }
])

const sedangDikerjakan = ref([
    {
        ranking: 1,
        nama: 'Cecep Hasanudin',
        kode: 'KRY-000001',
        jumlahServis: 1
    }
])

const formatRupiah = (angka) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    }).format(angka)
}
</script>

<template>
    <div class="space-y-5">

        <!-- 4 Card Ringkasan -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <!-- Mekanik -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-600">Mekanik</p>

                <p class="mt-3 text-3xl font-semibold text-slate-900">
                    {{ mekanik }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Yang masih dipakai
                </p>

                <button
                    class="mt-3 text-xs font-semibold text-orange-600 hover:underline"
                >
                    Lihat →
                </button>
            </div>

            <!-- Servis Selesai Bulan Ini -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-600">
                    Servis selesai bulan ini
                </p>

                <p class="mt-3 text-3xl font-semibold text-slate-900">
                    {{ servisSelesaiBulanIni }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Senilai {{ formatRupiah(nilaiServisBulanIni) }}
                </p>
            </div>

            <!-- Servis Berjalan -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-600">
                    Servis berjalan
                </p>

                <p class="mt-3 text-3xl font-semibold text-slate-900">
                    {{ servisBerjalan }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Menunggu atau sedang dikerjakan
                </p>

                <button
                    class="mt-3 text-xs font-semibold text-sky-600 hover:underline"
                >
                    Lihat →
                </button>
            </div>

            <!-- Tanpa Mekanik -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-600">
                    Tanpa mekanik
                </p>

                <p class="mt-3 text-3xl font-semibold text-slate-900">
                    {{ servisTanpaMekanik }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Servis selesai bulan ini tanpa nama mekanik
                </p>
            </div>

        </div>

        <!-- 2 Card Bagian Bawah -->
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">

            <!-- Servis Terbanyak -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <h3 class="text-base font-semibold text-slate-900">
                    Servis terbanyak (90 hari terakhir)
                </h3>

                <div
                    v-for="item in servisTerbanyak"
                    :key="item.kode"
                    class="mt-5 flex items-center justify-between gap-4"
                >
                    <div class="flex items-center gap-5">
                        <span class="text-sm text-slate-500">
                            {{ item.ranking }}
                        </span>

                        <div>
                            <p class="text-sm font-medium text-slate-900">
                                {{ item.nama }}
                            </p>

                            <p class="text-xs text-slate-500">
                                {{ item.kode }}
                            </p>
                        </div>
                    </div>

                    <p class="text-sm font-medium text-slate-900">
                        {{ item.jumlahServis }} servis ·
                        {{ formatRupiah(item.total) }}
                    </p>
                </div>

            </div>

            <!-- Sedang Dikerjakan -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <h3 class="text-base font-semibold text-slate-900">
                    Sedang dikerjakan sekarang
                </h3>

                <div
                    v-for="item in sedangDikerjakan"
                    :key="item.kode"
                    class="mt-5 flex items-center justify-between gap-4"
                >
                    <div class="flex items-center gap-5">
                        <span class="text-sm text-slate-500">
                            {{ item.ranking }}
                        </span>

                        <div>
                            <p class="text-sm font-medium text-slate-900">
                                {{ item.nama }}
                            </p>

                            <p class="text-xs text-slate-500">
                                {{ item.kode }}
                            </p>
                        </div>
                    </div>

                    <p class="text-sm font-medium text-slate-900">
                        {{ item.jumlahServis }} servis
                    </p>
                </div>

            </div>

        </div>

    </div>
</template>

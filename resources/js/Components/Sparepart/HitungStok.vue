<script setup>
import { ref } from 'vue'

const emit = defineEmits(['menu-change'])

const search = ref('')
const jenis = ref('Semua jenis')
const activeFilter = ref('semua')

const menuItems = [
    { id: 'daftar', label: 'Daftar & Ringkasan' },
    { id: 'riwayat-stok', label: 'Riwayat Stok' },
    { id: 'hitung-stok', label: 'Hitung Stok' },
    { id: 'harga-aturan', label: 'Harga & Aturan' },
]

const filterItems = [
    { id: 'semua', label: 'Semua', count: 1 },
    { id: 'belum-selesai', label: 'Belum selesai', count: 1 },
    { id: 'final', label: 'Final', count: 0 },
    { id: 'dibatalkan', label: 'Dibatalkan', count: 0 },
]

const data = [
    {
        nomor: 'OP-000001',
        tanggal: '13 Oktober 2026',
        jenis: 'Stok Awal',
        sparepart: 1,
        status: 'Belum selesai',
    },
]

const pindahMenu = (menu) => {
    emit('menu-change', menu)
}
</script>

<template>
    <div class="-mt-10 space-y-5">

        <!-- HEADER -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-600"
                >
                    <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                    <span class="font-semibold text-emerald-700">1</span>
                    belum selesai
                </span>

                <span
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-600"
                >
                    <span class="font-semibold text-slate-900">0</span>
                    sudah selesai
                </span>

                <span
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-600"
                >
                    <span class="font-semibold text-slate-900">0</span>
                    dibatalkan
                </span>
            </div>

            <div class="flex items-center gap-2">
                <!-- Excel -->
                <button
                    type="button"
                    class="flex h-12 items-center gap-3 rounded-xl border border-slate-200 bg-white px-5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9m-6-6 6 6m-6-6v6h6"
                        />
                    </svg>

                    <span>Excel</span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m6 9 6 6 6-6"
                        />
                    </svg>
                </button>

                <!-- Input Stok Awal -->
                <button
                    type="button"
                    class="h-12 rounded-xl border border-slate-200 bg-white px-5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                >
                    Input Stok Awal
                </button>

                <!-- Hitung Stok Rutin -->
                <button
                    type="button"
                    class="flex h-12 items-center gap-2 rounded-xl bg-emerald-600 px-5 text-sm font-semibold text-white transition hover:bg-emerald-700"
                >
                    <span class="text-lg leading-none">+</span>
                    Hitung Stok Rutin
                </button>
            </div>
        </div>

        <!-- MENU UTAMA -->
        <div class="border-b border-slate-200">
            <div class="flex items-center gap-8 overflow-x-auto">
                <button
                    v-for="menu in menuItems"
                    :key="menu.id"
                    type="button"
                    @click="pindahMenu(menu.id)"
                    class="relative flex h-12 shrink-0 items-center border-b-2 px-1 text-sm transition"
                    :class="
                        menu.id === 'hitung-stok'
                            ? 'border-emerald-600 font-semibold text-emerald-700'
                            : 'border-transparent font-medium text-slate-500 hover:border-emerald-300 hover:text-emerald-700'
                    "
                >
                    {{ menu.label }}
                </button>
            </div>
        </div>

        <!-- CARD CONTENT -->
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

            <!-- SEARCH + SELECT -->
            <div class="flex items-center gap-3">

                <!-- Search -->
                <div class="relative w-[396px]">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                        />
                    </svg>

                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari nomor hitung stok..."
                        class="h-12 w-full rounded-xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100"
                    />
                </div>

                <!-- Jenis -->
                <div class="relative w-[235px]">
                    <select
                        v-model="jenis"
                        class="h-12 w-full appearance-none rounded-xl border border-slate-200 bg-white px-4 pr-10 text-sm text-slate-700 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100"
                    >
                        <option>Semua jenis</option>
                        <option>Stok Awal</option>
                        <option>Stok Rutin</option>
                    </select>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m6 9 6 6 6-6"
                        />
                    </svg>
                </div>
            </div>

            <!-- FILTER -->
            <div class="mt-4 flex items-center gap-2">
                <button
                    v-for="filter in filterItems"
                    :key="filter.id"
                    type="button"
                    @click="activeFilter = filter.id"
                    class="rounded-full border px-3.5 py-1.5 text-sm transition"
                    :class="
                        activeFilter === filter.id
                            ? 'border-emerald-600 bg-white font-medium text-emerald-700'
                            : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-300 hover:text-emerald-700'
                    "
                >
                    {{ filter.label }} {{ filter.count }}
                </button>

                <span
                    class="ml-1 inline-flex h-4 w-4 items-center justify-center rounded-full border border-slate-400 text-[10px] font-semibold text-slate-500"
                >
                    i
                </span>
            </div>

            <!-- TABLE -->
            <div class="mt-5 overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500"
                            >
                                No. Bukti
                            </th>

                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500"
                            >
                                Tanggal
                            </th>

                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500"
                            >
                                Jenis
                            </th>

                            <th
                                class="px-4 py-3 text-right text-xs font-medium text-slate-500"
                            >
                                Sparepart
                            </th>

                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500"
                            >
                                Status
                            </th>

                            <th class="w-12 px-4 py-3"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="item in data"
                            :key="item.nomor"
                            class="border-b border-slate-100 last:border-0"
                        >
                            <td class="px-4 py-5">
                                <button
                                    type="button"
                                    class="text-sm font-semibold text-emerald-600 hover:text-emerald-700"
                                >
                                    {{ item.nomor }}
                                </button>
                            </td>

                            <td class="px-4 py-5 text-sm text-slate-600">
                                {{ item.tanggal }}
                            </td>

                            <td class="px-4 py-5">
                                <span
                                    class="inline-flex rounded-full bg-cyan-50 px-3 py-1 text-xs font-medium text-cyan-600"
                                >
                                    {{ item.jenis }}
                                </span>
                            </td>

                            <td
                                class="px-4 py-5 text-right text-sm text-slate-700"
                            >
                                {{ item.sparepart }}
                            </td>

                            <td class="px-4 py-5">
                                <span
                                    class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600"
                                >
                                    {{ item.status }}
                                </span>
                            </td>

                            <td class="px-4 py-5">
                                <button
                                    type="button"
                                    class="text-slate-400 hover:text-emerald-600"
                                    title="Informasi"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            d="M12 11v5"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            d="M12 8h.01"
                                        />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
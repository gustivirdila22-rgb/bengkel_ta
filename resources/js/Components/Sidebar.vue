
<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isCollapsed = ref(false);
const activeMenu = ref('Beranda');
const selectedModul = ref('Operasional');
const isModulOpen = ref(false);

const isReferensiOpen = ref(false);

const referensiMenus = [
  { name: 'Kategori Sparepart', href: '/kategori-sparepart' },
  { name: 'Satuan Sparepart', href: '/satuan-sparepart' },
  { name: 'Merk Sparepart', href: '/merk-sparepart' },
  { name: 'Lokasi Stok', href: '/lokasi-stok' },
  { name: 'Merk Kendaraan', href: '/merk-kendaraan' },
  { name: 'Kategori Biaya', href: '/kategori-biaya' },
];

const moduls = [
  { name: 'Operasional', icon: 'wrench' },
  { name: 'Akunting', icon: 'calculator' },
];

const selectModul = (name) => {
  selectedModul.value = name;
  isModulOpen.value = false;
};

const transaksiMenus = [
  { name: 'Kasir Cepat', href: '/kasir', icon: 'basket' },
  { name: 'Servis', href: '/servis', icon: 'wrench' },
  { name: 'Pembelian', href: '/pembelian', icon: 'cart' },
];

const operasionalMenus = [
  { name: 'Pelanggan & Kendaraan', href: '/pelanggan', icon: 'users' },
  { name: 'Sparepart', href: '/sparepart', icon: 'cubes' },
  { name: 'Jasa Servis', href: '/jasa-servis', icon: 'clipboard' },
];
</script>

<template>
  <aside
    :class="[
      'sticky top-0 h-screen shrink-0 flex flex-col justify-between bg-[#101820] text-slate-300 transition-all duration-300 select-none overflow-hidden border-r border-slate-800/80',
      isCollapsed ? 'w-20' : 'w-72'
    ]"
  >
    <!-- Efek Glow Hijau Halus di Pojok Kiri Atas -->
    <div
      class="pointer-events-none absolute -top-16 -left-16 h-56 w-56 rounded-full bg-emerald-500/20 blur-3xl"
    ></div>

    <!-- Watermark Gear di Latar Belakang Bawah -->
    <svg
      class="pointer-events-none absolute -right-12 bottom-16 h-64 w-64 text-white/[0.03]"
      viewBox="0 0 24 24"
      fill="currentColor"
    >
      <path
        d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58a.49.49 0 0 0 .12-.61l-1.92-3.32a.488.488 0 0 0-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54a.484.484 0 0 0-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58a.49.49 0 0 0-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"
      />
    </svg>

    <!-- Bagian Atas & Menu -->
    <div class="relative z-10 p-4 space-y-5 flex-1 min-h-0 overflow-y-auto">

      <!-- Header Logo -->
      <div class="flex items-center justify-between pt-1">
        <div class="flex items-center gap-3">
          <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/25"
          >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
            </svg>
          </div>
          <span v-if="!isCollapsed" class="text-xl font-bold tracking-tight text-white">
            Bengkel<span class="text-emerald-400">in</span>
          </span>
        </div>

        <!-- Tombol Collapse -->
        <button
          @click="isCollapsed = !isCollapsed"
          class="flex h-7 w-7 items-center justify-center rounded-full bg-white text-slate-700 shadow-md hover:bg-emerald-50 transition"
          title="Kecilkan / Besarkan Sidebar"
        >
          <svg
            :class="['h-4 w-4 transition-transform', isCollapsed ? '' : 'rotate-180']"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2.5"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>

      <!-- Dropdown Modul (Operasional & Akunting) -->
      <div v-if="!isCollapsed" class="space-y-1.5">
        <button
          type="button"
          @click="isModulOpen = !isModulOpen"
          class="flex w-full items-center justify-between rounded-2xl bg-white/[0.06] px-3.5 py-3 border border-white/[0.06] text-left hover:bg-white/[0.09] transition"
        >
          <div class="flex items-center gap-3">
            <!-- Ikon Wrench jika Operasional -->
            <svg
              v-if="selectedModul === 'Operasional'"
              class="h-5 w-5 text-emerald-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
            </svg>

            <!-- Ikon Calculator jika Akunting -->
            <svg
              v-else
              class="h-5 w-5 text-emerald-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <rect x="4" y="2" width="16" height="20" rx="2" />
              <line x1="8" y1="6" x2="16" y2="6" />
              <line x1="8" y1="10" x2="8.01" y2="10" />
              <line x1="12" y1="10" x2="12.01" y2="10" />
              <line x1="16" y1="10" x2="16.01" y2="10" />
              <line x1="8" y1="14" x2="8.01" y2="14" />
              <line x1="12" y1="14" x2="12.01" y2="14" />
              <line x1="16" y1="14" x2="16.01" y2="14" />
              <line x1="8" y1="18" x2="8.01" y2="18" />
              <line x1="12" y1="18" x2="16" y2="18" />
            </svg>

            <div>
              <p class="text-[11px] text-slate-400 leading-tight">Modul</p>
              <p class="text-sm font-semibold text-white">{{ selectedModul }}</p>
            </div>
          </div>

          <svg
            :class="['h-4 w-4 text-slate-400 transition-transform duration-200', isModulOpen ? 'rotate-180' : '']"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- Pilihan List Modul saat diklik -->
        <div v-if="isModulOpen" class="space-y-1 pt-1">
          <button
            v-for="modul in moduls"
            :key="modul.name"
            type="button"
            @click="selectModul(modul.name)"
            :class="[
              'flex w-full items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition',
              selectedModul === modul.name
                ? 'bg-white/[0.08] font-semibold text-white'
                : 'text-slate-400 hover:bg-white/[0.04] hover:text-slate-200'
            ]"
          >
            <!-- Ikon Wrench -->
            <svg
              v-if="modul.icon === 'wrench'"
              :class="['h-5 w-5 shrink-0', selectedModul === modul.name ? 'text-emerald-400' : 'text-slate-400']"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="1.8"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
            </svg>

            <!-- Ikon Calculator -->
            <svg
              v-else
              :class="['h-5 w-5 shrink-0', selectedModul === modul.name ? 'text-emerald-400' : 'text-slate-400']"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="1.8"
            >
              <rect x="4" y="2" width="16" height="20" rx="2" />
              <line x1="8" y1="6" x2="16" y2="6" />
              <line x1="8" y1="10" x2="8.01" y2="10" />
              <line x1="12" y1="10" x2="12.01" y2="10" />
              <line x1="16" y1="10" x2="16.01" y2="10" />
              <line x1="8" y1="14" x2="8.01" y2="14" />
              <line x1="12" y1="14" x2="12.01" y2="14" />
              <line x1="16" y1="14" x2="16.01" y2="14" />
              <line x1="8" y1="18" x2="8.01" y2="18" />
              <line x1="12" y1="18" x2="16" y2="18" />
            </svg>

            <span>{{ modul.name }}</span>
          </button>
        </div>
      </div>

      <!-- Menu Beranda -->
      <div>
        <Link
          href="/dashboard"
          @click="activeMenu = 'Beranda'"
          :class="[
            'flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-medium transition',
            activeMenu === 'Beranda'
              ? 'bg-emerald-500/15 text-white border border-emerald-500/30'
              : 'text-slate-300 hover:bg-white/5 hover:text-white'
          ]"
        >
          <svg class="h-5 w-5 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1.5" />
            <rect x="14" y="3" width="7" height="7" rx="1.5" />
            <rect x="14" y="14" width="7" height="7" rx="1.5" />
            <rect x="3" y="14" width="7" height="7" rx="1.5" />
          </svg>
          <span v-if="!isCollapsed">Beranda</span>
        </Link>
      </div>

      <!-- Kategori: TRANSAKSI -->
      <div class="space-y-1">
        <p v-if="!isCollapsed" class="px-3 text-[11px] font-bold tracking-wider text-slate-500 uppercase mb-2">
          Transaksi
        </p>

        <Link
          v-for="item in transaksiMenus"
          :key="item.name"
          :href="item.href"
          @click="activeMenu = item.name"
          :class="[
            'flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition',
            activeMenu === item.name
              ? 'bg-emerald-500/15 text-emerald-300'
              : 'text-slate-300 hover:bg-white/5 hover:text-white'
          ]"
        >
          <svg v-if="item.icon === 'basket'" class="h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 11h14l-1.5 8h-11L5 11zm4-6l-2 6m8-6l2 6M9 14v2m3-2v2m3-2v2" />
          </svg>

          <svg v-else-if="item.icon === 'wrench'" class="h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
          </svg>

          <svg v-else-if="item.icon === 'cart'" class="h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>

          <span v-if="!isCollapsed">{{ item.name }}</span>
        </Link>
      </div>

      <!-- Kategori: DATA OPERASIONAL -->
      <div class="space-y-1">
        <p v-if="!isCollapsed" class="px-3 text-[11px] font-bold tracking-wider text-slate-500 uppercase mb-2">
          Data Operasional
        </p>

        <Link
          v-for="item in operasionalMenus"
          :key="item.name"
          :href="item.href"
          @click="activeMenu = item.name"
          :class="[
            'flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition',
            activeMenu === item.name
              ? 'bg-emerald-500/15 text-emerald-300'
              : 'text-slate-300 hover:bg-white/5 hover:text-white'
          ]"
        >
          <svg v-if="item.icon === 'users'" class="h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>

          <svg v-else-if="item.icon === 'cubes'" class="h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>

          <svg v-else-if="item.icon === 'clipboard'" class="h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
          </svg>

          <span v-if="!isCollapsed">{{ item.name }}</span>
        </Link>
      </div>

      <!-- Kategori: DATA REFERENSI -->
      <div class="space-y-1">
        <button
          type="button"
          @click="isReferensiOpen = !isReferensiOpen"
          :class="[
            'flex w-full items-center justify-between rounded-xl px-3.5 py-2.5 text-sm font-medium transition',
            isReferensiOpen
              ? 'bg-emerald-500/15 text-emerald-300'
              : 'text-slate-300 hover:bg-white/5 hover:text-white'
          ]"
        >
          <div class="flex items-center gap-3">
            <!-- Ikon Database -->
            <svg
              class="h-5 w-5 shrink-0 text-slate-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="1.8"
            >
              <ellipse cx="12" cy="5" rx="9" ry="3" />
              <path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5" />
              <path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3" />
            </svg>

            <span v-if="!isCollapsed">Data Referensi</span>
          </div>

          <!-- Chevron -->
          <svg
            v-if="!isCollapsed"
            :class="[
              'h-4 w-4 text-slate-400 transition-transform duration-200',
              isReferensiOpen ? 'rotate-180' : ''
            ]"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- Submenu Data Referensi -->
        <div
          v-if="isReferensiOpen && !isCollapsed"
          class="ml-5 space-y-1 border-l border-slate-700 pl-3"
        >
          <Link
            v-for="item in referensiMenus"
            :key="item.name"
            :href="item.href"
            @click="activeMenu = item.name"
            :class="[
              'flex items-center gap-3 rounded-lg px-3 py-2.5 text-[13px] font-medium transition',
              activeMenu === item.name
                ? 'bg-emerald-500/15 text-emerald-300'
                : 'text-slate-400 hover:bg-white/5 hover:text-white'
            ]"
          >
            <span
              :class="[
                'h-1.5 w-1.5 shrink-0 rounded-full',
                activeMenu === item.name
                  ? 'bg-emerald-400'
                  : 'bg-slate-600'
              ]"
            ></span>

            <span>{{ item.name }}</span>
          </Link>
        </div>
      </div>

    </div>

    <!-- Profil User di Bawah -->
    <div class="relative z-10 p-4 shrink-0">
      <div
        class="flex items-center gap-3 rounded-2xl bg-white/[0.05] p-3 border border-white/[0.07]"
      >
        <div
          class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500 font-bold text-white shadow-md shadow-emerald-500/20"
        >
          S
        </div>

        <div v-if="!isCollapsed" class="overflow-hidden">
          <p class="truncate text-sm font-semibold text-white">Super Admin</p>
          <p class="truncate text-xs text-slate-400">Owner</p>
        </div>
      </div>
    </div>
  </aside>
</template>

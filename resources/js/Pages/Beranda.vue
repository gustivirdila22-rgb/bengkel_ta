<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const activeTab = ref('Ringkasan');

const penjualan7Hari = [
  { hari: 'Sen 10', nominal: 350000, height: '22%' },
  { hari: 'Sel 11', nominal: 0, height: '4%' },
  { hari: 'Rab 12', nominal: 180000, height: '14%' },
  { hari: 'Kam 13', nominal: 120000, height: '10%' },
  { hari: 'Jum 14', nominal: 90000, height: '8%' },
  { hari: 'Sab 15', nominal: 148750, height: '12%' },
  { hari: 'Sen 16', nominal: 1500000, height: '92%' },
];

const servisBerjalan = [
  { plat: 'B 5566 HU', pelanggan: 'Fitri Handayani', tanggal: '06 November 2026', status: 'Menunggu', durasi: '9 hari 23 jam' },
  { plat: 'B 7788 KLM', pelanggan: 'Dimas Arifin', tanggal: '28 Oktober 2026', status: 'Dikerjakan', durasi: '19 hari 1 jam' },
  { plat: 'AD 11 AW', pelanggan: 'Gusti Pramana', tanggal: '27 Oktober 2026', status: 'Menunggu', durasi: '20 hari 2 jam' },
];

const tagihanBelumLunas = [
  { plat: 'AD 121 BC', pelanggan: 'Pramana Setiawan', nominal: 'Rp 1.380.000' },
  { plat: 'B 1122 BCD', pelanggan: 'Maya Puspita', nominal: 'Rp 1.450.000' },
  { plat: 'B 6789 STU', pelanggan: 'Hendra Gunawan', nominal: 'Rp 2.480.000' },
];
</script>

<template>
  <AppLayout>
    <div class="space-y-6 font-['Inter',sans-serif]">
      <!-- 1. Banner Progress Setup -->
      <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-6 py-4 shadow-xs">
        <div>
          <div class="flex flex-wrap items-center gap-2.5">
            <span class="text-base font-bold text-slate-800">Siap jualan — tinggal 4 langkah lagi</span>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
              <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              Sudah bisa jualan
            </span>
          </div>
          <p class="mt-1 text-sm text-slate-500">
            Wajib 4/4 · Sambil jalan 3/7 · <span class="font-medium text-slate-700">Berikutnya: Staf & hak aksesnya</span>
          </p>
        </div>
        <button type="button" class="rounded-xl p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>

      <!-- 2. Sub-menu Tabs -->
      <div class="flex items-center gap-8 border-b border-slate-200 px-1 text-sm">
        <button
          v-for="tab in [
            { name: 'Ringkasan', icon: 'grid' },
            { name: 'Laporan', icon: 'chart' },
            { name: 'Grafik & Analisa', icon: 'trend' }
          ]"
          :key="tab.name"
          type="button"
          @click="activeTab = tab.name"
          :class="[
            'flex items-center gap-2 pb-3.5 font-medium transition',
            activeTab === tab.name
              ? 'text-emerald-600 font-semibold border-b-2 border-emerald-600'
              : 'text-slate-500 hover:text-slate-800'
          ]"
        >
          <svg v-if="tab.icon === 'grid'" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1.5" />
            <rect x="14" y="3" width="7" height="7" rx="1.5" />
            <rect x="14" y="14" width="7" height="7" rx="1.5" />
            <rect x="3" y="14" width="7" height="7" rx="1.5" />
          </svg>
          <svg v-else-if="tab.icon === 'chart'" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          <svg v-else class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
          <span>{{ tab.name }}</span>
        </button>
      </div>

      <!-- 3. Hero Banner Selamat Datang (Tema Hijau) -->
      <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-900 p-7 text-white shadow-md">
        <div class="relative z-10 flex flex-col justify-between gap-5 md:flex-row md:items-center">
          <div class="space-y-3">
            <div class="flex items-center gap-3.5">
              <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 backdrop-blur-xs">
                <svg class="h-6 w-6 text-emerald-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                </svg>
              </div>
              <h1 class="text-2xl font-bold tracking-tight">Selamat datang, Super Admin</h1>
            </div>
            <p class="text-sm text-emerald-50/90 max-w-2xl leading-relaxed">
              Ringkasan pekerjaan bengkel, tren pendapatan, dan hal yang perlu ditindaklanjuti hari ini.
            </p>
            <div class="flex flex-wrap items-center gap-2.5 pt-1 text-xs">
              <span class="rounded-full bg-white/15 px-3.5 py-1.5 font-medium">Peran: Owner</span>
              <span class="rounded-full bg-white/15 px-3.5 py-1.5 font-medium">3 servis berjalan</span>
              <span class="rounded-full bg-white/15 px-3.5 py-1.5 font-medium">3 tagihan belum lunas</span>
            </div>
          </div>

          <button
            type="button"
            class="self-start md:self-center inline-flex items-center gap-2.5 rounded-xl border border-white/25 bg-white/10 px-5 py-3 text-sm font-semibold text-white backdrop-blur-xs hover:bg-white/20 transition"
          >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4" />
            </svg>
            <span>Tutup Kasir</span>
          </button>
        </div>
      </div>

      <!-- 4. Tombol Aksi Cepat (4 Kolom) -->
      <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <button type="button" class="flex items-center justify-center gap-2.5 rounded-xl border border-slate-200 bg-white py-3.5 px-4 text-sm font-semibold text-slate-700 shadow-2xs hover:border-emerald-500 hover:text-emerald-600 transition">
          <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          <span>Servis Baru</span>
        </button>

        <button type="button" class="flex items-center justify-center gap-2.5 rounded-xl border border-slate-200 bg-white py-3.5 px-4 text-sm font-semibold text-slate-700 shadow-2xs hover:border-emerald-500 hover:text-emerald-600 transition">
          <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span>Kasir Cepat</span>
        </button>

        <button type="button" class="flex items-center justify-center gap-2.5 rounded-xl border border-slate-200 bg-white py-3.5 px-4 text-sm font-semibold text-slate-700 shadow-2xs hover:border-emerald-500 hover:text-emerald-600 transition">
          <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
          </svg>
          <span>Catat Biaya</span>
        </button>

        <button type="button" class="flex items-center justify-center gap-2.5 rounded-xl border border-slate-200 bg-white py-3.5 px-4 text-sm font-semibold text-slate-700 shadow-2xs hover:border-emerald-500 hover:text-emerald-600 transition">
          <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          <span>Laporan Penjualan</span>
        </button>
      </div>

      <!-- 5. 4 Kartu KPI Utama -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Omzet hari ini -->
        <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
          <div>
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-slate-500">Omzet hari ini</span>
              <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </span>
            </div>
            <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Rp 2 jt</p>
            <p class="mt-1.5 text-xs text-slate-500">2 nota selesai hari ini</p>
          </div>
          <div class="mt-4">
            <svg class="h-7 w-full text-emerald-500" viewBox="0 0 120 24" fill="none">
              <path d="M2 20 L40 19 L75 19 L95 16 L118 4" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" />
            </svg>
            <a href="#" class="mt-2.5 inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:underline">
              Lihat <span>→</span>
            </a>
          </div>
        </div>

        <!-- Kendaraan antre -->
        <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
          <div>
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-slate-500">Kendaraan antre</span>
              <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8m-8 4h8m-4 4v3m-6-3h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
              </span>
            </div>
            <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">3</p>
            <p class="mt-1.5 text-xs text-slate-500">1 sedang dikerjakan</p>
          </div>
          <div class="mt-8">
            <a href="#" class="inline-flex items-center gap-1 text-sm font-semibold text-sky-600 hover:underline">
              Lihat <span>→</span>
            </a>
          </div>
        </div>

        <!-- Stok menipis -->
        <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
          <div>
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-slate-500">Stok menipis</span>
              <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </span>
            </div>
            <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">0 item</p>
            <p class="mt-1.5 text-xs text-slate-500">2 barang lain sudah habis</p>
          </div>
          <div class="mt-8">
            <a href="#" class="inline-flex items-center gap-1 text-sm font-semibold text-rose-600 hover:underline">
              Lihat <span>→</span>
            </a>
          </div>
        </div>

        <!-- Saldo kas dan bank -->
        <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
          <div>
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-slate-500">Saldo kas dan bank</span>
              <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
              </span>
            </div>
            <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Rp 454 jt</p>
            <p class="mt-1.5 text-xs text-slate-500">Hari ini masuk Rp 2 jt · keluar Rp 0</p>
          </div>
          <div class="mt-8">
            <a href="#" class="inline-flex items-center gap-1 text-sm font-semibold text-teal-600 hover:underline">
              Lihat <span>→</span>
            </a>
          </div>
        </div>
      </div>

      <!-- 6. Banner Notifikasi / Insight -->
      <div class="flex items-center gap-3 rounded-xl border border-amber-200/80 bg-amber-50/70 px-5 py-3.5 text-sm text-slate-700">
        <svg class="h-5 w-5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
        </svg>
        <p>
          Omzet hari ini <strong>Rp 2 jt</strong> dari 2 nota. <strong>2 sparepart habis</strong> — buat order ke supplier sekarang.
        </p>
      </div>

      <!-- 7. Grafik Penjualan 7 Hari -->
      <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-2">
            <h2 class="text-base font-bold text-slate-800">Penjualan 7 Hari</h2>
            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="9" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01" />
            </svg>
          </div>
          <a href="#" class="text-sm font-medium text-slate-500 hover:text-emerald-600">Lihat Servis →</a>
        </div>

        <div class="flex h-56 items-end justify-between gap-4 border-b border-slate-100 px-4 pb-2">
          <div
            v-for="item in penjualan7Hari"
            :key="item.hari"
            class="flex flex-1 flex-col items-center gap-2 h-full justify-end"
          >
            <div
              :style="{ height: item.height }"
              class="w-full max-w-[48px] rounded-t-lg bg-emerald-500 hover:bg-emerald-600 transition-all cursor-pointer"
              :title="`${item.hari}: Rp ${item.nominal.toLocaleString('id-ID')}`"
            ></div>
          </div>
        </div>

        <div class="flex justify-between px-4 pt-3 text-xs font-medium text-slate-500">
          <span v-for="item in penjualan7Hari" :key="item.hari" class="flex-1 text-center">
            {{ item.hari }}
          </span>
        </div>

        <div class="mt-6 flex flex-wrap items-center justify-center gap-4 text-sm text-slate-500">
          <span class="flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
            Total 7 hari: <strong class="text-slate-800">Rp 2.388.750</strong>
          </span>
          <span>·</span>
          <span>Jumlah nota: <strong class="text-slate-800">5 nota</strong></span>
        </div>
      </div>

      <!-- 8. Grafik Tren Pendapatan 6 Bulan Terakhir -->
      <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
          <div class="flex items-center gap-2">
            <h2 class="text-base font-bold text-slate-800">Tren Pendapatan 6 Bulan Terakhir</h2>
            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="9" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01" />
            </svg>
          </div>
          <div class="flex items-center gap-5 text-sm">
            <span class="flex items-center gap-2 text-slate-600">
              <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Pendapatan
            </span>
            <span class="flex items-center gap-2 text-slate-600">
              <span class="h-2.5 w-2.5 rounded-full bg-teal-400"></span> Laba Bersih
            </span>
            <a href="#" class="font-medium text-slate-500 hover:text-emerald-600">Lihat Laporan →</a>
          </div>
        </div>

        <div class="w-full overflow-hidden">
          <svg viewBox="0 0 700 185" class="w-full h-52">
            <defs>
              <linearGradient id="gradGreen" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#10b981" stop-opacity="0.22" />
                <stop offset="100%" stop-color="#10b981" stop-opacity="0" />
              </linearGradient>
            </defs>
            <line x1="0" y1="30" x2="700" y2="30" stroke="#f1f5f9" />
            <line x1="0" y1="75" x2="700" y2="75" stroke="#f1f5f9" />
            <line x1="0" y1="120" x2="700" y2="120" stroke="#f1f5f9" />
            <line x1="0" y1="155" x2="700" y2="155" stroke="#e2e8f0" />

            <path d="M 20 95 C 90 95, 130 25, 190 25 C 250 25, 290 105, 360 115 C 430 125, 500 132, 680 132 L 680 155 L 20 155 Z" fill="url(#gradGreen)" />
            <path d="M 20 95 C 90 95, 130 25, 190 25 C 250 25, 290 105, 360 115 C 430 125, 500 132, 680 132" fill="none" stroke="#10b981" stroke-width="2.5" />
            <path d="M 20 125 C 90 125, 130 95, 190 95 C 250 95, 290 125, 360 132 C 430 138, 500 142, 680 142" fill="none" stroke="#2dd4bf" stroke-width="2" />

            <text x="20" y="176" class="fill-slate-500 text-xs">Jul 2026</text>
            <text x="175" y="176" class="fill-slate-500 text-xs">Agu 2026</text>
            <text x="345" y="176" class="fill-slate-500 text-xs">Sep 2026</text>
            <text x="510" y="176" class="fill-slate-500 text-xs">Okt 2026</text>
            <text x="640" y="176" class="fill-slate-500 text-xs">Nov 2026</text>
          </svg>
        </div>

        <div class="mt-4 flex flex-wrap items-center justify-center gap-6 text-sm text-slate-500">
          <span class="flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
            Total pendapatan 6 bulan: <strong class="text-slate-800">Rp 583.162.000</strong>
          </span>
          <span class="flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-full bg-teal-400"></span>
            Total laba bersih 6 bulan: <strong class="text-slate-800">Rp 174.162.288,01</strong>
          </span>
        </div>
      </div>

      <!-- 9. Dua Kolom Daftar: Servis Berjalan & Tagihan Belum Lunas -->
      <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Servis Berjalan -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
          <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
              <h2 class="text-base font-bold text-slate-800">Servis Berjalan</h2>
              <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="9" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01" />
              </svg>
            </div>
            <a href="#" class="text-sm font-medium text-slate-500 hover:text-emerald-600">Lihat semua</a>
          </div>
          <div class="divide-y divide-slate-100">
            <div v-for="item in servisBerjalan" :key="item.plat" class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
              <div>
                <p class="text-sm font-bold text-slate-800">{{ item.plat }}</p>
                <p class="mt-0.5 text-xs text-slate-500">{{ item.pelanggan }} · {{ item.tanggal }}</p>
              </div>
              <div class="text-right">
                <span
                  :class="[
                    'inline-block rounded-full px-3 py-1 text-xs font-semibold',
                    item.status === 'Dikerjakan' ? 'bg-sky-50 text-sky-600' : 'bg-amber-50 text-amber-600'
                  ]"
                >
                  {{ item.status }}
                </span>
                <p class="mt-1 flex items-center justify-end gap-1 text-xs font-medium text-rose-500">
                  <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3" />
                  </svg>
                  <span>{{ item.durasi }}</span>
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Tagihan Belum Lunas -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
          <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
              <h2 class="text-base font-bold text-slate-800">Tagihan Belum Lunas</h2>
              <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="9" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01" />
              </svg>
            </div>
          </div>
          <div class="divide-y divide-slate-100">
            <div v-for="item in tagihanBelumLunas" :key="item.plat" class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
              <div>
                <p class="text-sm font-bold text-slate-800">{{ item.plat }}</p>
                <p class="mt-0.5 text-xs text-slate-500">{{ item.pelanggan }}</p>
              </div>
              <p class="text-sm font-bold text-rose-500">{{ item.nominal }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- 10. Kartu Keadaan Stok (Donut Chart) -->
      <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-2">
            <h2 class="text-base font-bold text-slate-800">Keadaan Stok</h2>
            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="9" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01" />
            </svg>
          </div>
          <a href="#" class="text-sm font-medium text-slate-500 hover:text-emerald-600">Lihat Laporan →</a>
        </div>

        <div class="flex flex-col items-center gap-8 sm:flex-row">
          <div class="relative flex h-36 w-36 shrink-0 items-center justify-center">
            <svg class="h-36 w-36 -rotate-90" viewBox="0 0 36 36">
              <circle cx="18" cy="18" r="14" fill="none" stroke="#f1f5f9" stroke-width="3.8" />
              <circle
                cx="18"
                cy="18"
                r="14"
                fill="none"
                stroke="#10b981"
                stroke-width="3.8"
                stroke-dasharray="85.7 100"
                stroke-linecap="round"
              />
            </svg>
            <div class="absolute text-center">
              <p class="text-xs text-slate-400">Total</p>
              <p class="text-2xl font-bold text-slate-800 leading-tight">76</p>
              <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-bold text-emerald-600">97.4%</span>
            </div>
          </div>

          <div class="flex-1 w-full space-y-3 text-sm">
            <div class="flex items-center justify-between">
              <span class="flex items-center gap-2.5 text-slate-600">
                <span class="h-3 w-3 rounded-full bg-emerald-500"></span> Aman
              </span>
              <span class="font-bold text-slate-800">74 barang</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="flex items-center gap-2.5 text-slate-600">
                <span class="h-3 w-3 rounded-full bg-amber-400"></span> Menipis
              </span>
              <span class="font-bold text-slate-800">0 barang</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="flex items-center gap-2.5 text-slate-600">
                <span class="h-3 w-3 rounded-full bg-rose-500"></span> Habis
              </span>
              <span class="font-bold text-slate-800">2 barang</span>
            </div>
            <p class="pt-3 border-t border-slate-100 text-xs text-slate-500">
              Barang yang habis perlu di-restock sebelum bisa dipilih pada servis.
            </p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
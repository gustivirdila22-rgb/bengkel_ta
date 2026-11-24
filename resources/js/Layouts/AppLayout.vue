<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Header from '@/Components/Header.vue';

const pageTitles = {
  Beranda: 'Beranda',
  KasirCepat: 'Kasir Cepat',
  Servis: 'Servis',
  TambahServis: 'Servis',
  Pelanggan: 'Pelanggan & Kendaraan',
  JasaServis: 'Jasa Servis',
  TambahJasaServis: 'Jasa Servis',
  EditJasaServis: 'Jasa Servis',
};

const page = usePage();
const pageTitle = computed(() => pageTitles[page.component] ?? 'Bengkelin');
</script>

<template>
  <div class="flex min-h-screen bg-[#f6f7f9] text-slate-800">
    <Head :title="pageTitle" />

    <!-- Sidebar di Kiri -->
    <Sidebar />

    <!-- Area Kanan (Header + Konten) -->
    <div class="flex flex-1 flex-col min-w-0">
      <Header />

      <main class="flex-1 p-6">
        <div class="mx-auto max-w-7xl">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>
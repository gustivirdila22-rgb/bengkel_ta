<script setup>
import Sidebar from '@/Components/Sidebar.vue';
import Header from '@/Components/Header.vue';
</script>

<template>
  <div class="flex min-h-screen bg-[#f6f7f9] text-slate-800">
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
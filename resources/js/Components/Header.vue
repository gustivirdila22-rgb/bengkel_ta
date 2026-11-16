<script setup>
defineProps({
  userName: {
    type: String,
    default: 'Super Admin',
  },
  userRole: {
    type: String,
    default: 'Owner',
  },
});
</script>

<template>
  <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200/80 bg-white px-6">
    <!-- Kiri: Search Bar -->
    <div class="flex items-center">
      <div class="flex items-center gap-2.5 rounded-xl border border-slate-200 bg-slate-50/70 px-3.5 py-2 text-sm text-slate-400 w-72 sm:w-80">
        <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
        </svg>
        <input
          type="text"
          placeholder="Cari atau ketik perintah"
          class="w-full bg-transparent text-xs text-slate-700 placeholder-slate-400 focus:outline-none"
        />
        <kbd class="rounded border border-slate-200 bg-white px-1.5 py-0.5 text-[10px] font-semibold text-slate-500">
          CTRL+K
        </kbd>
      </div>
    </div>

    <!-- Kanan: Ikon Utilitas & Profil -->
    <div class="flex items-center gap-2">
      <!-- Ikon Bantuan -->
      <button type="button" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 transition" title="Bantuan">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <circle cx="12" cy="12" r="9" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3m.08 4h.01" />
        </svg>
      </button>

      <!-- Ikon Dark Mode -->
      <button type="button" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 transition" title="Mode Tampilan">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
        </svg>
      </button>

      <!-- Ikon Notifikasi -->
      <button type="button" class="relative rounded-lg p-2 text-slate-500 hover:bg-slate-100 transition" title="Notifikasi">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-emerald-500"></span>
      </button>

      <!-- Profil User -->
      <button
        type="button"
        class="ml-1 flex items-center gap-2.5 rounded-xl border border-slate-200 px-3 py-1.5 hover:bg-slate-50 transition"
      >
        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700">
          {{ userName.charAt(0) }}
        </div>
        <div class="hidden sm:block text-left">
          <p class="text-xs font-semibold text-slate-800 leading-tight">{{ userName }}</p>
          <p class="text-[10px] text-slate-400 leading-tight">{{ userRole }}</p>
        </div>
      </button>
    </div>
  </header>
</template>
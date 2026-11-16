<script setup>
import { useForm } from '@inertiajs/vue3';

defineProps({
  status: String,
});

const resendForm = useForm({});
const logoutForm = useForm({});

const submitResend = () => {
  resendForm.post('/email/verification-notification');
};

const logout = () => {
  logoutForm.post('/logout');
};
</script>

<template>
  <div class="flex min-h-screen items-center justify-center bg-[#f6f7f9] px-4 font-['Inter',sans-serif]">
    <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
      <!-- Logo -->
      <div class="flex items-center gap-3 mb-6">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-md shadow-emerald-500/20">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
        </div>
        <span class="text-xl font-bold tracking-tight text-slate-900">
          Bengkel<span class="text-emerald-600">in</span>
        </span>
      </div>

      <h1 class="text-xl font-bold text-slate-900">Verifikasi Email Anda</h1>
      <p class="mt-2 text-sm text-slate-600 leading-relaxed">
        Terima kasih telah mendaftar! Sebelum masuk ke dashboard bengkel, silakan klik tautan verifikasi yang baru saja kami kirim ke email Anda.
      </p>

      <!-- Notifikasi jika kirim ulang berhasil -->
      <div
        v-if="status === 'verification-link-sent'"
        class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 p-3.5 text-xs font-medium text-emerald-700"
      >
        Tautan verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.
      </div>

      <!-- Tombol Aksi -->
      <div class="mt-6 flex flex-col gap-3">
        <button
          type="button"
          @click="submitResend"
          :disabled="resendForm.processing"
          class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 disabled:opacity-50 transition"
        >
          {{ resendForm.processing ? 'Mengirim...' : 'Kirim Ulang Email Verifikasi' }}
        </button>

        <button
          type="button"
          @click="logout"
          class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 transition"
        >
          Keluar / Ganti Akun
        </button>
      </div>
    </div>
  </div>
</template>
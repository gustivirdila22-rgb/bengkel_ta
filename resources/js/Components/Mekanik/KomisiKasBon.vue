
<script setup>
</script>

<template>
    <div class="space-y-6 text-slate-700">

        <!-- Banner Informasi -->
        <div class="rounded-2xl bg-slate-100 px-5 py-4">
            <p class="text-base font-medium text-slate-900">
                Tidak perlu lagi menghitung komisi mekanik manual; tiap akhir periode angkanya sudah siap.
            </p>
        </div>

        <!-- Card Fitur Terkunci -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <!-- Badge Paket -->
            <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-600">
                    Paket sekarang: basic
                </span>

                <span class="inline-flex items-center gap-1 rounded-full bg-[#E6F5F0] px-3 py-1 text-xs font-medium text-[#009966]">
                    <span>🔒</span>
                    Komisi mekanik otomatis
                </span>
            </div>

            <!-- Deskripsi -->
            <p class="mt-5 text-sm leading-6 text-slate-600">
                Untuk memakainya, paket langganan bengkel perlu dinaikkan.
                Setelah paket diperbarui, menunya langsung bisa dibuka
                — tidak perlu memasang apa pun.
            </p>

            <!-- Informasi Langganan -->
            <div class="mt-4 rounded-xl bg-slate-100 px-4 py-3 text-xs leading-6 text-slate-500">
                Paket, fitur, dan masa berlaku langganan ada di
                <a
                    href="#"
                    class="font-medium text-[#009966] underline underline-offset-2"
                >
                    Langganan Saya
                </a>.
                Isi tiap paket beserta harganya ada di halaman Paket & Harga.
            </div>

            <!-- Tombol -->
            <div class="mt-5 flex flex-wrap gap-2">

                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#009966] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#00875B]"
                >
                    Lihat Paket & Harga
                    <span>↗</span>
                </button>

                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                >
                    <span>←</span>
                    Kembali ke Beranda
                </button>

            </div>
        </div>

        <!-- Fitur yang Ikut Terbuka -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <!-- Header Card -->
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-semibold text-slate-900">
                        Yang juga ikut terbuka
                    </h3>

                    <span
                        title="Fitur tambahan yang tersedia setelah upgrade paket"
                        class="cursor-help text-slate-400"
                    >
                        ⓘ
                    </span>
                </div>
            </div>

            <!-- Daftar Fitur -->
            <div class="space-y-3 px-6 py-5">

                <div class="flex items-start gap-3">
                    <span class="mt-0.5 text-[#009966]">✧</span>

                    <p class="text-sm leading-6 text-slate-600">
                        Pembukuan lengkap (Daftar Akun, Catatan Pembukuan,
                        Buku Besar, kerugian tanpa uang keluar & tutup buku)
                    </p>
                </div>

                <div class="flex items-start gap-3">
                    <span class="mt-0.5 text-[#009966]">✧</span>

                    <p class="text-sm leading-6 text-slate-600">
                        Atur hak akses staf sendiri
                    </p>
                </div>

                <div class="flex items-start gap-3">
                    <span class="mt-0.5 text-[#009966]">✧</span>

                    <p class="text-sm leading-6 text-slate-600">
                        Komisi mekanik otomatis
                        <span class="font-medium text-[#009966]">
                            — yang dicari
                        </span>
                    </p>
                </div>

            </div>
        </div>

    </div>
</template>

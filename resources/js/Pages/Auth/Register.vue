
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import {
    Wrench,
    Mail,
    Phone,
    Lock,
    ArrowRight,
    Eye,
    EyeOff,
    ClipboardList,
    Package,
    ChartNoAxesCombined,
} from 'lucide-vue-next'
import { ref } from 'vue'

const showPassword = ref(false)

const form = useForm({
    workshop_name: '',
    email: '',
    phone: '',
    password: '',
})

const submit = () => {
    form.post('/register')
}
</script>

<template>
    <Head title="Daftar Bengkelin" />

    <div class="min-h-screen bg-[#f5f6f3] flex items-center justify-center p-4 sm:p-6">

        <div class="w-full max-w-[1080px] min-h-[620px] bg-white rounded-2xl overflow-hidden shadow-[0_10px_40px_rgba(30,45,35,0.06)] grid lg:grid-cols-2">

            <!-- BAGIAN KIRI -->
            <div class="hidden lg:flex flex-col justify-start bg-[#293c32] px-10 xl:px-12 py-9 text-white relative overflow-hidden">

                <!-- Dekorasi background -->
                <div class="absolute w-80 h-80 rounded-full border border-white/[0.06] -top-28 -right-24"></div>
                <div class="absolute w-64 h-64 rounded-full border border-white/[0.06] -top-16 -right-16"></div>

                <!-- Logo -->
                <Link href="/" class="relative z-10 flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-[#b9c9a5] flex items-center justify-center">
                        <Wrench class="w-5 h-5 text-[#293c32]" />
                    </div>

                    <span class="text-xl font-bold tracking-tight">
                        Bengkelin
                    </span>
                </Link>

                <!-- Konten kiri -->
                <div class="relative z-10 mt-24">

                    <h1 class="text-4xl xl:text-[42px] font-bold leading-[1.2] mb-5 tracking-tight">
                        Mulai kelola bengkel dengan
                        <span class="text-[#c2d0ad]">lebih mudah.</span>
                    </h1>

                    <p class="text-white/60 text-sm leading-7 max-w-[370px]">
                        Bergabung dengan Bengkelin dan kelola transaksi,
                        stok sparepart, pelanggan, serta operasional bengkel
                        dalam satu aplikasi.
                    </p>

                    <!-- Fitur -->
                    <div class="mt-10 space-y-6">

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/[0.08] flex items-center justify-center">
                                <ClipboardList class="w-5 h-5 text-[#c2d0ad]" />
                            </div>

                            <div>
                                <p class="font-semibold text-sm">
                                    Manajemen Transaksi
                                </p>
                                <p class="text-white/45 text-xs mt-1">
                                    Catat servis dan pembayaran
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/[0.08] flex items-center justify-center">
                                <Package class="w-5 h-5 text-[#c2d0ad]" />
                            </div>

                            <div>
                                <p class="font-semibold text-sm">
                                    Manajemen Sparepart
                                </p>
                                <p class="text-white/45 text-xs mt-1">
                                    Pantau stok barang dengan mudah
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/[0.08] flex items-center justify-center">
                                <ChartNoAxesCombined class="w-5 h-5 text-[#c2d0ad]" />
                            </div>

                            <div>
                                <p class="font-semibold text-sm">
                                    Laporan Bengkel
                                </p>
                                <p class="text-white/45 text-xs mt-1">
                                    Pantau perkembangan usaha
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>


            <!-- BAGIAN KANAN -->
            <div class="flex items-center justify-center px-6 py-9 sm:px-10 lg:px-12">

                <div class="w-full max-w-[370px]">

                    <!-- Logo Mobile -->
                    <Link href="/" class="lg:hidden flex items-center gap-2.5 mb-8">
                        <div class="w-9 h-9 rounded-lg bg-[#293c32] flex items-center justify-center">
                            <Wrench class="w-5 h-5 text-[#c2d0ad]" />
                        </div>

                        <span class="text-lg font-bold text-[#293c32]">
                            Bengkelin
                        </span>
                    </Link>

                    <!-- Heading -->
                    <div class="mb-7">

                        <p class="text-xs font-semibold text-[#74856c] mb-2.5 tracking-wide">
                            DAFTAR AKUN
                        </p>

                        <h2 class="text-[28px] font-bold text-[#293c32] tracking-tight">
                            Daftarkan bengkelmu
                        </h2>

                        <p class="text-gray-400 text-[13px] mt-2 leading-5">
                            Isi informasi berikut untuk mulai menggunakan Bengkelin.
                        </p>

                    </div>


                    <!-- FORM -->
                    <form @submit.prevent="submit" class="space-y-4">

                        <!-- Nama Bengkel -->
                        <div>
                            <label class="block text-[13px] font-semibold text-[#414c43] mb-1.5">
                                Nama Bengkel
                            </label>

                            <div class="relative">
                                <Wrench class="absolute left-3.5 top-1/2 -translate-y-1/2 w-[17px] h-[17px] text-[#9ba59b]" />

                                <input
                                    v-model="form.workshop_name"
                                    type="text"
                                    placeholder="Contoh: Bengkel Jaya Motor"
                                    required
                                    class="w-full h-[46px] pl-10 pr-3 rounded-lg border border-[#e5e9e3] bg-[#fafbf9] text-[13px] text-[#293c32] placeholder:text-gray-400 outline-none focus:border-[#899a80] focus:ring-2 focus:ring-[#899a80]/10 focus:bg-white transition"
                                />
                            </div>

                            <p v-if="form.errors.workshop_name" class="text-red-500 text-xs mt-1.5">
                                {{ form.errors.workshop_name }}
                            </p>
                        </div>


                        <!-- Email -->
                        <div>
                            <label class="block text-[13px] font-semibold text-[#414c43] mb-1.5">
                                Email
                            </label>

                            <div class="relative">
                                <Mail class="absolute left-3.5 top-1/2 -translate-y-1/2 w-[17px] h-[17px] text-[#9ba59b]" />

                                <input
                                    v-model="form.email"
                                    type="email"
                                    placeholder="nama@email.com"
                                    required
                                    class="w-full h-[46px] pl-10 pr-3 rounded-lg border border-[#e5e9e3] bg-[#fafbf9] text-[13px] text-[#293c32] placeholder:text-gray-400 outline-none focus:border-[#899a80] focus:ring-2 focus:ring-[#899a80]/10 focus:bg-white transition"
                                />
                            </div>

                            <p v-if="form.errors.email" class="text-red-500 text-xs mt-1.5">
                                {{ form.errors.email }}
                            </p>
                        </div>


                        <!-- Nomor HP -->
                        <div>
                            <label class="block text-[13px] font-semibold text-[#414c43] mb-1.5">
                                Nomor HP
                            </label>

                            <div class="relative">
                                <Phone class="absolute left-3.5 top-1/2 -translate-y-1/2 w-[17px] h-[17px] text-[#9ba59b]" />

                                <input
                                    v-model="form.phone"
                                    type="tel"
                                    placeholder="08xxxxxxxxxx"
                                    required
                                    class="w-full h-[46px] pl-10 pr-3 rounded-lg border border-[#e5e9e3] bg-[#fafbf9] text-[13px] text-[#293c32] placeholder:text-gray-400 outline-none focus:border-[#899a80] focus:ring-2 focus:ring-[#899a80]/10 focus:bg-white transition"
                                />
                            </div>

                            <p v-if="form.errors.phone" class="text-red-500 text-xs mt-1.5">
                                {{ form.errors.phone }}
                            </p>
                        </div>


                        <!-- Password -->
                        <div>
                            <label class="block text-[13px] font-semibold text-[#414c43] mb-1.5">
                                Password
                            </label>

                            <div class="relative">
                                <Lock class="absolute left-3.5 top-1/2 -translate-y-1/2 w-[17px] h-[17px] text-[#9ba59b]" />

                                <input
                                    v-model="form.password"
                                    :type="showPassword ? 'text' : 'password'"
                                    placeholder="Minimal 8 karakter"
                                    required
                                    class="w-full h-[46px] pl-10 pr-11 rounded-lg border border-[#e5e9e3] bg-[#fafbf9] text-[13px] text-[#293c32] placeholder:text-gray-400 outline-none focus:border-[#899a80] focus:ring-2 focus:ring-[#899a80]/10 focus:bg-white transition"
                                />

                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#9ba59b] hover:text-[#52654f] transition"
                                >
                                    <Eye v-if="!showPassword" class="w-[17px] h-[17px]" />
                                    <EyeOff v-else class="w-[17px] h-[17px]" />
                                </button>
                            </div>

                            <p v-if="form.errors.password" class="text-red-500 text-xs mt-1.5">
                                {{ form.errors.password }}
                            </p>
                        </div>


                        <!-- Tombol Daftar -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full h-[47px] mt-2 bg-[#354b3c] hover:bg-[#293c32] disabled:opacity-60 text-white text-sm font-semibold rounded-lg flex items-center justify-center gap-2 transition shadow-sm"
                        >
                            {{ form.processing ? 'Memproses...' : 'Daftar Sekarang' }}

                            <ArrowRight v-if="!form.processing" class="w-4 h-4" />
                        </button>

                    </form>


                    <!-- Login -->
                    <div class="mt-6 text-center text-[13px] text-gray-500">
                        Sudah memiliki akun?

                        <Link href="/login" class="font-semibold text-[#586e53] hover:text-[#293c32] hover:underline">
                            Masuk di sini
                        </Link>
                    </div>


                    <!-- Kembali -->
                    <div class="mt-6 pt-5 border-t border-[#edf0eb] text-center">
                        <Link href="/" class="text-xs text-gray-400 hover:text-[#586e53] transition">
                            Kembali ke halaman utama
                        </Link>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>


<script setup>
import {
    Wrench, Package, Users, ChartNoAxesCombined, ClipboardList,
    ArrowUpRight, Check, Clock3, Wallet, Bell, CarFront, ShieldCheck,
    Boxes, ReceiptText, CalendarClock, ArrowRight, CircleCheck,
    Activity, Search, MoreHorizontal, ChevronRight, Menu, X,
} from 'lucide-vue-next';

import { ref } from 'vue';

const mobileMenuOpen = ref(false);

const features = [
    { icon: ClipboardList, title: 'Manajemen Servis', description: 'Catat setiap kendaraan masuk, keluhan pelanggan, proses pengerjaan, hingga servis selesai.' },
    { icon: Package, title: 'Stok Sparepart', description: 'Pantau persediaan sparepart, riwayat barang masuk dan keluar, serta stok minimum.' },
    { icon: Users, title: 'Data Pelanggan', description: 'Simpan informasi pelanggan dan riwayat servis kendaraan dengan lebih terorganisir.' },
    { icon: ReceiptText, title: 'Transaksi & Invoice', description: 'Buat tagihan servis dan catat transaksi bengkel secara praktis dan rapi.' },
    { icon: ChartNoAxesCombined, title: 'Laporan Bengkel', description: 'Lihat ringkasan pendapatan, jumlah servis, dan performa bengkel.' },
    { icon: CalendarClock, title: 'Jadwal Servis', description: 'Atur jadwal servis agar pekerjaan bengkel lebih terencana.' },
];

const faqs = [
    { question: 'Apa itu Bengkelin?', answer: 'Bengkelin adalah aplikasi manajemen bengkel yang membantu mengelola servis kendaraan, sparepart, pelanggan, transaksi, dan laporan dalam satu sistem.' },
    { question: 'Apakah Bengkelin bisa digunakan di HP?', answer: 'Bisa. Tampilan Bengkelin dirancang responsif sehingga dapat digunakan melalui laptop, tablet, maupun smartphone.' },
    { question: 'Apakah aplikasi ini cocok untuk bengkel kecil?', answer: 'Tentu. Bengkelin dirancang untuk membantu operasional bengkel agar lebih teratur, baik untuk bengkel kecil maupun bengkel yang sedang berkembang.' },
    { question: 'Bagaimana cara mulai menggunakan Bengkelin?', answer: 'Kamu bisa memulai dengan membuat akun melalui tombol Daftar, kemudian melengkapi informasi bengkel.' },
];
</script>

<template>
    <div class="page">
        <header class="navbar">
            <a href="#" class="logo">
                <span class="logo-mark"><Wrench :size="21" :stroke-width="2.5" /></span>
                <span>Bengkel<span class="logo-green">in.</span></span>
            </a>

            <nav class="desktop-nav">
                <a href="#fitur">Fitur</a>
                <a href="#faq">FAQ</a>
            </nav>

            <div class="nav-actions">
                <a href="/login" class="login-link">Masuk</a>
                <a href="/register" class="btn btn-primary nav-register">
                    Daftar <ArrowUpRight :size="16" />
                </a>
            </div>

            <button class="mobile-menu-button" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Buka menu">
                <X v-if="mobileMenuOpen" :size="23" />
                <Menu v-else :size="23" />
            </button>

            <div v-if="mobileMenuOpen" class="mobile-menu">
                <a href="#fitur" @click="mobileMenuOpen = false">Fitur</a>
                <a href="#faq" @click="mobileMenuOpen = false">FAQ</a>
                <a href="/login" @click="mobileMenuOpen = false">Masuk</a>
                <a href="/register" class="mobile-register" @click="mobileMenuOpen = false">
                    Daftar Sekarang <ArrowUpRight :size="16" />
                </a>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="hero-content">
                    <div class="eyebrow">
                        <span class="eyebrow-dot"></span>
                        APLIKASI MANAJEMEN BENGKEL
                    </div>

                    <h1>
                        Kelola Bengkel Lebih
                        <span class="text-green">Mudah.</span>
                        <span class="heading-dark">Kerja Jadi Lebih Terarah.</span>
                    </h1>

                    <p class="hero-description">
                        Semua kebutuhan bengkel dalam satu aplikasi.
                        Mulai dari data servis, stok sparepart, pelanggan,
                        hingga laporan keuangan.
                    </p>

                    <div class="hero-actions">
                        <a href="/register" class="btn btn-primary btn-large">
                            Mulai Sekarang <ArrowUpRight :size="18" />
                        </a>
                        <a href="#fitur" class="btn btn-outline btn-large">
                            Jelajahi Fitur <ArrowRight :size="17" />
                        </a>
                    </div>

                    <div class="hero-trust">
                        <span><CircleCheck :size="16" /> Mudah digunakan</span>
                        <span><CircleCheck :size="16" /> Data lebih teratur</span>
                    </div>
                </div>

                <div class="visual-wrap">
                    <div class="visual-glow"></div>

                    <div class="dashboard">
                        <div class="dash-header">
                            <div class="dash-brand">
                                <span class="dash-logo"><Wrench :size="15" /></span>
                                <div>
                                    <strong>Bengkelin</strong>
                                    <small>Dashboard Bengkel</small>
                                </div>
                            </div>

                            <div class="dash-profile">
                                <span class="online-dot"></span>
                                <span>Admin Bengkel</span>
                                <div class="avatar">A</div>
                            </div>
                        </div>

                        <div class="dash-welcome">
                            <div>
                                <span class="dash-date">SENIN, 16 NOVEMBER 2026</span>
                                <h3>Selamat datang, Admin!</h3>
                                <p>Berikut ringkasan aktivitas bengkel hari ini.</p>
                            </div>
                            <button class="dash-more"><MoreHorizontal :size="20" /></button>
                        </div>

                        <div class="stat-grid">
                            <div class="stat-card">
                                <div class="stat-top">
                                    <span>Total Servis</span>
                                    <span class="stat-icon green-bg"><Wrench :size="17" /></span>
                                </div>
                                <strong>24</strong>
                                <small><span class="positive">+12%</span> dari bulan lalu</small>
                            </div>

                            <div class="stat-card">
                                <div class="stat-top">
                                    <span>Pelanggan</span>
                                    <span class="stat-icon blue-bg"><Users :size="17" /></span>
                                </div>
                                <strong>186</strong>
                                <small><span class="positive">+8%</span> dari bulan lalu</small>
                            </div>

                            <div class="stat-card">
                                <div class="stat-top">
                                    <span>Pendapatan</span>
                                    <span class="stat-icon orange-bg"><Wallet :size="17" /></span>
                                </div>
                                <strong>8,5jt</strong>
                                <small><span class="positive">+15%</span> dari bulan lalu</small>
                            </div>
                        </div>

                        <div class="dash-bottom">
                            <div class="activity-card">
                                <div class="card-heading">
                                    <div>
                                        <strong>Servis Terbaru</strong>
                                        <small>Aktivitas hari ini</small>
                                    </div>
                                    <span class="view-all">Lihat semua <ChevronRight :size="13" /></span>
                                </div>

                                <div class="service-row">
                                    <div class="vehicle-icon"><CarFront :size="17" /></div>
                                    <div class="service-info">
                                        <strong>Honda Vario 125</strong>
                                        <small>Andi Saputra</small>
                                    </div>
                                    <span class="status status-done">Selesai</span>
                                </div>

                                <div class="service-row">
                                    <div class="vehicle-icon"><CarFront :size="17" /></div>
                                    <div class="service-info">
                                        <strong>Yamaha NMAX</strong>
                                        <small>Budi Santoso</small>
                                    </div>
                                    <span class="status status-process">Proses</span>
                                </div>

                                <div class="service-row">
                                    <div class="vehicle-icon"><CarFront :size="17" /></div>
                                    <div class="service-info">
                                        <strong>Honda Beat</strong>
                                        <small>Dina Putri</small>
                                    </div>
                                    <span class="status status-wait">Menunggu</span>
                                </div>
                            </div>

                            <div class="stock-card">
                                <div class="card-heading">
                                    <div>
                                        <strong>Stok Sparepart</strong>
                                        <small>Status persediaan</small>
                                    </div>
                                    <Boxes :size="18" class="stock-heading-icon" />
                                </div>

                                <div class="stock-number">
                                    <strong>128</strong>
                                    <small>Item tersedia</small>
                                </div>

                                <div class="stock-progress"><span></span></div>

                                <div class="stock-note">
                                    <span class="stock-dot"></span>
                                    5 item perlu diperiksa
                                </div>
                            </div>
                        </div>

                        <div class="dash-footer">
                            <span><Activity :size="13" /> Sistem berjalan normal</span>
                            <span>Terakhir diperbarui: Baru saja</span>
                        </div>
                    </div>

                    <div class="floating-card">
                        <span class="floating-icon"><Check :size="18" /></span>
                        <div>
                            <strong>Data tersimpan</strong>
                            <small>Semua aktivitas tercatat rapi</small>
                        </div>
                    </div>
                </div>
            </section>

            <section class="benefit-strip">
                <div class="benefit-item">
                    <span class="benefit-icon"><Clock3 :size="19" /></span>
                    <div><strong>Hemat Waktu</strong><small>Proses kerja lebih praktis</small></div>
                </div>
                <div class="benefit-item">
                    <span class="benefit-icon"><ShieldCheck :size="19" /></span>
                    <div><strong>Data Terorganisir</strong><small>Informasi tersimpan rapi</small></div>
                </div>
                <div class="benefit-item">
                    <span class="benefit-icon"><ChartNoAxesCombined :size="19" /></span>
                    <div><strong>Kontrol Lebih Baik</strong><small>Pantau aktivitas bengkel</small></div>
                </div>
                <div class="benefit-item">
                    <span class="benefit-icon"><Bell :size="19" /></span>
                    <div><strong>Lebih Terpantau</strong><small>Informasi mudah ditemukan</small></div>
                </div>
            </section>

            <section class="problems">
                <div class="section-heading">
                    <span class="section-label">KENALI MASALAHNYA</span>
                    <h2>Jangan biarkan urusan administrasi<br />menghambat bisnis bengkelmu.</h2>
                    <p>
                        Mengelola bengkel bukan cuma soal memperbaiki kendaraan.
                        Ada banyak hal yang harus dipantau setiap hari.
                    </p>
                </div>

                <div class="problem-grid">
                    <div class="problem-card">
                        <span class="problem-number">01</span>
                        <div class="problem-icon"><ClipboardList :size="23" /></div>
                        <h3>Pencatatan Berantakan</h3>
                        <p>Data servis yang menumpuk membuat informasi pelanggan sulit dicari.</p>
                    </div>

                    <div class="problem-card">
                        <span class="problem-number">02</span>
                        <div class="problem-icon"><Package :size="23" /></div>
                        <h3>Stok Tidak Terpantau</h3>
                        <p>Sparepart habis tanpa disadari bisa menghambat pekerjaan bengkel.</p>
                    </div>

                    <div class="problem-card">
                        <span class="problem-number">03</span>
                        <div class="problem-icon"><ChartNoAxesCombined :size="23" /></div>
                        <h3>Laporan Tidak Praktis</h3>
                        <p>Menghitung pendapatan dan melihat perkembangan bengkel jadi lebih sulit.</p>
                    </div>
                </div>
            </section>

            <section class="features" id="fitur">
                <div class="section-heading">
                    <span class="section-label">FITUR BENGKELIN</span>
                    <h2>Semua kebutuhan bengkel,<br /><span class="text-green">dalam satu tempat.</span></h2>
                    <p>
                        Kelola kegiatan operasional bengkel dengan fitur
                        yang dirancang agar pekerjaan lebih teratur.
                    </p>
                </div>

                <div class="feature-grid">
                    <article v-for="(feature, index) in features" :key="feature.title" class="feature-card">
                        <div class="feature-top">
                            <span class="feature-icon"><component :is="feature.icon" :size="23" /></span>
                            <span class="feature-index">0{{ index + 1 }}</span>
                        </div>
                        <h3>{{ feature.title }}</h3>
                        <p>{{ feature.description }}</p>
                        <a href="/register" class="feature-link">
                            Pelajari lebih lanjut <ArrowUpRight :size="16" />
                        </a>
                    </article>
                </div>
            </section>

            <section class="cta">
                <div class="cta-decoration decoration-one"></div>
                <div class="cta-decoration decoration-two"></div>

                <div class="cta-content">
                    <span class="cta-label">SAATNYA BENGKEL LEBIH TERATUR</span>
                    <h2>Mulai kelola bengkel<br />dengan cara yang lebih mudah.</h2>
                    <p>
                        Tinggalkan pencatatan yang merepotkan.
                        Saatnya beralih ke pengelolaan bengkel yang lebih praktis.
                    </p>
                    <div class="cta-actions">
                        <a href="/register" class="btn btn-white">
                            Daftar Sekarang <ArrowUpRight :size="17" />
                        </a>
                        <a href="#faq" class="btn btn-cta-outline">Pelajari Lebih Lanjut</a>
                    </div>
                </div>

                <div class="cta-visual">
                    <div class="cta-icon-large"><Wrench :size="48" :stroke-width="1.5" /></div>
                    <div class="cta-mini-card"><CircleCheck :size="17" /> Bengkel lebih terorganisir</div>
                </div>
            </section>

            <section class="faq" id="faq">
                <div class="faq-intro">
                    <span class="section-label">FAQ</span>
                    <h2>Ada yang ingin<br />kamu tanyakan?</h2>
                    <p>
                        Temukan jawaban dari beberapa pertanyaan
                        yang sering ditanyakan tentang Bengkelin.
                    </p>
                    <a href="/register" class="faq-contact">Mulai sekarang <ArrowUpRight :size="16" /></a>
                </div>

                <div class="faq-list">
                    <details v-for="faq in faqs" :key="faq.question">
                        <summary>
                            <span>{{ faq.question }}</span>
                            <span class="faq-plus"><span></span><span></span></span>
                        </summary>
                        <p>{{ faq.answer }}</p>
                    </details>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="footer-main">
                <div class="footer-brand">
                    <a href="#" class="logo footer-logo">
                        <span class="logo-mark"><Wrench :size="20" /></span>
                        <span>Bengkel<span class="logo-green">in.</span></span>
                    </a>
                    <p>
                        Solusi praktis untuk membantu pengelolaan
                        operasional bengkel menjadi lebih mudah dan teratur.
                    </p>
                </div>

                <div class="footer-links">
                    <strong>Navigasi</strong>
                    <a href="#fitur">Fitur</a>
                    <a href="#faq">FAQ</a>
                    <a href="/login">Masuk</a>
                    <a href="/register">Daftar</a>
                </div>

                <div class="footer-links">
                    <strong>Mulai Bersama Kami</strong>
                    <a href="/register">Buat Akun</a>
                    <a href="/login">Masuk ke Aplikasi</a>
                </div>
            </div>

            <div class="footer-bottom">
                <span>© 2026 Bengkelin. All rights reserved.</span>
                <span>Solusi digital untuk bengkel Indonesia.</span>
            </div>
        </footer>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
    color: #172b24;
    background: #ffffff;
    font-synthesis: none;
    text-rendering: optimizeLegibility;
    scroll-behavior: smooth;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    margin: 0;
    min-width: 320px;
    font-size: 16px;
}

button, a { font: inherit; }
a { color: inherit; text-decoration: none; }
button { cursor: pointer; }

.page {
    width: 100%;
    overflow: hidden;
    background: #fff;
}

/* NAVBAR */
.navbar {
    height: 82px;
    padding: 0 8%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 20;
    background: rgba(255,255,255,.94);
    border-bottom: 1px solid #edf1ee;
}

.logo {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 22px;
    font-weight: 800;
    letter-spacing: -1.1px;
}

.logo-mark {
    width: 39px;
    height: 39px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    background: #087e50;
    color: #fff;
}

.logo-green { color: #0b9b63; }

.desktop-nav {
    display: flex;
    align-items: center;
    gap: 38px;
    margin-left: 70px;
}

.desktop-nav a, .login-link {
    font-size: 15px;
    font-weight: 600;
    color: #607068;
    transition: color .2s;
}

.desktop-nav a:hover, .login-link:hover { color: #078353; }

.nav-actions {
    display: flex;
    align-items: center;
    gap: 27px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    border-radius: 9px;
    font-size: 14px;
    font-weight: 700;
    transition: .2s ease;
}

.btn-primary {
    background: #087e50;
    color: #fff;
    box-shadow: 0 5px 14px rgba(8,126,80,.13);
}

.btn-primary:hover {
    background: #066b44;
    transform: translateY(-2px);
}

.nav-register { padding: 12px 19px; }
.mobile-menu-button, .mobile-menu { display: none; }

/* HERO */
.hero {
    min-height: 650px;
    padding: 90px 8% 100px;
    display: grid;
    grid-template-columns: .95fr 1.05fr;
    align-items: center;
    gap: 65px;
    background: radial-gradient(ellipse at 82% 35%, rgba(209,244,226,.6), transparent 38%), linear-gradient(180deg, #fbfefc 0%, #fff 100%);
}

.hero-content { max-width: 540px; }

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: #078353;
    background: #eaf7ef;
    border: 1px solid #d8f0e1;
    border-radius: 30px;
    padding: 9px 14px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.1px;
    margin-bottom: 25px;
}

.eyebrow-dot, .online-dot {
    width: 7px;
    height: 7px;
    background: #16a36b;
    border-radius: 50%;
}

.hero h1 {
    font-size: clamp(48px, 4.5vw, 64px);
    line-height: 1.15;
    letter-spacing: -3.2px;
    font-weight: 800;
    color: #173a2b;
}

.text-green { color: #0a9b62; }
.heading-dark { display: block; color: #173a2b; }

.hero-description {
    color: #718078;
    font-size: 16px;
    line-height: 1.9;
    margin-top: 23px;
    max-width: 460px;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 13px;
    margin-top: 30px;
}

.btn-large { min-height: 51px; padding: 0 22px; }

.btn-outline {
    border: 1px solid #dce8e0;
    color: #315c47;
    background: #fff;
}

.btn-outline:hover { border-color: #0a9b62; color: #087e50; }

.hero-trust {
    display: flex;
    flex-wrap: wrap;
    gap: 22px;
    margin-top: 28px;
    color: #718078;
    font-size: 13px;
    font-weight: 600;
}

.hero-trust span { display: flex; align-items: center; gap: 7px; }
.hero-trust svg { color: #0b9b63; }

/* DASHBOARD */
.visual-wrap { position: relative; min-width: 0; }

.visual-glow {
    position: absolute;
    width: 85%;
    height: 85%;
    top: 10%;
    left: 8%;
    background: #a9e9c8;
    filter: blur(90px);
    opacity: .4;
}

.dashboard {
    position: relative;
    z-index: 1;
    background: #fff;
    border: 1px solid #e7eee9;
    border-radius: 17px;
    padding: 22px;
    box-shadow: 0 25px 75px rgba(27,76,51,.12);
}

.dash-header, .dash-brand, .dash-profile, .dash-footer {
    display: flex;
    align-items: center;
}

.dash-header {
    justify-content: space-between;
    padding-bottom: 20px;
    border-bottom: 1px solid #edf1ee;
}

.dash-brand { gap: 9px; }
.dash-logo {
    width: 31px;
    height: 31px;
    display: grid;
    place-items: center;
    color: #fff;
    background: #087e50;
    border-radius: 9px;
}

.dash-brand strong, .dash-brand small { display: block; }
.dash-brand strong { font-size: 13px; color: #244b37; }
.dash-brand small { font-size: 10px; color: #9aa89f; margin-top: 3px; }

.dash-profile { gap: 7px; font-size: 11px; color: #78877e; }

.avatar {
    width: 27px;
    height: 27px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: #e1f3e7;
    color: #087e50;
    font-size: 12px;
    font-weight: 800;
}

.dash-welcome {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 23px 0 18px;
}

.dash-date {
    font-size: 10px;
    letter-spacing: .8px;
    font-weight: 700;
    color: #a1ada5;
}

.dash-welcome h3 { margin-top: 6px; font-size: 19px; color: #234b37; }
.dash-welcome p { margin-top: 5px; color: #94a198; font-size: 11px; }

.dash-more {
    border: 0;
    background: #f4f7f5;
    color: #75857b;
    border-radius: 7px;
    padding: 6px;
}

.stat-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0,1fr));
    gap: 11px;
}

.stat-card {
    padding: 13px;
    border: 1px solid #edf1ee;
    border-radius: 10px;
    min-width: 0;
}

.stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 5px;
    color: #87948c;
    font-size: 11px;
    font-weight: 600;
}

.stat-icon {
    width: 29px;
    height: 29px;
    display: grid;
    place-items: center;
    border-radius: 8px;
}

.green-bg { background: #e6f6ec; color: #0b9b63; }
.blue-bg { background: #eaf2ff; color: #5086d8; }
.orange-bg { background: #fff2e6; color: #df9447; }

.stat-card > strong {
    display: block;
    margin-top: 11px;
    color: #244b37;
    font-size: 25px;
    letter-spacing: -.8px;
}

.stat-card > small { display: block; margin-top: 5px; font-size: 10px; color: #9ba89f; }
.positive { color: #0b9b63; font-weight: 800; }

.dash-bottom {
    display: grid;
    grid-template-columns: 1.4fr .9fr;
    gap: 12px;
    margin-top: 15px;
}

.activity-card, .stock-card {
    border: 1px solid #edf1ee;
    border-radius: 10px;
    padding: 14px;
    min-width: 0;
}

.card-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 13px;
}

.card-heading strong, .card-heading small { display: block; }
.card-heading strong { color: #315340; font-size: 12px; }
.card-heading small { color: #9ba89f; font-size: 10px; margin-top: 4px; }

.view-all {
    display: inline-flex;
    align-items: center;
    color: #0b9b63;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}

.service-row {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 0;
    border-top: 1px solid #f0f3f1;
    min-width: 0;
}

.vehicle-icon {
    width: 28px;
    height: 28px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    border-radius: 8px;
    background: #f0f7f2;
    color: #0b9660;
}

.service-info { min-width: 0; flex: 1; }
.service-info strong, .service-info small { display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.service-info strong { font-size: 11px; color: #4b6354; }
.service-info small { font-size: 10px; color: #a2ada5; margin-top: 3px; }

.status {
    font-size: 9px;
    font-weight: 700;
    padding: 5px 7px;
    border-radius: 5px;
    white-space: nowrap;
}

.status-done { background: #e9f8ee; color: #168552; }
.status-process { background: #fff5e5; color: #ca913d; }
.status-wait { background: #edf3ff; color: #6188c9; }
.stock-heading-icon { color: #0b9b63; }

.stock-number { margin: 19px 0 12px; }
.stock-number strong { display: block; color: #244b37; font-size: 32px; }
.stock-number small { color: #9ba89f; font-size: 11px; }

.stock-progress {
    width: 100%;
    height: 7px;
    background: #edf2ee;
    border-radius: 10px;
    overflow: hidden;
}

.stock-progress span {
    display: block;
    width: 76%;
    height: 100%;
    border-radius: 10px;
    background: #19a36b;
}

.stock-note {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 14px;
    font-size: 10px;
    color: #9b8870;
}

.stock-dot { width: 6px; height: 6px; border-radius: 50%; background: #e6a84d; }

.dash-footer {
    justify-content: space-between;
    gap: 8px;
    border-top: 1px solid #edf1ee;
    padding-top: 13px;
    margin-top: 15px;
    color: #a0aaa3;
    font-size: 10px;
}

.dash-footer span:first-child {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #16915d;
}

.floating-card {
    position: absolute;
    z-index: 2;
    left: -35px;
    bottom: -26px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 13px 17px;
    background: #fff;
    border: 1px solid #e8f0ea;
    border-radius: 12px;
    box-shadow: 0 12px 35px rgba(35,76,51,.12);
}

.floating-icon {
    width: 32px;
    height: 32px;
    display: grid;
    place-items: center;
    color: #fff;
    background: #0b9b63;
    border-radius: 9px;
}

.floating-card strong, .floating-card small { display: block; }
.floating-card strong { font-size: 12px; color: #315340; }
.floating-card small { margin-top: 4px; color: #9ba89f; font-size: 10px; }

/* BENEFITS */
.benefit-strip {
    padding: 28px 8%;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    border-top: 1px solid #edf2ee;
    border-bottom: 1px solid #edf2ee;
}

.benefit-item { display: flex; align-items: center; justify-content: center; gap: 12px; }
.benefit-icon {
    width: 39px;
    height: 39px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    border-radius: 11px;
    background: #edf8f1;
    color: #0b9660;
}

.benefit-item strong, .benefit-item small { display: block; }
.benefit-item strong { color: #315340; font-size: 13px; }
.benefit-item small { margin-top: 4px; color: #9ba89f; font-size: 11px; }

/* SECTION */
.section-heading { text-align: center; max-width: 700px; margin: 0 auto 48px; }
.section-label { color: #0b9660; font-size: 11px; font-weight: 800; letter-spacing: 1.5px; }

.section-heading h2, .faq-intro h2 {
    margin-top: 16px;
    color: #1e3d2c;
    font-size: 42px;
    line-height: 1.3;
    letter-spacing: -1.7px;
    font-weight: 800;
}

.section-heading p {
    max-width: 520px;
    margin: 14px auto 0;
    color: #829087;
    font-size: 15px;
    line-height: 1.8;
}

/* PROBLEMS */
.problems { padding: 105px 8%; background: #fbfdfb; }

.problem-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0,1fr));
    gap: 19px;
}

.problem-card {
    position: relative;
    padding: 29px;
    background: #fff;
    border: 1px solid #eaf0eb;
    border-radius: 14px;
    transition: .25s;
}

.problem-card:hover, .feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(31,78,49,.07);
    border-color: #cde8d6;
}

.problem-number {
    position: absolute;
    right: 25px;
    top: 24px;
    color: #dce9df;
    font-size: 14px;
    font-weight: 800;
}

.problem-icon {
    width: 48px;
    height: 48px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    color: #0b9660;
    background: #eaf7ef;
}

.problem-card h3 { margin-top: 23px; color: #315340; font-size: 17px; }
.problem-card p { margin-top: 10px; color: #87948c; font-size: 14px; line-height: 1.8; }

/* FEATURES */
.features { padding: 105px 8%; background: #fff; }

.feature-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0,1fr));
    gap: 17px;
}

.feature-card {
    min-width: 0;
    padding: 26px;
    border: 1px solid #e9f0eb;
    border-radius: 14px;
    transition: .25s;
}

.feature-top { display: flex; align-items: center; justify-content: space-between; }

.feature-icon {
    width: 47px;
    height: 47px;
    display: grid;
    place-items: center;
    color: #0b9660;
    background: #eaf7ef;
    border-radius: 12px;
}

.feature-index { color: #d6e4d9; font-size: 14px; font-weight: 800; }
.feature-card h3 { margin-top: 22px; color: #315340; font-size: 17px; }
.feature-card p { min-height: 66px; margin-top: 9px; color: #87948c; font-size: 14px; line-height: 1.8; }

.feature-link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 17px;
    color: #0b9660;
    font-size: 13px;
    font-weight: 800;
}

/* CTA */
.cta {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 35px;
    margin: 0 8% 100px;
    padding: 65px 7%;
    overflow: hidden;
    background: #087e50;
    border-radius: 20px;
}

.cta-content { position: relative; z-index: 2; max-width: 580px; }
.cta-label { color: #a8e6c4; font-size: 11px; font-weight: 800; letter-spacing: 1.4px; }

.cta h2 {
    margin-top: 17px;
    color: #fff;
    font-size: 42px;
    line-height: 1.3;
    letter-spacing: -1.5px;
}

.cta-content > p { max-width: 450px; margin-top: 14px; color: #d0e8da; font-size: 14px; line-height: 1.9; }
.cta-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 26px; }

.btn-white {
    min-height: 46px;
    padding: 0 19px;
    background: #fff;
    color: #087e50;
}

.btn-white:hover { background: #eaf7ef; transform: translateY(-2px); }

.btn-cta-outline {
    min-height: 46px;
    padding: 0 19px;
    border: 1px solid rgba(255,255,255,.4);
    color: #fff;
}

.btn-cta-outline:hover { background: rgba(255,255,255,.1); }

.cta-visual {
    position: relative;
    z-index: 2;
    width: 220px;
    height: 190px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
}

.cta-icon-large {
    width: 125px;
    height: 125px;
    display: grid;
    place-items: center;
    color: #d6f5e2;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 35px;
    transform: rotate(-9deg);
}

.cta-mini-card {
    position: absolute;
    right: -10px;
    bottom: 4px;
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 11px 13px;
    background: #fff;
    color: #315340;
    border-radius: 9px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    box-shadow: 0 8px 25px rgba(0,0,0,.12);
}

.cta-mini-card svg { color: #0b9660; }

.cta-decoration { position: absolute; border: 1px solid rgba(255,255,255,.1); border-radius: 50%; }
.decoration-one { width: 400px; height: 400px; right: 5%; top: -250px; }
.decoration-two { width: 300px; height: 300px; right: 0; bottom: -230px; }

/* FAQ */
.faq {
    padding: 20px 8% 110px;
    display: grid;
    grid-template-columns: .8fr 1.2fr;
    gap: 90px;
}

.faq-intro h2 { font-size: 39px; }

.faq-intro p {
    margin-top: 14px;
    max-width: 330px;
    color: #87948c;
    font-size: 14px;
    line-height: 1.9;
}

.faq-contact {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 22px;
    color: #0b9660;
    font-size: 14px;
    font-weight: 800;
}

.faq-list details { border-bottom: 1px solid #e9efeb; padding: 21px 0; }
.faq-list details:first-child { border-top: 1px solid #e9efeb; }

.faq-list summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    list-style: none;
    cursor: pointer;
    color: #315340;
    font-size: 15px;
    font-weight: 700;
}

.faq-list summary::-webkit-details-marker { display: none; }

.faq-plus {
    width: 25px;
    height: 25px;
    flex-shrink: 0;
    position: relative;
    display: grid;
    place-items: center;
    background: #edf8f1;
    border-radius: 50%;
}

.faq-plus span {
    position: absolute;
    width: 10px;
    height: 1.5px;
    background: #0b9660;
    border-radius: 5px;
}

.faq-plus span:last-child { transform: rotate(90deg); transition: .2s; }
.faq-list details[open] .faq-plus span:last-child { transform: rotate(0); }

.faq-list details p {
    padding: 13px 35px 0 0;
    color: #87948c;
    font-size: 13px;
    line-height: 1.9;
}

/* FOOTER */
.footer {
    padding: 55px 8% 23px;
    background: #f8fbf8;
    border-top: 1px solid #edf2ee;
}

.footer-main {
    display: grid;
    grid-template-columns: 1.7fr 1fr 1fr;
    gap: 55px;
    padding-bottom: 42px;
}

.footer-brand p {
    max-width: 330px;
    margin-top: 17px;
    color: #87948c;
    font-size: 13px;
    line-height: 1.9;
}

.footer-links { display: flex; flex-direction: column; align-items: flex-start; gap: 13px; }
.footer-links strong { margin-bottom: 5px; color: #315340; font-size: 14px; }

.footer-links a {
    color: #87948c;
    font-size: 13px;
    transition: color .2s;
}

.footer-links a:hover { color: #0b9660; }

.footer-bottom {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    padding-top: 21px;
    border-top: 1px solid #e6eee8;
    color: #9ba89f;
    font-size: 12px;
}

/* TABLET */
@media (max-width: 1100px) {
    .navbar { padding-left: 5%; padding-right: 5%; }
    .hero { padding: 75px 5%; gap: 35px; grid-template-columns: 1fr 1fr; }
    .hero h1 { font-size: 46px; }
    .dashboard { padding: 15px; }
    .stat-card { padding: 9px; }
    .dash-bottom { grid-template-columns: 1fr; }
    .benefit-strip { padding-left: 5%; padding-right: 5%; }
    .problems, .features { padding-left: 5%; padding-right: 5%; }
    .cta { margin-left: 5%; margin-right: 5%; }
    .faq { padding-left: 5%; padding-right: 5%; gap: 45px; }
    .footer { padding-left: 5%; padding-right: 5%; }
}

@media (max-width: 850px) {
    .hero { grid-template-columns: 1fr; gap: 65px; padding-top: 70px; }
    .hero-content { max-width: 650px; }
    .hero h1 { max-width: 600px; font-size: 54px; }
    .visual-wrap { width: 100%; max-width: 650px; margin: 0 auto; }
    .benefit-strip { grid-template-columns: repeat(2, 1fr); row-gap: 25px; }
    .problem-grid, .feature-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
    .cta { padding: 50px 6%; }
    .cta-visual { width: 150px; }
    .faq { grid-template-columns: 1fr; gap: 35px; }
    .faq-intro h2 br { display: none; }
}

/* HP */
@media (max-width: 650px) {
    .navbar { height: 69px; padding: 0 5%; }
    .desktop-nav, .nav-actions { display: none; }
    .logo { font-size: 20px; }
    .logo-mark { width: 35px; height: 35px; }

    .mobile-menu-button {
        width: 38px;
        height: 38px;
        display: grid;
        place-items: center;
        border: 1px solid #e5eee7;
        background: #fff;
        color: #315340;
        border-radius: 9px;
    }

    .mobile-menu {
        position: absolute;
        display: flex;
        flex-direction: column;
        gap: 0;
        top: 68px;
        left: 0;
        right: 0;
        padding: 10px 5% 17px;
        background: #fff;
        border-bottom: 1px solid #e9efeb;
        box-shadow: 0 15px 25px rgba(30,70,45,.08);
    }

    .mobile-menu a {
        padding: 14px 5px;
        color: #315340;
        font-size: 14px;
        font-weight: 600;
        border-bottom: 1px solid #f0f3f1;
    }

    .mobile-menu .mobile-register {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 12px;
        padding: 13px;
        color: #fff;
        background: #087e50;
        border-radius: 8px;
        border: 0;
    }

    .hero { padding: 65px 5% 75px; gap: 50px; }
    .eyebrow { padding: 8px 11px; font-size: 10px; }
    .hero h1 { font-size: clamp(39px, 9vw, 49px); letter-spacing: -2.3px; }
    .hero-description { font-size: 14px; line-height: 1.9; }
    .hero-actions { gap: 10px; }
    .btn-large { min-height: 47px; padding: 0 15px; font-size: 13px; }
    .hero-trust { gap: 12px; font-size: 11px; }

    .dashboard { padding: 13px; border-radius: 13px; }
    .dash-header { padding-bottom: 14px; }
    .dash-profile { font-size: 10px; }
    .dash-welcome { padding: 17px 0 14px; }
    .dash-welcome h3 { font-size: 16px; }
    .dash-welcome p { font-size: 10px; }
    .stat-grid { gap: 6px; }
    .stat-card { padding: 9px 7px; }
    .stat-top { font-size: 9px; }
    .stat-icon { width: 24px; height: 24px; }
    .stat-icon svg { width: 14px; }
    .stat-card > strong { font-size: clamp(15px, 4vw, 20px); }
    .stat-card > small { font-size: 9px; line-height: 1.5; }
    .dash-bottom { grid-template-columns: 1fr; }
    .activity-card, .stock-card { padding: 12px; }

    .floating-card {
        position: relative;
        left: auto;
        bottom: auto;
        width: fit-content;
        margin: 13px auto 0;
    }

    .dash-footer { font-size: 9px; }

    .benefit-strip { padding: 24px 5%; gap: 20px 12px; }
    .benefit-item { justify-content: flex-start; gap: 9px; }
    .benefit-icon { width: 34px; height: 34px; }
    .benefit-item strong { font-size: 11px; }
    .benefit-item small { font-size: 10px; line-height: 1.5; }

    .problems, .features { padding: 75px 5%; }
    .section-heading { margin-bottom: 32px; }
    .section-heading h2 { font-size: 30px; letter-spacing: -1px; }
    .section-heading p { font-size: 13px; }
    .problem-grid, .feature-grid { grid-template-columns: 1fr; gap: 13px; }
    .problem-card, .feature-card { padding: 22px; }
    .problem-card h3, .feature-card h3 { font-size: 16px; }
    .problem-card p, .feature-card p { font-size: 13px; }
    .feature-card p { min-height: 0; }

    .cta {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        margin: 0 5% 75px;
        padding: 42px 23px;
        border-radius: 15px;
    }

    .cta h2 { font-size: 31px; letter-spacing: -1px; }
    .cta-content > p { font-size: 13px; }
    .cta-actions { width: 100%; flex-direction: column; }
    .cta-actions .btn { width: 100%; }
    .cta-visual { align-self: center; height: 150px; margin-top: 10px; }
    .cta-mini-card { right: -25px; font-size: 10px; }

    .faq { padding: 0 5% 75px; gap: 27px; }
    .faq-intro h2 { font-size: 32px; }
    .faq-intro p { font-size: 13px; }
    .faq-list details { padding: 17px 0; }
    .faq-list summary { font-size: 13px; }
    .faq-list details p { font-size: 12px; }

    .footer { padding: 40px 5% 20px; }
    .footer-main { grid-template-columns: 1fr 1fr; gap: 32px 20px; }
    .footer-brand { grid-column: 1 / -1; }
    .footer-brand p { font-size: 12px; }
    .footer-links strong { font-size: 13px; }
    .footer-links a { font-size: 12px; }
    .footer-bottom { flex-direction: column; gap: 9px; line-height: 1.6; font-size: 11px; }
}

/* HP KECIL */
@media (max-width: 380px) {
    .hero h1 { font-size: 34px; }
    .hero-actions { flex-direction: column; }
    .hero-actions .btn { width: 100%; }
    .hero-trust { flex-direction: column; gap: 10px; }
    .dash-profile > span:not(.online-dot) { display: none; }
    .dashboard { padding: 10px; }
    .stat-card { padding: 8px 5px; }
    .stat-card > strong { font-size: 14px; }
    .service-row { gap: 5px; }
    .status { font-size: 8px; padding: 4px 5px; }
    .cta h2 { font-size: 27px; }
    .section-heading h2 { font-size: 27px; }
}
</style>

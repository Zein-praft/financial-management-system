<!DOCTYPE html>
<html class="scroll-smooth" lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fintrack - Solusi Keuangan</title>

    <!-- Memuat Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Memuat Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Konfigurasi Tailwind Custom -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        },
                        dark: {
                            bg: '#0f172a',
                            surface: '#1e293b',
                            text: '#f1f5f9'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background-color: #334155;
        }

        body {
            transition: background-color 0s, color 0s;
        }

        /* Efek hover smooth */
        .transition-interactive {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-dark-bg dark:text-dark-text antialiased relative">

    <!-- HEADER / NAVBAR -->
    <header
        class="sticky top-0 z-40 w-full backdrop-blur flex-none transition-colors duration-500 lg:z-50 border-b border-gray-200 dark:border-slate-800 bg-white/75 dark:bg-dark-bg/75">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo (UPDATED: Solid Icon) -->
                <div class="flex items-center gap-2 cursor-pointer group">
                    <div
                        class="bg-gradient-to-br from-blue-400 to-indigo-600 text-white p-1.5 rounded-xl shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform">
                        <!-- Diubah jadi ph-fill biar solid -->
                        <i class="ph-fill ph-wallet text-xl"></i>
                    </div>
                    <span
                        class="text-xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-white dark:to-slate-200">Fintrack</span>
                </div>

                <!-- Navigasi Tengah (Desktop) -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#"
                        class="text-sm font-medium text-primary-600 dark:text-white border-b-2 border-primary-600 pb-1">Beranda</a>
                </nav>

                <!-- Aksi Kanan -->
                <div class="flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-slate-800 text-gray-500 dark:text-gray-400 transition-interactive">
                        <i id="theme-icon-dark" class="ph ph-moon text-xl hidden"></i>
                        <i id="theme-icon-light" class="ph ph-sun text-xl"></i>
                    </button>

                    <!-- TOMBOL LOGIN (FIXED: Route Login) -->
                    <a href="{{ route('login') }}"
                        class="hidden sm:flex items-center gap-2 group relative overflow-hidden bg-gradient-to-r from-blue-400 to-indigo-600 text-white text-sm font-semibold py-2 px-5 rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 active:scale-95 transition-all duration-300">
                        <span class="relative z-10">Login</span>
                        <div
                            class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/20">
                        </div>
                        <i class="ph ph-sign-in text-lg relative z-10"></i>
                    </a>

                    <!-- Mobile Menu Button -->
                    <button class="sm:hidden p-2 text-gray-600 dark:text-gray-300">
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="py-20 text-center px-4 relative overflow-hidden">
            <!-- Background decoration blur -->
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-400/10 rounded-full blur-3xl -z-10">
            </div>

            <h1
                class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 pb-2">
                Kelola Keuangan Anda dengan Mudah bersama Fintrack
            </h1>

            <!-- Tombol CTA Mulai Sekarang -->
            <div class="flex justify-center gap-4 mb-8">
                <a href="{{ route('login') }}"
                    class="group relative overflow-hidden bg-gradient-to-r from-blue-400 to-indigo-600 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-1 active:scale-95 transition-all duration-300 flex items-center gap-2">
                    <span class="relative z-10 text-base">Mulai Sekarang</span>
                    <i class="ph ph-rocket-launch text-lg relative z-10"></i>
                    <div
                        class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/20">
                    </div>
                </a>
            </div>

            <h2 class="text-3xl font-bold mb-4 text-slate-800 dark:text-white">Fitur Unggulan & Kegunaan</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Temukan bagaimana Fintrack membantu
                mengoptimalkan operasional bisnis Anda dengan desain modern dan analisis real-time.</p>
        </section>

        <!-- Portfolio / Showcase Grid -->
        <section class="container mx-auto px-4 pb-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Card 1: Monitoring Saldo -->
                <article
                    class="bg-white dark:bg-dark-surface rounded-[2rem] shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden hover:-translate-y-1 hover:shadow-2xl transition-interactive flex flex-col group">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=600"
                            alt="Dashboard"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <span
                            class="absolute top-4 right-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg shadow-blue-500/30 border border-white/20 backdrop-blur-sm">
                            Ringkasan Utama
                        </span>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold mb-3 text-slate-800 dark:text-white">Monitoring Saldo Real-time
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow">
                            Fitur ini menampilkan total pemasukan <strong class="text-blue-600">Rp 110.000</strong>,
                            total pengeluaran <strong class="text-red-500">Rp 165.000</strong>, dan saldo akhir <strong
                                class="text-slate-700 dark:text-slate-300">Rp -55.000</strong>. Memudahkan Anda
                            mengetahui posisi keuangan secara instan.
                        </p>
                        <div
                            class="bg-gray-50 dark:bg-slate-900 p-4 rounded-2xl border border-gray-100 dark:border-slate-700">
                            <h4
                                class="text-xs uppercase font-bold text-gray-500 dark:text-gray-500 mb-2 tracking-wider">
                                Kegunaan:</h4>
                            <ul class="list-disc list-inside space-y-1 text-xs text-gray-600 dark:text-gray-300">
                                <li>Mengetahui posisi keuangan secara instan.</li>
                                <li>Mendeteksi defisit atau kelebihan saldo dengan cepat.</li>
                            </ul>
                        </div>
                    </div>
                </article>

                <!-- Card 2: Riwayat Transaksi -->
                <article
                    class="bg-white dark:bg-dark-surface rounded-[2rem] shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden hover:-translate-y-1 hover:shadow-2xl transition-interactive flex flex-col group">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&q=80&w=600"
                            alt="Transaction"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <span
                            class="absolute top-4 right-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg shadow-cyan-500/30 border border-white/20 backdrop-blur-sm">
                            Transaction History
                        </span>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold mb-3 text-slate-800 dark:text-white">Riwayat Transaksi Detail</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow">
                            Sistem mencatat setiap alur keluar masuk uang dengan detail, mulai dari pengeluaran makan
                            seperti <strong>"Ayam Geprek" (-100)</strong> dan <strong>"Naspad Padang" (-50)</strong>,
                            hingga penerimaan <strong>"Gaji" (+50)</strong>.
                        </p>
                        <div
                            class="bg-gray-50 dark:bg-slate-900 p-4 rounded-2xl border border-gray-100 dark:border-slate-700">
                            <h4
                                class="text-xs uppercase font-bold text-gray-500 dark:text-gray-500 mb-2 tracking-wider">
                                Kegunaan:</h4>
                            <ul class="list-disc list-inside space-y-1 text-xs text-gray-600 dark:text-gray-300">
                                <li>Mencatat detail pengeluaran harian secara teliti.</li>
                                <li>Mengecek ulang kebiasaan belanja bulanan.</li>
                            </ul>
                        </div>
                    </div>
                </article>

                <!-- Card 3: Input Data -->
                <article
                    class="bg-white dark:bg-dark-surface rounded-[2rem] shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden hover:-translate-y-1 hover:shadow-2xl transition-interactive flex flex-col group">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=600"
                            alt="Input Data"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <span
                            class="absolute top-4 right-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg shadow-emerald-500/30 border border-white/20 backdrop-blur-sm">
                            Input Cepat
                        </span>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold mb-3 text-slate-800 dark:text-white">Formulir "Add Transaction"
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow">
                            Tombol dan formulir yang memudahkan Anda memasukkan data baru. Desain dibuat minimalis agar
                            pencatatan tidak memakan waktu lama.
                        </p>
                        <div
                            class="bg-gray-50 dark:bg-slate-900 p-4 rounded-2xl border border-gray-100 dark:border-slate-700">
                            <h4
                                class="text-xs uppercase font-bold text-gray-500 dark:text-gray-500 mb-2 tracking-wider">
                                Kegunaan:</h4>
                            <ul class="list-disc list-inside space-y-1 text-xs text-gray-600 dark:text-gray-300">
                                <li>Memasukkan data transaksi seketika.</li>
                                <li>Menghindari lupa mencatat pengeluaran kecil.</li>
                            </ul>
                        </div>
                    </div>
                </article>

                <!-- Card 4: Filter Tanggal -->
                <article
                    class="bg-white dark:bg-dark-surface rounded-[2rem] shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden hover:-translate-y-1 hover:shadow-2xl transition-interactive flex flex-col group">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?auto=format&fit=crop&q=80&w=600"
                            alt="Calendar Filter"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <span
                            class="absolute top-4 right-4 bg-gradient-to-r from-orange-400 to-amber-500 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg shadow-orange-500/30 border border-white/20 backdrop-blur-sm">Filter
                            & Cari</span>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold mb-3 text-slate-800 dark:text-white">Pencarian Spesifik</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow">
                            Dilengkapi kolom input Tanggal, Bulan, dan Tahun. Sangat berguna untuk melihat laporan
                            keuangan hanya pada periode waktu tertentu saja.
                        </p>
                        <div
                            class="bg-gray-50 dark:bg-slate-900 p-4 rounded-2xl border border-gray-100 dark:border-slate-700">
                            <h4
                                class="text-xs uppercase font-bold text-gray-500 dark:text-gray-500 mb-2 tracking-wider">
                                Kegunaan:</h4>
                            <ul class="list-disc list-inside space-y-1 text-xs text-gray-600 dark:text-gray-300">
                                <li>Membuat rekap laporan bulanan.</li>
                                <li>Melakukan audit berdasarkan periode waktu.</li>
                            </ul>
                        </div>
                    </div>
                </article>

                <!-- Card 5: Mode Gelap -->
                <article
                    class="bg-white dark:bg-dark-surface rounded-[2rem] shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden hover:-translate-y-1 hover:shadow-2xl transition-interactive flex flex-col group">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1507400492013-162706c8c05e?auto=format&fit=crop&q=80&w=600"
                            alt="Dark Mode"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <span
                            class="absolute top-4 right-4 bg-gradient-to-r from-violet-500 to-purple-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg shadow-purple-500/30 border border-white/20 backdrop-blur-sm">Tema
                            UI</span>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold mb-3 text-slate-800 dark:text-white">Mode Gelap (Dark Mode)</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow">
                            Fitur untuk mengubah antarmuka menjadi gelap. Sangat membantu mengurangi ketegangan mata
                            saat menggunakan aplikasi di malam hari.
                        </p>
                        <div
                            class="bg-gray-50 dark:bg-slate-900 p-4 rounded-2xl border border-gray-100 dark:border-slate-700">
                            <h4
                                class="text-xs uppercase font-bold text-gray-500 dark:text-gray-500 mb-2 tracking-wider">
                                Kegunaan:</h4>
                            <ul class="list-disc list-inside space-y-1 text-xs text-gray-600 dark:text-gray-300">
                                <li>Memberikan kenyamanan visual saat di malam hari.</li>
                                <li>Menampilkan tampilan antarmuka yang lebih modern.</li>
                            </ul>
                        </div>
                    </div>
                </article>

                <!-- Card 6: Responsive -->
                <article
                    class="bg-white dark:bg-dark-surface rounded-[2rem] shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden hover:-translate-y-1 hover:shadow-2xl transition-interactive flex flex-col group">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&q=80&w=600"
                            alt="Mobile Responsive"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <span
                            class="absolute top-4 right-4 bg-gradient-to-r from-teal-400 to-cyan-500 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg shadow-teal-500/30 border border-white/20 backdrop-blur-sm">Akses</span>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold mb-3 text-slate-800 dark:text-white">Akses Di Mana Saja</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow">
                            Tampilan aplikasi menyesuaikan secara otomatis baik dibuka lewat Laptop besar maupun
                            Smartphone kecil. Data tetap sinkron.
                        </p>
                        <div
                            class="bg-gray-50 dark:bg-slate-900 p-4 rounded-2xl border border-gray-100 dark:border-slate-700">
                            <h4
                                class="text-xs uppercase font-bold text-gray-500 dark:text-gray-500 mb-2 tracking-wider">
                                Kegunaan:</h4>
                            <ul class="list-disc list-inside space-y-1 text-xs text-gray-600 dark:text-gray-300">
                                <li>Mengakses aplikasi melalui perangkat mobile.</li>
                                <li>Memberikan fleksibilitas penggunaan di berbagai layar.</li>
                            </ul>
                        </div>
                    </div>
                </article>

            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --primary-600: #4f46e5;
            --primary-hover: #2563eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* ============ LIGHT MODE ============ */
        footer {
            background: #fff;
            border-top: 1px solid #e5e7eb;
            padding: 80px 0 32px;
            color: #6b7280;
            font-size: 14px;
            transition: background 0.3s, color 0.3s;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1.4fr;
            gap: 48px;
            padding-bottom: 48px;
            border-bottom: 1px solid #e5e7eb;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .brand-logo i {
            font-size: 24px;
            color: #4f46e5;
        }

        .brand-logo span {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .brand-desc {
            font-size: 13px;
            line-height: 1.7;
            color: #6b7280;
            max-width: 280px;
        }

        .col-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #111827;
            margin-bottom: 20px;
        }

        .link-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .link-list a {
            text-decoration: none;
            color: #6b7280;
            font-size: 13px;
            position: relative;
            padding-left: 0;
            transition: color 0.2s, padding-left 0.2s;
        }

        .link-list a::before {
            content: '→';
            position: absolute;
            left: -20px;
            opacity: 0;
            transition: opacity 0.2s, left 0.2s;
            color: #4f46e5;
        }

        .link-list a:hover {
            color: #4f46e5;
            padding-left: 6px;
        }

        .link-list a:hover::before {
            opacity: 1;
            left: -16px;
        }

        .contact-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-bottom: 28px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #6b7280;
        }

        .contact-item i {
            font-size: 18px;
            color: #4f46e5;
            width: 20px;
            text-align: center;
        }

        /* ===================== GITHUB TEAM SECTION ===================== */
        .github-section {
            margin-top: 40px;
            padding: 36px 40px;
            border-radius: 20px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
        }

        .github-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .github-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .github-header-left i {
            font-size: 20px;
            color: #111827;
        }

        .github-header-left span {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .github-repo-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .github-repo-link:hover {
            color: #2563eb;
        }

        .github-repo-link i {
            font-size: 14px;
        }

        .github-team {
            display: flex;
            gap: 20px;
        }

        .github-card {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px 20px;
            border-radius: 16px;
            background: #fff;
            border: 1px solid #e5e7eb;
            text-decoration: none;
            transition: box-shadow 0.25s, transform 0.2s, border-color 0.25s;
        }

        .github-card:hover {
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.15), 0 8px 10px -6px rgba(79, 70, 229, 0.1);
            border-color: #4f46e5;
            transform: translateY(-2px);
        }

        .github-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #e5e7eb;
            overflow: hidden;
            flex-shrink: 0;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .github-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .github-info {
            min-width: 0;
        }

        .github-name {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .github-role {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 2px;
        }

        .github-handle {
            font-size: 11px;
            color: #4f46e5;
            margin-top: 3px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .github-handle i {
            font-size: 11px;
        }

        .footer-bottom {
            padding-top: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-copy {
            font-size: 12px;
            color: #9ca3af;
        }

        .footer-socials {
            display: flex;
            gap: 10px;
        }

        .social-btn {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            text-decoration: none;
            font-size: 17px;
            transition: background 0.2s, color 0.2s, transform 0.15s, border-color 0.2s;
        }

        .social-btn:hover {
            background: #4f46e5;
            color: #fff;
            border-color: #4f46e5;
            transform: translateY(-2px);
        }

        /* ============ DARK MODE ============ */
        .dark footer {
            background: #1e1e2e;
            border-top-color: #313244;
            color: #a6adc8;
        }

        .dark .brand-logo span,
        .dark .col-title {
            color: #cdd6f4;
        }

        .dark .brand-desc,
        .dark .link-list a,
        .dark .contact-item {
            color: #a6adc8;
        }

        .dark .link-list a:hover {
            color: #fff;
        }

        .dark .github-section {
            background: #313244;
            border-color: #45475a;
        }

        .dark .github-header-left i,
        .dark .github-header-left span {
            color: #cdd6f4;
        }

        .dark .github-card {
            background: #1e1e2e;
            border-color: #45475a;
        }

        .dark .github-card:hover {
            border-color: #818cf8;
            box-shadow: 0 10px 25px -5px rgba(129, 140, 248, 0.2);
        }

        .dark .github-avatar {
            border-color: #313244;
        }

        .dark .github-name {
            color: #cdd6f4;
        }

        .dark .github-role {
            color: #585b70;
        }

        .dark .footer-copy {
            color: #585b70;
        }

        .dark .social-btn {
            background: #313244;
            border-color: #45475a;
            color: #a6adc8;
        }

        .dark .social-btn:hover {
            background: #818cf8;
            color: #fff;
            border-color: #818cf8;
        }

        @media (max-width: 900px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 36px;
            }

            .github-team {
                flex-direction: column;
            }
        }

        @media (max-width: 600px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .github-section {
                padding: 24px 20px;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }
        }
    </style>

    <footer>
        <div class="footer-container">
            <div class="footer-grid">
                <div>
                    <!-- Footer Brand Logo (UPDATED: Solid Icon) -->
                    <div class="brand-logo">
                        <i class="ph-fill ph-wallet"></i>
                        <span>Fintrack</span>
                    </div>
                    <p class="brand-desc">Aplikasi pencatatan keuangan modern yang membantu Anda menghemat waktu dan
                        menghindari kesalahan hitung manual.</p>
                </div>
                <div>
                    <h4 class="col-title">Produk</h4>
                    <ul class="link-list">
                        <li><a href="#">Fitur</a></li>
                        <li><a href="#">Harga</a></li>
                        <li><a href="#">Integrasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="col-title">Perusahaan</h4>
                    <ul class="link-list">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="col-title">Hubungi Kami</h4>
                    <ul class="contact-list">
                        <li class="contact-item"><i class="ph ph-envelope"></i> Praftan12@gmail.com</li>
                        <li class="contact-item"><i class="ph ph-whatsapp-logo"></i> +62 851 6373 0377 </li>
                        <li class="contact-item"><i class="ph ph-map-pin"></i> Kalimantan Timur, Indonesia </li>
                    </ul>
                </div>
            </div>

            <div class="github-section">
                <div class="github-header">
                    <div class="github-header-left">
                        <i class="ph ph-github-logo ph-fill"></i>
                        <span>Open Source · Contributors</span>
                    </div>
                    <a href="https://github.com/Zein-praft/financial-management-system" target="_blank"
                        class="github-repo-link">
                        <i class="ph ph-code"></i> Fintrack Repository <i class="ph ph-arrow-up-right"></i>
                    </a>
                </div>
                <div class="github-team">
                    <a href="https://github.com/Zein-praft" target="_blank" class="github-card">
                        <div class="github-avatar"><img src="https://github.com/Zein-praft.png" alt="Zein-praft">
                        </div>
                        <div class="github-info">
                            <div class="github-name">Zein-praft</div>
                            <div class="github-role">Front-end</div>
                            <div class="github-handle"><i class="ph ph-github-logo"></i> @Zein-praft</div>
                        </div>
                    </a>
                    <a href="https://github.com/Favianevn" target="_blank" class="github-card">
                        <div class="github-avatar"><img src="https://github.com/Favianevn.png" alt="Avatar"></div>
                        <div class="github-info">
                            <div class="github-name">Favianevn</div>
                            <div class="github-role">Back-end</div>
                            <div class="github-handle"><i class="ph ph-github-logo"></i> @Favianevn</div>
                        </div>
                    </a>
                    <a href="https://github.com/jordanbob" target="_blank" class="github-card">
                        <div class="github-avatar"><img src="https://github.com/jordanbob.png" alt="Avatar"></div>
                        <div class="github-info">
                            <div class="github-name">Jordan Bob</div>
                            <div class="github-role">UI/UX Designer</div>
                            <div class="github-handle"><i class="ph ph-github-logo"></i> @jordanbob</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <span class="footer-copy">&copy; 2026 Fintrack Inc. All rights reserved.</span>
                <div class="footer-socials">
                    <a href="#" class="social-btn"><i class="ph ph-instagram-logo"></i></a>
                    <a href="#" class="social-btn"><i class="ph ph-tiktok-logo"></i></a>
                    <a href="#" class="social-btn"><i class="ph ph-github-logo"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const iconLight = document.getElementById('theme-icon-light');
            const iconDark = document.getElementById('theme-icon-dark');
            const html = document.documentElement;

            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)) {
                html.classList.add('dark');
                iconLight.classList.add('hidden');
                iconDark.classList.remove('hidden');
            } else {
                html.classList.remove('dark');
                iconLight.classList.remove('hidden');
                iconDark.classList.add('hidden');
            }

            themeToggleBtn.addEventListener('click', () => {
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    localStorage.theme = 'light';
                    iconLight.classList.remove('hidden');
                    iconDark.classList.add('hidden');
                } else {
                    html.classList.add('dark');
                    localStorage.theme = 'dark';
                    iconLight.classList.add('hidden');
                    iconDark.classList.remove('hidden');
                }
            });
        });
    </script>
</body>

</html>

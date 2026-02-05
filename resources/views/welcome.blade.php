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

    <!-- CSS Khusus untuk Scrollbar & Transisi (Sedikit yang diperlukan) -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
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

    <!-- FOOTER (DIUBAH MENJADI TAILWIND CLASS) -->
    <footer class="bg-white dark:bg-dark-surface border-t border-gray-200 dark:border-slate-800 pt-20 pb-8 text-gray-600 dark:text-gray-400 transition-colors duration-300 text-sm">
        <div class="container mx-auto px-6 max-w-7xl">
            
            <!-- Footer Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-12 border-b border-gray-200 dark:border-slate-800">
                
                <!-- Brand Column -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <i class="ph-fill ph-wallet text-2xl text-primary-600"></i>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">Fintrack</span>
                    </div>
                    <p class="text-xs leading-relaxed max-w-[280px]">
                        Aplikasi pencatatan keuangan modern yang membantu Anda menghemat waktu dan menghindari kesalahan hitung manual.
                    </p>
                </div>

                <!-- Product Column -->
                <div>
                    <h4 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-5">Produk</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Fitur</a></li>
                        <li><a href="#" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Harga</a></li>
                        <li><a href="#" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Integrasi</a></li>
                    </ul>
                </div>

                <!-- Company Column -->
                <div>
                    <h4 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-5">Perusahaan</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Karir</a></li>
                        <li><a href="#" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Contact Column -->
                <div>
                    <h4 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-5">Hubungi Kami</h4>
                    <ul class="space-y-3.5">
                        <li class="flex items-center gap-2.5">
                            <i class="ph ph-envelope text-lg text-primary-600"></i>
                            <span>Praftan12@gmail.com</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="ph ph-whatsapp-logo text-lg text-primary-600"></i>
                            <span>+62 851 6373 0377</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="ph ph-map-pin text-lg text-primary-600"></i>
                            <span>Kalimantan Timur, Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Github Section -->
            <div class="mt-10 p-6 md:p-10 rounded-[1.5rem] bg-gray-100 dark:bg-dark-bg border border-gray-200 dark:border-slate-700">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-7 gap-4">
                    <div class="flex items-center gap-2.5">
                        <i class="ph ph-github-logo ph-fill text-2xl text-gray-900 dark:text-white"></i>
                        <span class="font-semibold text-gray-900 dark:text-white uppercase tracking-wide text-xs">Open Source · Contributors</span>
                    </div>
                    <a href="https://github.com/Zein-praft/financial-management-system" target="_blank" class="inline-flex items-center gap-2 text-xs font-medium text-primary-600 hover:text-primary-500 transition-colors">
                        <i class="ph ph-code"></i> Fintrack Repository <i class="ph ph-arrow-up-right"></i>
                    </a>
                </div>

                <div class="flex flex-col md:flex-row gap-5">
                    <!-- Card 1 -->
                    <a href="https://github.com/Zein-praft" target="_blank" class="flex-1 group flex items-center gap-3.5 p-5 rounded-2xl bg-white dark:bg-dark-surface border border-gray-200 dark:border-slate-700 hover:shadow-lg hover:-translate-y-0.5 hover:border-primary-500/50 dark:hover:border-primary-500/50 transition-all duration-300">
                        <div class="w-11 h-11 rounded-full overflow-hidden bg-gray-200 border-2 border-white dark:border-slate-700 shadow-sm flex-shrink-0">
                            <img src="https://github.com/Zein-praft.png" alt="Zein-praft" class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">Zein-praft</div>
                            <div class="text-xs text-gray-500 dark:text-gray-500 mt-0.5">Front-end</div>
                            <div class="flex items-center gap-1 text-[10px] text-primary-600 mt-1">
                                <i class="ph ph-github-logo"></i> @Zein-praft
                            </div>
                        </div>
                    </a>

                    <!-- Card 2 -->
                    <a href="https://github.com/Favianevn" target="_blank" class="flex-1 group flex items-center gap-3.5 p-5 rounded-2xl bg-white dark:bg-dark-surface border border-gray-200 dark:border-slate-700 hover:shadow-lg hover:-translate-y-0.5 hover:border-primary-500/50 dark:hover:border-primary-500/50 transition-all duration-300">
                        <div class="w-11 h-11 rounded-full overflow-hidden bg-gray-200 border-2 border-white dark:border-slate-700 shadow-sm flex-shrink-0">
                            <img src="https://github.com/Favianevn.png" alt="Avatar" class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">Favianevn</div>
                            <div class="text-xs text-gray-500 dark:text-gray-500 mt-0.5">Back-end</div>
                            <div class="flex items-center gap-1 text-[10px] text-primary-600 mt-1">
                                <i class="ph ph-github-logo"></i> @Favianevn
                            </div>
                        </div>
                    </a>

                    <!-- Card 3 -->
                    <a href="https://github.com/nwisnuyasa4-afk" target="_blank" class="flex-1 group flex items-center gap-3.5 p-5 rounded-2xl bg-white dark:bg-dark-surface border border-gray-200 dark:border-slate-700 hover:shadow-lg hover:-translate-y-0.5 hover:border-primary-500/50 dark:hover:border-primary-500/50 transition-all duration-300">
                        <div class="w-11 h-11 rounded-full overflow-hidden bg-gray-200 border-2 border-white dark:border-slate-700 shadow-sm flex-shrink-0">
                            <img src="https://github.com/nwisnuyasa4-afk.png" alt="Avatar" class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">Nazril</div>
                            <div class="text-xs text-gray-500 dark:text-gray-500 mt-0.5">QA (Quality Assurance)</div>
                            <div class="flex items-center gap-1 text-[10px] text-primary-600 mt-1">
                                <i class="ph ph-github-logo"></i> @nwisnuyasa4-afk
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <span class="text-xs text-gray-500 dark:text-gray-500">&copy; 2026 Fintrack Inc. All rights reserved.</span>
                <div class="flex gap-2.5">
                    <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 bg-gray-100 dark:bg-dark-bg dark:text-gray-400 border border-transparent dark:border-slate-700 hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-all duration-300">
                        <i class="ph ph-instagram-logo text-lg"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 bg-gray-100 dark:bg-dark-bg dark:text-gray-400 border border-transparent dark:border-slate-700 hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-all duration-300">
                        <i class="ph ph-tiktok-logo text-lg"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 bg-gray-100 dark:bg-dark-bg dark:text-gray-400 border border-transparent dark:border-slate-700 hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-all duration-300">
                        <i class="ph ph-github-logo text-lg"></i>
                    </a>
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
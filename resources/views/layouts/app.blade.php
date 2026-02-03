<!DOCTYPE html>
<html lang="id" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FinTrack')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6', // Warna utama
                        primaryDark: '#2563EB',
                        success: '#10B981',
                        danger: '#F87171',
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>

    <!-- Chart.js & FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- TAMBAHAN: Phosphor Icons Script (Buat Logo Dompet) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        /* Icon berubah warna pas input di-focus */
        input:focus~.input-icon {
            color: #6366F1;
        }
    </style>

    @livewireStyles
    @stack('styles')
</head>

<body
    class="bg-slate-50 text-slate-700 antialiased min-h-screen flex flex-col dark:bg-slate-900 dark:text-slate-200 transition-colors duration-300">

    <!-- NAVBAR (UPGRADED STYLE) -->
    <nav
        class="sticky top-0 z-50 w-full bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-100 dark:border-white/5 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <!-- LOGO BRAND (UPDATED: DOMPET ICON) -->
                <div class="flex items-center gap-3">
                    <!-- Kotak Gradient Biru (Sama kayak Login) -->
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                        <!-- Icon Dompet dari Phosphor Icons -->
                        <i class="ph-fill ph-wallet text-xl"></i>
                    </div>
                    <div class="leading-tight">
                        <h1 class="text-lg font-bold tracking-tight dark:text-white">Fin<span
                                class="text-blue-500">Track</span></h1>
                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wide">Financial Intelligence
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4 sm:gap-6">

                    <!-- TANGGAL -->
                    <div class="hidden md:block text-right">
                        <div class="text-xs text-slate-500 dark:text-slate-400 uppercase font-semibold tracking-wider">
                            Welcome back</div>
                        <div
                            class="text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center justify-end gap-2">
                            <span>{{ now()->format('l, F j') }}</span>
                        </div>
                    </div>

                    <!-- Dark Mode Toggle (ROUNDED BOX) -->
                    <button onclick="toggleDarkMode()"
                        class="w-10 h-10 rounded-2xl flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors border border-transparent hover:border-slate-200 dark:hover:border-slate-700 shadow-sm">
                        <i class="fa-solid fa-sun text-yellow-400 text-lg hidden dark:block"></i>
                        <i class="fa-solid fa-moon text-indigo-600 text-lg block dark:hidden"></i>
                    </button>

                    <!-- Profile & Logout -->
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                    {{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500">Premium User</p>
                            </div>
                            <div
                                class="h-10 w-10 rounded-2xl bg-slate-100 border-2 border-white dark:bg-slate-800 dark:border-slate-700 shadow-sm flex items-center justify-center text-slate-500 dark:text-slate-300 group-hover:border-blue-500 dark:group-hover:border-blue-400 group-hover:text-blue-500 transition-all">
                                <i class="fa-solid fa-user text-lg"></i>
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400 dark:text-slate-500 group-hover:text-blue-500 transition-transform duration-300"
                                id="dropdownChevron"></i>
                        </button>

                        <!-- DROPDOWN MENU (UPGRADED) -->
                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-3 w-56 bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-slate-100 dark:border-white/5 py-2 z-50 origin-top-right transition-all duration-200">
                            <div class="px-4 py-3 border-b border-slate-50 dark:border-slate-700 mb-1">
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100">Pengaturan Akun</p>
                                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors rounded-xl mx-2">
                                <div
                                    class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400">
                                    <i class="fa-solid fa-gear"></i>
                                </div>
                                <span class="font-medium">Settings</span>
                            </a>
                            <div class="h-px bg-slate-100 dark:bg-slate-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors rounded-xl mx-2">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-900/30 flex items-center justify-center text-red-500 dark:text-red-400">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    </div>
                                    <span class="font-medium">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- GLOBAL TOAST NOTIFICATION SYSTEM (INSERTED HERE) -->
    <div x-data="{
        toasts: [],
        addToast(message, type = 'info') {
            const id = Date.now();
            this.toasts.push({ id, message, type });
            setTimeout(() => this.removeToast(id), 5000); // Hilang otomatis 5 detik
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }" @toast-add.window="addToast($event.detail.message, $event.detail.type)"
        class="fixed top-4 right-4 z-[100] flex flex-col gap-3 pointer-events-none">

        <!-- Loop Notif -->
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="true" x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="pointer-events-auto w-80 bg-white dark:bg-slate-900 shadow-2xl rounded-2xl border border-slate-100 dark:border-slate-700 p-4 flex items-start gap-3 relative overflow-hidden group">

                <!-- Warna Kiri -->
                <div :class="toast.type === 'danger' ? 'bg-red-500' : 'bg-blue-500'"
                    class="absolute top-0 left-0 w-1 h-full"></div>

                <!-- Icon -->
                <div :class="toast.type === 'danger' ? 'bg-red-100 dark:bg-red-900/30 text-red-500' :
                    'bg-blue-100 dark:bg-blue-900/30 text-blue-500'"
                    class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i :class="toast.type === 'danger' ? 'fa-solid fa-triangle-exclamation' : 'fa-solid fa-bell'"></i>
                </div>

                <!-- Content -->
                <div class="flex-1 pr-4">
                    <h4 class="text-sm font-bold text-slate-800 dark:text-white leading-tight" x-text="toast.message">
                    </h4>
                    <p class="text-xs text-slate-400 mt-1">Bill Reminder</p>
                </div>

                <!-- Close Button -->
                <button @click="removeToast(toast.id)"
                    class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </template>
    </div>

    <!-- TEMPAT KONTEN DINAMIS -->
    {{ $slot }}

    <script>
        // --- DARK MODE GLOBAL ---
        function initDarkMode() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
            // Trigger event buat chart
            window.dispatchEvent(new Event('darkModeChanged'));
        }
        initDarkMode();

        // --- DROPDOWN GLOBAL ---
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            const chevron = document.getElementById('dropdownChevron');
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                chevron.classList.add('rotate-180');
                dropdown.style.opacity = '0';
                dropdown.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    dropdown.style.opacity = '1';
                    dropdown.style.transform = 'translateY(0) scale(1)';
                }, 10);
            } else {
                dropdown.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            }
        }
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('profileDropdown');
            const isClickInside = dropdown.contains(e.target) || e.target.closest(
                'button[onclick="toggleDropdown()"]');
            if (!isClickInside && !dropdown.classList.contains('hidden')) {
                toggleDropdown();
            }
        });

        // --- Emit event untuk Livewire saat dark mode berubah ---
        window.addEventListener('darkModeChanged', () => {
            window.dispatchEvent(new CustomEvent('toggle-theme'));
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>

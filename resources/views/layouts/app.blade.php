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
                        primary: '#3B82F6',
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
        input:focus ~ .input-icon { color: #6366F1; }
    </style>
    
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-700 antialiased min-h-screen flex flex-col dark:bg-slate-900 dark:text-slate-200">

<body
    class="bg-slate-50 text-slate-700 antialiased min-h-screen flex flex-col dark:bg-slate-900 dark:text-slate-200 transition-colors duration-300">

    <!-- NAVBAR -->
    <nav
        class="sticky top-0 z-50 w-full bg-white/90 dark:bg-slate-800/90 backdrop-blur border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white">
                        <i class="fa-solid fa-bolt text-lg"></i>
                    </div>
                    <div class="leading-tight">
                        <h1 class="text-lg font-bold tracking-tight dark:text-white">Fin<span
                                class="text-primary">Track</span></h1>
                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wide">Financial Intelligence
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4 sm:gap-6">
                    <div class="hidden md:block text-right">
                        <div class="text-xs text-slate-500 dark:text-slate-400 uppercase font-semibold tracking-wider">
                            Welcome back</div>
                        <div
                            class="text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center justify-end gap-2">
                            <span>{{ now()->format('l, F j') }}</span>
                        </div>
                    </div>

                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()"
                        class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors relative z-10">
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
                                class="h-10 w-10 rounded-full bg-slate-100 border-2 border-white dark:bg-slate-700 dark:border-slate-600 shadow-sm flex items-center justify-center text-slate-500 dark:text-slate-300 group-hover:border-primary group-hover:text-primary transition-all">
                                <i class="fa-solid fa-user text-lg"></i>
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400 dark:text-slate-500 group-hover:text-primary transition-transform duration-300"
                                id="dropdownChevron"></i>
                        </button>

                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-3 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 py-2 z-50">
                            <div class="px-4 py-3 border-b border-slate-50 dark:border-slate-700 mb-1">
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100">Pengaturan Akun</p>
                                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
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

    <!-- TEMPAT KONTEN DINAMIS -->
    {{ $slot }}
    <!-- ATAU @yield('content') kalau bukan full-page component -->

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
            } else {
                dropdown.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            }
        }
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('profileDropdown');
            if (!dropdown.contains(e.target) && !e.target.closest('button')) {
                if (!dropdown.classList.contains('hidden')) toggleDropdown();
            }
        });
    </script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>

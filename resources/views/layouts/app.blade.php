<!DOCTYPE html>
<html lang="id" class="light"> <!-- Default Class Light -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack Pro</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js & FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#6366F1', 
                        primaryDark: '#4338CA',
                        secondary: '#64748B', 
                        success: '#10B981', 
                        danger: '#EF4444', 
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'glow': '0 0 15px rgba(99, 102, 241, 0.15)',
                        'dropdown': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>

    <style>
        body, div, nav, main, input, select { transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .dark .glass-card {
            background: rgba(30, 41, 59, 0.9); 
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        input:focus ~ .input-icon { color: #6366F1; }
    </style>
    
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-700 antialiased min-h-screen flex flex-col dark:bg-slate-900 dark:text-slate-200">

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 w-full glass-card border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-glow">
                        <i class="fa-solid fa-bolt text-lg"></i>
                    </div>
                    <div class="leading-tight">
                        <h1 class="text-lg font-bold tracking-tight dark:text-white">FinTrack<span class="text-primary">.Pro</span></h1>
                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wide">Financial Intelligence</p>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-4 sm:gap-6">
                    <!-- Date -->
                    <div class="hidden md:block text-right">
                        <div class="text-xs text-slate-500 dark:text-slate-400 uppercase font-semibold tracking-wider">Welcome back</div>
                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center justify-end gap-2">
                            <i class="fa-regular fa-calendar text-primary"></i>
                            <span id="currentDateText">Loading...</span>
                        </div>
                    </div>

                    <!-- Dark Mode Toggle (FIXED) -->
                    <button onclick="toggleDarkMode()" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors relative z-10">
                        <!-- Sun Icon (Only shows in Dark Mode) -->
                        <i class="fa-solid fa-sun text-yellow-400 text-lg hidden dark:block"></i>
                        <!-- Moon Icon (Shows in Light Mode) -->
                        <i class="fa-solid fa-moon text-indigo-600 text-lg block dark:hidden"></i>
                    </button>

                    <!-- Profile & Logout -->
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500">Premium User</p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-slate-100 border-2 border-white dark:bg-slate-700 dark:border-slate-600 shadow-sm flex items-center justify-center text-slate-500 dark:text-slate-300 group-hover:border-primary group-hover:text-primary transition-all">
                                <i class="fa-solid fa-user text-lg"></i>
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400 dark:text-slate-500 group-hover:text-primary transition-transform duration-300" id="dropdownChevron"></i>
                        </button>

                        <!-- Dropdown -->
                        <div id="profileDropdown" class="hidden absolute right-0 mt-3 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-dropdown border border-slate-100 dark:border-slate-700 py-2 origin-top-right transition-all duration-200 z-50">
                            <div class="px-4 py-3 border-b border-slate-50 dark:border-slate-700 mb-1">
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100">Pengaturan Akun</p>
                                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400"><i class="fa-solid fa-gear"></i></div>
                                <span class="font-medium">Profile Settings</span>
                            </a>
                            <div class="h-px bg-slate-100 dark:bg-slate-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-900/30 flex items-center justify-center text-red-500 dark:text-red-400"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                                    <span class="font-medium">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Slot -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <script>
        // Dark Mode Logic
        function initDarkMode() {
            // Cek localStorage atau sistem preference
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        function toggleDarkMode() {
            // Toggle class dark
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
        
        // Dropdown Logic
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            const chevron = document.getElementById('dropdownChevron');
            const isHidden = dropdown.classList.contains('hidden');
            if (isHidden) {
                dropdown.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            } else {
                dropdown.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            }
        }

        // Date Logic
        const dateOptions = { weekday: 'long', month: 'long', day: 'numeric' };
        document.getElementById('currentDateText').textContent = new Date().toLocaleDateString('en-US', dateOptions);

        // Jalankan saat load
        initDarkMode();

        // Close dropdown on outside click
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('profileDropdown');
            if (!dropdown.contains(e.target) && !e.target.closest('button')) {
                if(!dropdown.classList.contains('hidden')) toggleDropdown();
            }
        });
    </script>
    
    @livewireScripts
</body>
</html>
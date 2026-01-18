<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Management System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js & FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body,
        div,
        nav,
        main,
        input,
        select {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
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

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        input:focus~.input-icon {
            color: #6366F1;
        }
    </style>

    @livewireStyles
</head>

<!-- BODY (Glow Biru Halus & Tanpa Dark Mode) -->

<body
    class="bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-500/10 via-white to-white text-slate-700 antialiased min-h-screen flex flex-col">

    <!-- NAVBAR (WARNA BIRU SEGAR) -->
    <nav class="sticky top-0 z-50 w-full bg-blue-500 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <!-- Logo box diubah putih biar kontras dengan bg biru -->
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-500 shadow-lg">
                        <i class="fa-solid fa-bolt text-lg"></i>
                    </div>
                    <div class="leading-tight">
                        <!-- Teks diubah putih -->
                        <h1 class="text-lg font-bold tracking-tight text-white">Financial Management System <span></h1>
                        <p class="text-[10px] text-blue-100 font-medium uppercase tracking-wide">Financial Intelligence
                        </p>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-4 sm:gap-6">
                    <!-- Date -->
                    <div class="hidden md:block text-right">
                        <div class="text-xs text-blue-100 uppercase font-semibold tracking-wider">Welcome back</div>
                        <div class="text-sm font-bold text-white flex items-center justify-end gap-2">
                            <i class="fa-regular fa-calendar text-white"></i>
                            <span id="currentDateText">Loading...</span>
                        </div>
                    </div>

                    <!-- Tombol Dark Mode DIHAPUS -->

                    <!-- Profile & Logout (Only show if authenticated) -->
                    @auth
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="flex items-center gap-3 focus:outline-none group">
                                <div class="text-right hidden sm:block">
                                    <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-blue-100">Premium User</p>
                                </div>
                                <!-- Avatar bg transparan putih -->
                                <div
                                    class="h-10 w-10 rounded-full bg-white/20 border-2 border-white/30 text-white flex items-center justify-center group-hover:bg-white/30 group-hover:border-white transition-all">
                                    <i class="fa-solid fa-user text-lg"></i>
                                </div>
                                <i class="fa-solid fa-chevron-down text-xs text-white group-hover:text-blue-100 transition-transform duration-300"
                                    id="dropdownChevron"></i>
                            </button>

                            <!-- Dropdown (Masih putih biar menu bacaan jelas) -->
                            <div id="profileDropdown"
                                class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-dropdown border border-slate-100 py-2 origin-top-right transition-all duration-200 z-50">
                                <div class="px-4 py-3 border-b border-slate-50 mb-1">
                                    <p class="text-sm font-bold text-slate-800">Pengaturan Akun</p>
                                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                        <i class="fa-solid fa-gear"></i>
                                    </div>
                                    <span class="font-medium">Profile Settings</span>
                                </a>
                                <div class="h-px bg-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-500">
                                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        </div>
                                        <span class="font-medium">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Slot -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <script>
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
        const dateOptions = {
            weekday: 'long',
            month: 'long',
            day: 'numeric'
        };
        const dateEl = document.getElementById('currentDateText');
        if (dateEl) dateEl.textContent = new Date().toLocaleDateString('en-US', dateOptions);

        // Close dropdown on outside click
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown && !dropdown.contains(e.target) && !e.target.closest('button')) {
                if (!dropdown.classList.contains('hidden')) toggleDropdown();
            }
        });
    </script>

    @livewireScripts
</body>

</html>

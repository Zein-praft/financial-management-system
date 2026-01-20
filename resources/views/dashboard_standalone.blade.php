<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FinTrack.Pro</title>
    
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
    </style>
    
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-700 antialiased min-h-screen flex flex-col dark:bg-slate-900 dark:text-slate-200 transition-colors duration-300">

    {{-- LOGIKA PHP (HARUS ADA DI ATAS HTML) --}}
    @php
        use App\Models\Transaction;

        // Cek User Login
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // 1. Ambil Parameter Filter
        $period = request()->input('chartPeriod', 'month');

        // 2. Query Dasar (FILTER BY USER ID AGAR DATA AMAN)
        $query = Transaction::where('user_id', \Illuminate\Support\Facades\Auth::id());
        
        // 3. Logic Filter Waktu
        if ($period == 'today') {
            $query->whereDate('date', \Carbon\Carbon::today());
        } elseif ($period == 'last_month') {
            $query->whereMonth('date', \Carbon\Carbon::now()->subMonth()->month)
                   ->whereYear('date', \Carbon\Carbon::now()->subMonth()->year);
        } elseif ($period == 'year') {
            $query->whereYear('date', \Carbon\Carbon::now()->year);
        } else {
            // Default Month
            $query->whereMonth('date', \Carbon\Carbon::now()->month)
                   ->whereYear('date', \Carbon\Carbon::now()->year);
        }

        $transactions = $query->orderBy('date', 'asc')->get();

        // 4. Grouping untuk Chart
        $grouped = $transactions->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
        });

        $labels = [];
        $incomeData = [];
        $expenseData = [];

        foreach ($grouped as $date => $items) {
            $labels[] = \Carbon\Carbon::parse($date)->format('M d');
            $incomeData[] = $items->where('type', 'income')->sum('amount');
            $expenseData[] = $items->where('type', 'expense')->sum('amount');
        }

        // 5. Hitung Statistik Total (ALL TIME)
        $statsQuery = Transaction::where('user_id', \Illuminate\Support\Facades\Auth::id());
        
        $totalIncome = $statsQuery->where('type', 'income')->sum('amount');
        $totalExpense = $statsQuery->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
    @endphp

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 w-full bg-white/90 dark:bg-slate-800/90 backdrop-blur border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white">
                        <i class="fa-solid fa-bolt text-lg"></i>
                    </div>
                    <div class="leading-tight">
                        <h1 class="text-lg font-bold tracking-tight dark:text-white">FinTrack<span class="text-primary">.Pro</span></h1>
                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wide">Financial Intelligence</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 sm:gap-6">
                    <div class="hidden md:block text-right">
                        <div class="text-xs text-slate-500 dark:text-slate-400 uppercase font-semibold tracking-wider">Welcome back</div>
                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center justify-end gap-2">
                            <span id="currentDateText">{{ now()->format('l, F j') }}</span>
                        </div>
                    </div>

                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors relative z-10">
                        <i class="fa-solid fa-sun text-yellow-400 text-lg hidden dark:block"></i>
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

                        <div id="profileDropdown" class="hidden absolute right-0 mt-3 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 py-2 z-50">
                            <div class="px-4 py-3 border-b border-slate-50 dark:border-slate-700 mb-1">
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100">Pengaturan Akun</p>
                                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
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

    <!-- MAIN CONTENT -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- ROW 1: CARDS SUMMARY -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- INCOME CARD -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/20 rounded-bl-full -mr-4 -mt-4 group-hover:scale-110 transition"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                            <i class="fa-solid fa-arrow-down"></i>
                        </div>
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Income</span>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white">
                        Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <!-- EXPENSE CARD -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 dark:bg-red-900/20 rounded-bl-full -mr-4 -mt-4 group-hover:scale-110 transition"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-400 flex items-center justify-center">
                            <i class="fa-solid fa-arrow-up"></i>
                        </div>
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Expense</span>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white">
                        Rp {{ number_format($totalExpense ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <!-- BALANCE CARD -->
            <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="absolute right-0 bottom-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-10 -mb-10"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2 opacity-90">
                        <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <span class="text-sm font-medium">Current Balance</span>
                    </div>
                    <h3 class="text-3xl font-bold">
                        Rp {{ number_format($balance ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- LEFT: CHART & LIST -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- CHART -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Cash Flow Overview</h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500">Statistics of your income and expense</p>
                        </div>
                        
                        <!-- FILTER SELECT -->
                        <div class="relative w-full sm:w-auto">
                            <select onchange="window.location.href='/dashboard?chartPeriod='+this.value"
                                class="w-full sm:w-48 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 appearance-none cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-600 transition">
                                <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Hari Ini (Today)</option>
                                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Bulan Ini (This Month)</option>
                                <option value="last_month" {{ $period == 'last_month' ? 'selected' : '' }}>Bulan Lalu (Last Month)</option>
                                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Tahun Ini (This Year)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500 dark:text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="relative w-full h-[400px]">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>

                <!-- TRANSACTION LIST (Livewire) -->
                <livewire:transaction-list />
            </div>

            <!-- RIGHT: FORM -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <livewire:transaction-form />
                </div>
            </div>
        </div>
    </main>

    <script>
        // --- DARK MODE ---
        function initDarkMode() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
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
            updateChartColors(); // Update chart warna grid
        }
        initDarkMode();

        // --- DROPDOWN ---
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
                if(!dropdown.classList.contains('hidden')) toggleDropdown();
            }
        });

        // --- CHART ---
        let chartInstance = null;
        function updateChartColors() {
            if (!chartInstance) return;
            const isDark = document.documentElement.classList.contains('dark');
            chartInstance.options.scales.y.grid.color = isDark ? '#334155' : '#f1f5f9';
            chartInstance.options.scales.y.ticks.color = isDark ? '#94a3b8' : '#64748b';
            chartInstance.options.scales.x.ticks.color = isDark ? '#94a3b8' : '#64748b';
            chartInstance.update();
        }

        function initChart() {
            const ctx = document.getElementById('financeChart').getContext('2d');
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? '#334155' : '#f1f5f9'; 
            const tickColor = isDark ? '#94a3b8' : '#64748b';

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [
                        {
                            label: 'Income',
                            data: {!! json_encode($incomeData) !!},
                            backgroundColor: '#3B82F6',
                            borderRadius: 6,
                            barPercentage: 0.6
                        },
                        {
                            label: 'Expense',
                            data: {!! json_encode($expenseData) !!},
                            backgroundColor: '#F87171',
                            borderRadius: 6,
                            barPercentage: 0.6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                font: { family: "'Plus Jakarta Sans', sans-serif" },
                                color: tickColor
                            }
                        },
                        tooltip: {
                            backgroundColor: isDark ? 'rgba(15, 23, 42, 0.9)' : 'rgba(255, 255, 255, 0.9)',
                            titleColor: isDark ? '#fff' : '#1e293b',
                            bodyColor: isDark ? '#cbd5e1' : '#64748b',
                            borderColor: isDark ? '#334155' : '#e2e8f0',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor, borderDash: [5, 5] },
                            ticks: { color: tickColor }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: tickColor }
                        }
                    }
                }
            });
        }
        initChart();
    </script>

    @livewireScripts
</body>
</html>
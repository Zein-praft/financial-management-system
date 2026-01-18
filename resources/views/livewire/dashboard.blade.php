<div>
    <!-- ROW 1: CARDS SUMMARY -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- INCOME -->
        <div
            class="bg-white p-6 rounded-2xl shadow-blue-500/20 shadow-lg border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div
                class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 group-hover:scale-110 transition">
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-arrow-down"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-500">Total Income</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">
                    Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                </h3>
            </div>
        </div>

        <!-- EXPENSE -->
        <div
            class="bg-white p-6 rounded-2xl shadow-blue-500/20 shadow-lg border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
            <div
                class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 group-hover:scale-110 transition">
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                        <i class="fa-solid fa-arrow-up"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-500">Total Expense</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">
                    Rp {{ number_format($totalExpense ?? 0, 0, ',', '.') }}
                </h3>
            </div>
        </div>

        <!-- BALANCE -->
        <div
            class="bg-gradient-to-br from-blue-400 to-blue-600 p-6 rounded-2xl shadow-blue-500/30 shadow-lg text-white relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
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

    <!-- ROW 2: CHART (FULL WIDTH) -->
    <div class="bg-white rounded-2xl shadow-blue-500/20 shadow-lg border border-slate-100 p-6 mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">

            <!-- Judul -->
            <div>
                <h3 class="text-lg font-bold text-slate-800">Cash Flow Overview</h3>
                <p class="text-xs text-slate-400">Statistics of your income and expense</p>
            </div>

            <!-- FILTER -->
            <div class="relative w-full sm:w-auto">
                <select wire:model.live="chartPeriod"
                    class="w-full sm:w-48 bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 appearance-none cursor-pointer hover:bg-slate-100 transition">
                    <option value="today">Hari Ini (Today)</option>
                    <option value="month">Bulan Ini (This Month)</option>
                    <option value="last_month">Bulan Lalu (Last Month)</option>
                    <option value="year">Tahun Ini (This Year)</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </div>
        </div>

        <!-- CANVAS CHART (TINGGI 400px) -->
        <div class="relative w-full h-[400px]">
            <canvas id="financeChart"></canvas>
        </div>
    </div>


    <!-- SCRIPT CHART (FIXED TIMING) -->
    <script>
        let chartInstance = null;

        // 1. PERTAMA KALI: Tunggu Livewire siap dulu, baru gambar
        document.addEventListener('livewire:init', function() {
            setTimeout(function() {
                updateChart();
            }, 300); // Delay 300ms biar layout canvas selesai render
        });

        // 2. PAS ADA UPDATE: Langsung gambar ulang
        document.addEventListener('livewire:updated', function() {
            updateChart();
        });

        function updateChart() {
            // Pastikan canvas ada dulu sebelum ngambil context
            const canvas = document.getElementById('financeChart');
            if (!canvas) return;

            const labels = @js($chartLabels ?? []);
            const incomeData = @js($incomeData ?? []);
            const expenseData = @js($expenseData ?? []);

            const ctx = canvas.getContext('2d');

            if (chartInstance) {
                chartInstance.destroy();
            }

            // Kalau data kosong (misal baru install), jangan render chart kosong
            if (labels.length === 0) return;

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Income',
                            data: incomeData,
                            backgroundColor: '#3B82F6',
                            borderColor: '#3B82F6',
                            borderWidth: 1,
                            borderRadius: 6,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Expense',
                            data: expenseData,
                            backgroundColor: '#F87171',
                            borderColor: '#F87171',
                            borderWidth: 1,
                            borderRadius: 6,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
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
                                font: {
                                    family: "'Plus Jakarta Sans', sans-serif"
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#1e293b',
                            bodyColor: '#64748b',
                            borderColor: '#e2e8f0',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                color: '#94a3b8'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8'
                            }
                        }
                    }
                }
            });
        }
    </script>
</div>

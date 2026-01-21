<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 p-6">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Cash Flow Overview</h3>
            <p class="text-xs text-slate-400 dark:text-slate-500">Statistics of your income and expense</p>
        </div>
        
        <!-- FILTER SELECT -->
        <div class="relative w-full sm:w-auto">
            <select wire:model.live="chartPeriod"
                class="w-full sm:w-48 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 appearance-none cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-600 transition">
                <option value="today">Hari Ini (Today)</option>
                <option value="month">Bulan Ini (This Month)</option>
                <option value="last_month">Bulan Lalu (Last Month)</option>
                <option value="year">Tahun Ini (This Year)</option>
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

@script
<script>
    let chartInstance = null;

    const initChart = () => {
        const canvas = document.getElementById('financeChart');
        if (!canvas) return;

        // ✅ Ambil data dari Livewire property
        const data = $wire.chartData;
        const labels = data.labels || [];
        const income = data.income || [];
        const expense = data.expense || [];

        const ctx = canvas.getContext('2d');
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? '#334155' : '#f1f5f9'; 
        const tickColor = isDark ? '#94a3b8' : '#64748b'; 

        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Income',
                        data: income,
                        backgroundColor: '#3B82F6',
                        borderColor: '#3B82F6',
                        borderWidth: 1,
                        borderRadius: 6,
                        barPercentage: 0.6
                    },
                    {
                        label: 'Expense',
                        data: expense,
                        backgroundColor: '#F87171',
                        borderColor: '#F87171',
                        borderWidth: 1,
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
                        borderWidth: 1,
                        displayColors: false
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
    };

    // ✅ Reaktif terhadap perubahan $chartData
    $watch(() => $wire.chartData, () => {
        initChart();
    });

    // Update saat dark mode berubah
    window.addEventListener('toggle-theme', () => {
        if (chartInstance) initChart();
    });

    // Inisialisasi awal
    initChart();
</script>
@endscript
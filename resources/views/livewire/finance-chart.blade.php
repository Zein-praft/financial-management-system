<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 p-6">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">
                Cash Flow Overview
            </h3>
            <p class="text-xs text-slate-400 dark:text-slate-500">
                Statistics of your income and expense
            </p>
        </div>

        <!-- FILTER -->
        <div class="relative w-full sm:w-auto">
            <select wire:model="chartPeriod"
                class="w-full sm:w-48 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-lg p-2.5">
                <option value="today">Hari Ini</option>
                <option value="month">Bulan Ini</option>
                <option value="last_month">Bulan Lalu</option>
                <option value="year">Tahun Ini</option>
            </select>
        </div>
    </div>

    <!-- CHART -->
    <div class="relative w-full h-[400px]">
        <canvas id="financeChart"></canvas>
    </div>

    <script>
        let financeChart = null;

        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('financeChart');

            financeChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Income',
                            data: [],
                            backgroundColor: '#3B82F6'
                        },
                        {
                            label: 'Expense',
                            data: [],
                            backgroundColor: '#EF4444'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

        // 🔥 INI YANG PENTING
        Livewire.on('chart-update', data => {
            financeChart.data.labels = data.labels;
            financeChart.data.datasets[0].data = data.income;
            financeChart.data.datasets[1].data = data.expense;
            financeChart.update();
        });
    </script>
</div>

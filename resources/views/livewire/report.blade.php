<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-soft border border-slate-100 dark:border-slate-700 p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Analytics</h2>
            <p class="text-xs text-slate-400">Income vs Expense Overview</p>
        </div>
        
        <!-- Filter Buttons -->
        <div class="inline-flex bg-slate-100 dark:bg-slate-700 p-1 rounded-xl flex flex-wrap gap-1">
            <button wire:click="setFilter('today')" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter === 'today' ? 'bg-white text-primary shadow-sm dark:bg-slate-600 dark:text-white dark:shadow-none' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">Today</button>
            <button wire:click="setFilter('week')" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter === 'week' ? 'bg-white text-primary shadow-sm dark:bg-slate-600 dark:text-white dark:shadow-none' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">Week</button>
            <button wire:click="setFilter('month')" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter === 'month' ? 'bg-white text-primary shadow-sm dark:bg-slate-600 dark:text-white dark:shadow-none' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">Month</button>
            <button wire:click="setFilter('year')" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter === 'year' ? 'bg-white text-primary shadow-sm dark:bg-slate-600 dark:text-white dark:shadow-none' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">Year</button>
            <button wire:click="setFilter('all')" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter === 'all' ? 'bg-white text-primary shadow-sm dark:bg-slate-600 dark:text-white dark:shadow-none' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">All</button>
        </div>
    </div>

    <div class="relative h-72 w-full">
        <!-- TAMBAHKAN DATA-ATTRIBUTES SUPAYA JS BISA BACA DATA BARU -->
        <canvas id="reportChart" 
            data-labels="{{ json_encode($this->chartData['labels']) }}"
            data-income="{{ json_encode($this->chartData['income']) }}"
            data-expense="{{ json_encode($this->chartData['expense']) }}"
        ></canvas>
    </div>
</div>

@script
<script>
    let chartInstance = null;

    function renderReportChart() {
        const canvas = document.getElementById('reportChart');
        if (!canvas) return;

        // BACA DATA DARI ATTRIBUTES (DINAMIS)
        const labels = JSON.parse(canvas.dataset.labels || '[]');
        const incomeData = JSON.parse(canvas.dataset.income || '[]');
        const expenseData = JSON.parse(canvas.dataset.expense || '[]');

        const ctx = canvas.getContext('2d');
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? '#334155' : '#F1F5F9'; 
        const tickColor = isDark ? '#94A3B8' : '#64748B'; 

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
                        data: incomeData,
                        backgroundColor: '#10B981',
                        borderRadius: 6,
                        barThickness: 12,
                    },
                    {
                        label: 'Expense',
                        data: expenseData,
                        backgroundColor: '#F87171',
                        borderRadius: 6,
                        barThickness: 12,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false, },
                plugins: {
                    legend: {
                        position: 'bottom',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 8,
                            padding: 20,
                            font: { family: '"Plus Jakarta Sans"', size: 12, weight: '500' },
                            color: tickColor
                        }
                    },
                    tooltip: {
                        backgroundColor: isDark ? 'rgba(15, 23, 42, 0.9)' : 'rgba(15, 23, 42, 0.9)',
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor, borderDash: [5, 5], drawBorder: false },
                        ticks: { callback: function(value) { return 'Rp ' + value; }, font: { family: '"Plus Jakarta Sans"', size: 11 }, color: tickColor },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: '"Plus Jakarta Sans"', size: 11 }, color: tickColor },
                        border: { display: false }
                    }
                }
            }
        });
    }

    // 1. Render pertama kali
    renderReportChart();

    // 2. Render ulang pas ada update Livewire (Ganti Filter / Tambah Data)
    document.addEventListener('livewire:updated', function() {
        renderReportChart();
    });

    // 3. Render ulang pas Dark Mode berubah
    window.addEventListener('darkModeChanged', function() {
        renderReportChart();
    });
</script>
@endscript
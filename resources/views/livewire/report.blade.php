<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-soft border border-slate-100 dark:border-slate-700 p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Analytics</h2>
            <p class="text-xs text-slate-400">Income vs Expense Overview</p>
        </div>
        
        <!-- Filter Buttons (Updated with Year) -->
        <div class="inline-flex bg-slate-100 dark:bg-slate-700 p-1 rounded-xl flex flex-wrap gap-1">
            <button wire:click="setFilter('today')" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter === 'today' ? 'bg-white text-primary shadow-sm dark:bg-slate-600 dark:text-white dark:shadow-none' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">Today</button>
            <button wire:click="setFilter('week')" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter === 'week' ? 'bg-white text-primary shadow-sm dark:bg-slate-600 dark:text-white dark:shadow-none' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">Week</button>
            <button wire:click="setFilter('month')" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter === 'month' ? 'bg-white text-primary shadow-sm dark:bg-slate-600 dark:text-white dark:shadow-none' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">Month</button>
            <!-- NEW BUTTON -->
            <button wire:click="setFilter('year')" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter === 'year' ? 'bg-white text-primary shadow-sm dark:bg-slate-600 dark:text-white dark:shadow-none' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">Year</button>
            <button wire:click="setFilter('all')" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter === 'all' ? 'bg-white text-primary shadow-sm dark:bg-slate-600 dark:text-white dark:shadow-none' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">All</button>
        </div>
    </div>

    <div class="relative h-72 w-full">
        <canvas id="financeChart"></canvas>
    </div>
</div>

@script
<script>
    let chartInstance = null;
    const labels = @js($chartData['labels']);
    const incomeData = @js($chartData['income']);
    const expenseData = @js($chartData['expense']);

    function renderChart() {
        const ctx = document.getElementById('financeChart').getContext('2d');
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? '#334155' : '#F1F5F9'; 
        const tickColor = isDark ? '#94A3B8' : '#64748B'; 

        if (chartInstance) chartInstance.destroy();

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

    // Listen for Dark Mode toggle to update chart colors
    window.addEventListener('toggle-theme', () => {
        renderChart();
    });
    
    // Override the toggleDarkMode from layout to dispatch an event
    const originalToggle = window.toggleDarkMode;
    window.toggleDarkMode = function() {
        originalToggle();
        window.dispatchEvent(new Event('toggle-theme'));
    }

    renderChart();
</script>
@endscript
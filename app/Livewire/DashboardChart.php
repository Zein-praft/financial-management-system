<?php

namespace App\Livewire;

use Livewire\Attributes\On; // Listener Event
use Livewire\Component;
use App\Models\Transaction;

class DashboardChart extends Component
{
    public $chartPeriod = 'month'; 
    public $chartData = [];

    public function mount(): void
    {
        $this->updateChartData();
    }

    // LISTENER: Saat ada transaksi baru/hapus, ini otomatis jalan
    #[On('transaction-updated')]
    public function updateChartData(): void
    {
        $period = request()->input('chartPeriod', 'month');
        $query = Transaction::where('user_id', \Illuminate\Support\Facades\Auth::id()); // Filter User

        if ($period == 'today') {
            $query->whereDate('date', \Carbon\Carbon::today());
        } elseif ($period == 'last_month') {
            $query->whereMonth('date', \Carbon\Carbon::now()->subMonth()->month)
                   ->whereYear('date', \Carbon\Carbon::now()->subMonth()->year);
        } elseif ($period == 'year') {
            $query->whereYear('date', \Carbon\Carbon::now()->year);
        } else {
            $query->whereMonth('date', \Carbon\Carbon::now()->month)
                   ->whereYear('date', \Carbon\Carbon::now()->year);
        }

        $transactions = $query->orderBy('date', 'asc')->get();

        // Grouping untuk Chart
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

        $this->chartData = [
            'labels' => $labels,
            'income' => $incomeData,
            'expense' => $expenseData,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-chart');
    }
}
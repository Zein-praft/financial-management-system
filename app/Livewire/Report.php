<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class Report extends Component
{
    public $filter = 'month'; // today, week, month, year, all
    public $chartData = [];

    public function mount()
    {
        $this->updateChart();
    }

    public function setFilter($period)
    {
        $this->filter = $period;
        $this->updateChart();
    }

    private function updateChart()
    {
        $query = Transaction::query();

        if ($this->filter == 'today') {
            $query->whereDate('date', today());
        } elseif ($this->filter == 'week') {
            $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($this->filter == 'month') {
            $query->whereMonth('date', now()->month)->whereYear('date', now()->year);
        } elseif ($this->filter == 'year') {
            $query->whereYear('date', now()->year);
        }

        $transactions = $query->orderBy('date')->get();
        
        // Grouping Logic
        if ($this->filter == 'year') {
            // Group by Month (Jan - Dec)
            $months = [];
            $incomeMap = array_fill(0, 12, 0);
            $expenseMap = array_fill(0, 12, 0);
            
            foreach ($transactions as $t) {
                $monthIndex = \Carbon\Carbon::parse($t->date)->month - 1; // 0-11
                if ($t->type == 'income') $incomeMap[$monthIndex] += $t->amount;
                else $expenseMap[$monthIndex] += $t->amount;
            }
            
            $this->chartData = [
                'labels' => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                'income' => $incomeMap,
                'expense' => $expenseMap,
            ];
        } else {
            // Group by Date (Default)
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
    }

    public function render()
    {
        return view('livewire.report');
    }
}
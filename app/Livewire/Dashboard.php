<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 

class Dashboard extends Component
{
    protected $layout = 'layouts/app';

    public $totalIncome = 0;
    public $totalExpense = 0;
    public $balance = 0;
    
    public $chartPeriod = 'month'; 
    
    public $chartLabels = [];
    public $incomeData = [];
    public $expenseData = [];

    protected $listeners = ['refreshTransaction' => 'refreshAll'];

    public function mount(): void
    {
        $this->calculateStats();
        $this->updateChartData();
    }

    public function refreshAll(): void
    {
        $this->calculateStats();
        $this->updateChartData();
    }

    private function updateChartData(): void
    {
        Log::info("Dashboard: Filter diganti jadi: " . $this->chartPeriod);
        $this->updateChartData();
    }

    private function calculateStats(): void
    {
        $userId = Auth::id();

        $this->totalIncome = Transaction::where('user_id', $userId)
                                        ->where('type', 'income')
                                        ->sum('amount');
                                        
        $this->totalExpense = Transaction::where('user_id', $userId)
                                        ->where('type', 'expense')
                                        ->sum('amount');
                                        
        $this->balance = $this->totalIncome - $this->totalExpense;
    }

    private function updateChartData(): void
    {
        $userId = Auth::id();
        $query = Transaction::where('user_id', $userId);

        // LOGIC FILTER YANG LEBIH ROBUST
        if ($this->chartPeriod == 'today') {
            // PAKAI whereBetween AGAR AMAN DARI JAM/MENIT
            $query->whereBetween('date', [now()->startOfDay(), now()->endOfDay()]);
        } elseif ($this->chartPeriod == 'month') {
            $query->whereMonth('date', now()->month)
                  ->whereYear('date', now()->year);
        } elseif ($this->chartPeriod == 'last_month') {
            $query->whereMonth('date', now()->subMonth()->month)
                  ->whereYear('date', now()->subMonth()->year);
        } elseif ($this->chartPeriod == 'year') {
            $query->whereYear('date', now()->year);
        }

        $transactions = $query->orderBy('date')->get();
        
        Log::info("Dashboard: Transaksi ketemu " . count($transactions) . " buat filter " . $this->chartPeriod);
        
        if ($this->chartPeriod == 'year') {
            $incomeMap = array_fill(0, 12, 0);
            $expenseMap = array_fill(0, 12, 0);
            
            foreach ($transactions as $t) {
                $monthIndex = \Carbon\Carbon::parse($t->date)->month - 1;
                if ($t->type == 'income') {
                    $incomeMap[$monthIndex] += $t->amount;
                } else {
                    $expenseMap[$monthIndex] += $t->amount;
                }
            }
            
            $this->chartLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            $this->incomeData = $incomeMap;
            $this->expenseData = $expenseMap;
        } else {
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

            $this->chartLabels = $labels;
            $this->incomeData = $incomeData;
            $this->expenseData = $expenseData;
        }
            $query->whereDate('date', today());
        } elseif ($this->chartPeriod == 'month') {
            $query->whereMonth('date', now()->month)->whereYear('date', now()->year);
        } elseif ($this->chartPeriod == 'last_month') {
            $query->whereMonth('date', now()->subMonth()->month)->whereYear('date', now()->subMonth()->year);
        } elseif ($this->chartPeriod == 'year') {
            $query->whereYear('date', now()->year);
        }

        $transactions = $query->orderBy('date')->get();

        // Grouping untuk Chart (Group by Date)
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

        $this->chartLabels = $labels;
        $this->incomeData = $incomeData;
        $this->expenseData = $expenseData;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
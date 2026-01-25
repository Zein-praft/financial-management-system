<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    // FILTER
    public $chartPeriod = 'today';

    // SUMMARY
    public $totalIncome = 0;
    public $totalExpense = 0;
    public $balance = 0;

    // CHART DATA
    public $chartLabels = [];
    public $incomeData = [];
    public $expenseData = [];

    protected $listeners = [
        'refreshTransaction' => 'refreshStats'
    ];

    public function mount()
    {
        $this->loadAll();
    }

    public function updatedChartPeriod()
    {
        $this->loadAll();
        $this->dispatch('refreshChart');
    }

    public function refreshStats()
    {
        $this->loadAll();
        $this->dispatch('refreshChart');
    }

    private function loadAll()
    {
        $this->calculateStats();
        $this->loadChartData();
    }

    private function calculateStats()
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

    private function loadChartData()
    {
        $userId = Auth::id();

        $query = Transaction::where('user_id', $userId);

        if ($this->chartPeriod === 'today') {
            $query->whereDate('date', now());
        } elseif ($this->chartPeriod === 'month') {
            $query->whereMonth('date', now()->month)
                  ->whereYear('date', now()->year);
        } elseif ($this->chartPeriod === 'last_month') {
            $query->whereMonth('date', now()->subMonth()->month)
                  ->whereYear('date', now()->subMonth()->year);
        } elseif ($this->chartPeriod === 'year') {
            $query->whereYear('date', now()->year);
        }

        $data = $query
            ->selectRaw('DATE(date) as label')
            ->selectRaw('SUM(CASE WHEN type="income" THEN amount ELSE 0 END) as income')
            ->selectRaw('SUM(CASE WHEN type="expense" THEN amount ELSE 0 END) as expense')
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $this->chartLabels = $data->pluck('label');
        $this->incomeData  = $data->pluck('income');
        $this->expenseData = $data->pluck('expense');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}

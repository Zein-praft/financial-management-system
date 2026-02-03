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
        'refreshTransaction' => 'reloadData'
    ];

    public function mount()
    {
        // ❗ JALAN SEKALI SAAT PERTAMA MASUK
        $this->reloadData();
    }

    public function updatedChartPeriod()
    {
        // ❗ JANGAN DISPATCH EVENT DI SINI
        $this->reloadData();
    }

    public function reloadData()
    {
        $this->calculateStats();
        $this->loadChartData();
    }

    private function calculateStats()
    {
        $userId = Auth::id();

        if (!$userId) return;

        $transactions = Transaction::where('user_id', $userId)->get();

        $this->totalIncome = $transactions
            ->where('type', 'income')
            ->sum('amount');

        $this->totalExpense = $transactions
            ->where('type', 'expense')
            ->sum('amount');

        $this->balance = $this->totalIncome - $this->totalExpense;
    }

    private function loadChartData()
    {
        $userId = Auth::id();

        if (!$userId) return;

        $query = Transaction::where('user_id', $userId);

        switch ($this->chartPeriod) {
            case 'today':
                $query->whereDate('date', today());
                break;

            case 'month':
                $query->whereMonth('date', now()->month)
                      ->whereYear('date', now()->year);
                break;

            case 'last_month':
                $query->whereMonth('date', now()->subMonth()->month)
                      ->whereYear('date', now()->subMonth()->year);
                break;

            case 'year':
                $query->whereYear('date', now()->year);
                break;
        }

        $data = $query
            ->selectRaw('DATE(date) as label')
            ->selectRaw('SUM(CASE WHEN type="income" THEN amount ELSE 0 END) as income')
            ->selectRaw('SUM(CASE WHEN type="expense" THEN amount ELSE 0 END) as expense')
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $this->chartLabels = $data->pluck('label')->toArray();
        $this->incomeData  = $data->pluck('income')->toArray();
        $this->expenseData = $data->pluck('expense')->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}

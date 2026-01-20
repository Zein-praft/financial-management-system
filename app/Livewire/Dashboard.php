<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class Dashboard extends Component
{
    public $totalIncome = 0;
    public $totalExpense = 0;
    public $balance = 0;
    
    // Variable untuk filter chart dari Select Box HTML Anda
    public $chartPeriod = 'month'; 
    
    // Data untuk Chart
    public $chartLabels = [];
    public $incomeData = [];
    public $expenseData = [];

    public function mount(): void
    {
        $this->calculateStats();
        $this->updateChartData();
    }

    // Listener saat filter chart diubah
    public function updatedChartPeriod(): void
    {
        $this->calculateStats(); // Jika ingin statistik kartu juga berubah sesuai filter
        // Atau jika kartu harus ALL TIME, jangan panggil calculateStats di sini.
        // Untuk sekarang saya panggil updateChartData saja agar kartu tetap total.
        $this->updateChartData();
    }

    private function calculateStats(): void
    {
        // Hitung total keseluruhan (ALL TIME)
        $this->totalIncome = Transaction::where('type', 'income')->sum('amount');
        $this->totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $this->balance = $this->totalIncome - $this->totalExpense;
    }

    private function updateChartData(): void
    {
        $query = Transaction::query();

        // LOGIC FILTER YANG LEBIH ROBUST
        if ($this->chartPeriod == 'today') {
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
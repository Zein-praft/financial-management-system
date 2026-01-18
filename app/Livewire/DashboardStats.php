<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; // <--- TAMBAHKAN INI

class DashboardStats extends Component
{
    public $totalIncome = 0;
    public $totalExpense = 0;
    public $balance = 0;
    public $chartPeriod = 'month'; 

    public function mount(): void
    {
        $this->calculateStats();
    }

    #[On('transaction-updated')]
    public function calculateStats(): void
    {
        // GANTI auth()->id() MENJADI Auth::id()
        $query = Transaction::where('user_id', Auth::id()); 

        $this->totalIncome = $query->where('type', 'income')->sum('amount');
        $this->totalExpense = $query->where('type', 'expense')->sum('amount');
        $this->balance = $this->totalIncome - $this->totalExpense;
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}
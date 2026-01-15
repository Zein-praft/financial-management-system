<?php

namespace App\Livewire;

use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\Transaction;

class Dashboard extends Component
{
    public $totalIncome = 0;
    public $totalExpense = 0;
    public $balance = 0;

    /**
     * Menghitung ulang data dashboard saat komponen dimuat atau ada event refresh.
     */
    public function mount(): void
    {
        $this->calculateStats();
    }

    /**
     * Listener untuk event yang dikirim dari komponen lain (misal: TransactionForm)
     */
    #[On('transaction-updated')] 
    public function refreshDashboard(): void
    {
        $this->calculateStats();
    }

    private function calculateStats(): void
    {
        $this->totalIncome = Transaction::where('type', 'income')->sum('amount');
        $this->totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $this->balance = $this->totalIncome - $this->totalExpense;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransactionHistory extends Component
{
    // Array untuk menyimpan nilai filter input
    public $filters = [
        'date'  => '',
        'month' => '',
        'year'  => '',
    ];

    /**
     * Computed Property: Mengambil data transaksi berdasarkan filter.
     */
    public function getTransactionsProperty()
    {
        $query = Transaction::query()->where('user_id', Auth::id()); // Pastikan filter by user login

        if (!empty($this->filters['date'])) {
            $query->whereDate('date', $this->filters['date']);
        }

        // Filter Month (pastikan input value 0-11)
        if ($this->filters['month'] !== '') {
            $query->whereMonth('date', $this->filters['month']);
        }

        if (!empty($this->filters['year'])) {
            $query->whereYear('date', $this->filters['year']);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    /**
     * Computed Property: Total Income & Expense
     */
    public function getTotalsProperty()
    {
        $transactions = $this->transactions;

        return [
            'income'  => $transactions->where('type', 'income')->sum('amount'),
            'expense' => $transactions->where('type', 'expense')->sum('amount'),
        ];
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function delete($id)
    {
        Transaction::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.transaction-history');
    }
}
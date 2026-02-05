<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransactionHistory extends Component
{
    // Array untuk menyimpan nilai filter input
    public $filters = [
        'date' => '',
        'month' => '',
        'year' => '',
        'type' => '', // <--- TAMBAHAN INI: Untuk filter income/expense
    ];

    /**
     * Computed Property: Mengambil data transaksi berdasarkan filter.
     */
    public function getTransactionsProperty()
    {
        // Load relasi 'category' biar gak error pas dipanggil di blade ($t->category->name)
        $query = Transaction::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('date', 'desc');

        // Filter Specific Date
        if (!empty($this->filters['date'])) {
            $query->whereDate('date', $this->filters['date']);
        }

        // Filter Month
        if ($this->filters['month'] !== '') {
            $query->whereMonth('date', $this->filters['month']);
        }

        // Filter Year
        if (!empty($this->filters['year'])) {
            $query->whereYear('date', $this->filters['year']);
        }

        // <--- TAMBAHAN INI: Logika Filter Tipe Transaksi (Income/Expense) --->
        if (!empty($this->filters['type'])) {
            // Asumsi nama kolom di database adalah 'type' (sesuai logika getTotalsProperty kamu)
            $query->where('type', $this->filters['type']);
        }

        return $query->get();
    }

    /**
     * Computed Property: Total Income & Expense
     * Mengambil data dari $this->transactions yang sudah difilter
     * 
     * NOTE: Karena $this->transactions sudah difilter oleh 'type' di atas,
     * maka total income/expense di bawah ini juga akan berubah sesuai filter tipe yang dipilih.
     */
    public function getTotalsProperty()
    {
        $transactions = $this->transactions;

        return [
            'income' => $transactions->where('type', 'income')->sum('amount'),
            'expense' => $transactions->where('type', 'expense')->sum('amount'),
        ];
    }

    /**
     * Method Tombol Apply Filter
     * Sebenarnya tidak wajib dipanggil jika pakai wire:model.live,
     * tapi tetap kita biarkan kalau kamu mau pakai tombol manual.
     */
    public function applyFilters()
    {
        // Livewire akan otomatis re-render karena properti berubah
    }

    /**
     * Method Reset Filter
     */
    public function resetFilters()
    {
        // Ini akan mereset semua key di array $filters termasuk 'type' yang baru kita tambah
        $this->reset('filters');
    }

    /**
     * Method Hapus Transaksi
     */
    public function delete($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->find($id);

        if ($transaction) {
            $transaction->delete();
        }
    }

    public function render()
    {
        return view('livewire.transaction-history');
    }
}
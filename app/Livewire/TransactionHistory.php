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

return $query->get();
}

/**
* Computed Property: Total Income & Expense
* Mengambil data dari $this->transactions yang sudah difilter
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
*/
public function applyFilters()
{
// Kita return saja, Livewire akan merender ulang
// dan property $this->transactions akan terupdate otomatis
// berdasarkan nilai $filters terbaru.
return;
}

/**
* Method Reset Filter
*/
public function resetFilters()
{
$this->reset('filters');
}

/**
* Method Hapus Transaksi (Sudah ditambah keamanan user check)
*/
public function delete($id)
{
// Cari transaksi yang milik user login saja
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
<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; // <--- TAMBAHKAN INI

class TransactionList extends Component
{
    public function render()
    {
        // GANTI auth()->id() MENJADI Auth::id()
        $transactions = Transaction::with('category')
                                   ->where('user_id', Auth::id()) 
                                   ->orderBy('date', 'desc')
                                   ->orderBy('created_at', 'desc')
                                   ->take(50)
                                   ->get();

        return view('livewire.transaction-list', compact('transactions'));
    }

    public function delete($id)
    {
        // Kita juga harus memastikan data yang dihapus milik user yang login
        Transaction::where('id', $id)->where('user_id', Auth::id())->delete();
        
        $this->dispatch('transaction-updated');
    }

    #[On('transaction-updated')]
    public function refreshList()
    {
        // Livewire akan me-render ulang otomatis
    }

    public function getIcon($name)
    {
        $name = strtolower($name);
        if (str_contains($name, 'makanan') || str_contains($name, 'food')) return 'fa-utensils';
        if (str_contains($name, 'transport') || str_contains($name, 'kendaraan')) return 'fa-car';
        if (str_contains($name, 'belanja') || str_contains($name, 'shopping')) return 'fa-bag-shopping';
        if (str_contains($name, 'tagihan') || str_contains($name, 'bill')) return 'fa-file-invoice';
        if (str_contains($name, 'gaji') || str_contains($name, 'salary')) return 'fa-briefcase';
        if (str_contains($name, 'kesehatan') || str_contains($name, 'health')) return 'fa-heart-pulse';
        if (str_contains($name, 'bonus')) return 'fa-coins';
        return 'fa-tag';
    }
}
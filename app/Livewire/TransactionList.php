<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionList extends Component
{
    // --- PENTING: TAMBAHKAN INI ---
    // Ini artinya: "Kalau dengar ada event 'refreshTransaction', lu harus RELOAD (render ulang)"
    protected $listeners = ['refreshTransaction' => '$refresh'];

    public function render()
    {
        // Ambil transaksi user yang login, urutkan dari yang terbaru
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
        // Cari data berdasarkan ID dan User ID (Keamanan)
        $transaction = Transaction::where('id', $id)
                                  ->where('user_id', Auth::id())
                                  ->first();

        if ($transaction) {
            $transaction->delete();

            // DISPATCH 'refreshTransaction'
            // Ini buat ngasih tau ke Dashboard & Form & List sendiri (biar gak dobel update)
            $this->dispatch('refreshTransaction');
        }
    }

    // Helper fungsi buat icon
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
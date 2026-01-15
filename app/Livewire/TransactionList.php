<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Transaction;

class TransactionList extends Component
{
    public function render()
    {
        // Mengambil transaksi terbaru, dengan relasi kategori, urutkan dari yang terbaru
        $transactions = Transaction::with('category')
                                   ->orderBy('date', 'desc')
                                   ->orderBy('created_at', 'desc')
                                   ->take(50) // Batasi 50 transaksi terakhir untuk performa view awal
                                   ->get();

        return view('livewire.transaction-list', compact('transactions'));
    }

    /**
     * Hapus Transaksi
     */
    public function delete($id)
    {
        Transaction::findOrFail($id)->delete();
        
        // Dispatch event agar data di dashboard ikut terupdate
        $this->dispatch('transaction-updated');
    }

    /**
     * Listener refresh dari komponen lain
     */
    #[On('transaction-updated')]
    public function refreshList()
    {
        // Livewire otomatis me-render ulang method render() saat dipanggil
    }

    /**
     * Helper untuk menentukan icon berdasarkan nama kategori
     * Fungsi ini dipanggil dari file Blade (transaction-list.blade.php)
     */
    public function getIcon($name)
    {
        // Ubah nama menjadi huruf kecil agar pencarian lebih akurat
        $name = strtolower($name);

        // Cek kata kunci di dalam nama kategori
        if (str_contains($name, 'makanan') || str_contains($name, 'food')) return 'fa-utensils';
        if (str_contains($name, 'transport') || str_contains($name, 'kendaraan')) return 'fa-car';
        if (str_contains($name, 'belanja') || str_contains($name, 'shopping')) return 'fa-bag-shopping';
        if (str_contains($name, 'tagihan') || str_contains($name, 'bill')) return 'fa-file-invoice';
        if (str_contains($name, 'gaji') || str_contains($name, 'salary')) return 'fa-briefcase';
        if (str_contains($name, 'kesehatan') || str_contains($name, 'health')) return 'fa-heart-pulse';
        if (str_contains($name, 'bonus')) return 'fa-coins';
        
        // Icon default jika tidak ada yang cocok
        return 'fa-tag';
    }
}
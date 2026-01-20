<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionForm extends Component
{
    // Variabel Form
    public $category_name;
    public $type = 'income';
    public $amount;
    public $date;
    public $note;

    // Variabel Notifikasi
    public $message = '';
    
    // Data Kategori buat Datalist
    public $categories = [];

    public function mount(): void
    {
        $this->date = date('Y-m-d');
        // Ambil SEMUA kategori (kita gak filter tipe lagi)
        $this->categories = Category::all();
    }

    protected $rules = [
        'type' => 'required|in:income,expense',
        'category_name' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'note' => 'nullable|string|max:255',
    ];

    // KITA HAPUS updatedType() biar input gak ke-hapus pas ganti tipe
    // Jadi lu bisa pilih kategori lama, trus ganti tipe transaksinya aja

    public function save()
    {
        $this->validate();

        // LOGIC BARU: Cari kategori berdasarkan NAMA SAJA (Tanpa lihat type)
        $category = Category::where('name', trim($this->category_name))->first();

        if ($category) {
            // Kalau kategori ketemu, kita UPDATE tipenya sesuai form saat ini
            // Jadi "Gaji" bisa berubah jadi Income atau Expense sesuai kebutuhan
            if ($category->type !== $this->type) {
                $category->update(['type' => $this->type]);
            }
        } else {
            // Kalau gak ketemu sama sekali, baru bikin baru
            $category = Category::create([
                'name' => trim($this->category_name),
                'type' => $this->type,
            ]);
        }

        // Simpan Transaksi
        Transaction::create([
            'user_id' => Auth::id(),
            'type' => $this->type,
            'category_id' => $category->id,
            'amount' => $this->amount,
            'date' => $this->date,
            'note' => $this->note,
        ]);

        // Reset Form Input
        $this->reset(['amount', 'note']);
        // $this->category_name GAK DI RESET, biar gak capek ngetik ulang kalau mau input berulang
        // Tapi kalau mau direset, tinggal aktifin baris bawah:
        // $this->reset('category_name'); 

        $this->date = date('Y-m-d');

        // Dispatch event biar Dashboard update
        $this->dispatch('refreshTransaction');
        
        // Set pesan sukses
        $this->message = 'Transaksi berhasil disimpan.';
    }

    public function render()
    {
        // Ambil SEMUA kategori (biar user bisa pilih nama kategori yg sudah ada)
        // Tipenya gak masalah, nanti pas save bakal diupdate otomatis
        $categories = Category::all();

        return view('livewire.transaction-form', [
            'categories' => $categories
        ]);
    }
}
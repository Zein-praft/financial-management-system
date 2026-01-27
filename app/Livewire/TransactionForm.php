<?php

namespace App\Livewire; // Pastikan namespace sesuai (App\Http\Livewire atau App\Livewire)

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
        
        // KEMBALI KE ALL() KARENA TABEL CATEGORIES BELUM PUNYA USER_ID
        $this->categories = Category::all(); 
    }

    protected $rules = [
        'type'          => 'required|in:income,expense',
        'category_name' => 'required|string|max:255',
        'amount'        => 'required|numeric|min:0',
        'date'          => 'required|date',
        'note'          => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        // LOGIC: Cari kategori berdasarkan NAMA SAJA (Tanpa user_id)
        // Ini memungkinkan "Global Categories"
        $category = Category::where('name', trim($this->category_name))->first();

        if ($category) {
            // Kalau kategori ketemu, kita UPDATE tipenya sesuai form saat ini
            // Jadi "Gaji" bisa berubah jadi Income atau Expense sesuai kebutuhan
            if ($category->type !== $this->type) {
                $category->update(['type' => $this->type]);
            }
        } else {
            // Kalau gak ketemu sama sekali, baru bikin baru
            // PERHATIAN: gw hapus 'user_id' disini biar gak error kalo kolom gak ada
            $category = Category::create([
                'name'     => trim($this->category_name),
                'type'     => $this->type,
            ]);
        }

        // Simpan Transaksi
        // Pastikan transactions punya user_id, ini yang penting buat security data utama
        Transaction::create([
            'user_id'      => Auth::id(),
            'type'         => $this->type,
            'category_id'  => $category->id,
            'amount'       => $this->amount,
            'date'         => $this->date,
            'note'         => $this->note,
        ]);

        // Reset Form Input
        $this->reset(['amount', 'note']);
        // $this->category_name GAK DI RESET, biar gak capek ngetik ulang kalau mau input berulang
        
        $this->date = date('Y-m-d');

        // Dispatch event biar Dashboard update (Scroll ke atas)
        $this->dispatch('refreshTransaction');
        
        // Set pesan sukses
        $this->message = 'Transaksi berhasil disimpan.';
    }

    public function render()
    {
        // KEMBALI KE ALL() BIAR GAK ERROR
        $this->categories = Category::all();

        return view('livewire.transaction-form', [
            'categories' => $this->categories
        ]);
    }
}   
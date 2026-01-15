<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Transaction;

class TransactionForm extends Component
{
    public $type = 'income';
    public $amount;
    public $category_id;
    public $date;
    public $note;

    public function mount(): void
    {
        $this->date = date('Y-m-d');
    }

    protected $rules = [
        'type' => 'required|in:income,expense',
        'category_id' => 'required|exists:categories,id',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'note' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        Transaction::create([
            'type' => $this->type,
            'category_id' => $this->category_id,
            'amount' => $this->amount,
            'date' => $this->date,
            'note' => $this->note,
        ]);

        // Reset Form
        $this->reset(['amount', 'category_id', 'note']);
        $this->date = date('Y-m-d');

        // Kirim event ke komponen lain (Dashboard & TransactionList)
        $this->dispatch('transaction-updated');
        
        // Tampilkan notifikasi (Optional: flash message)
        session()->flash('message', 'Transaksi berhasil disimpan.');
    }

    public function render()
    {
        // Ambil kategori berdasarkan tipe yang dipilih
        $categories = Category::where('type', $this->type)->get();

        return view('livewire.transaction-form', [
            'categories' => $categories
        ]);
    }
}
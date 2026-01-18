<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; // <--- TAMBAHKAN INI

class TransactionForm extends Component
{
    public $category_name;
    public $type = 'income';
    public $amount;
    public $date;
    public $note;

    public function mount(): void
    {
        $this->date = date('Y-m-d');
    }

    protected $rules = [
        'type' => 'required|in:income,expense',
        'category_name' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'note' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        $category = Category::firstOrCreate(
            [
                'name' => trim($this->category_name),
                'type' => $this->type,
            ],
            [
                'name' => trim($this->category_name),
                'type' => $this->type,
            ]
        );

        Transaction::create([
            // GANTI auth()->id() MENJADI Auth::id()
            'user_id' => Auth::id(), 
            'type' => $this->type,
            'category_id' => $category->id,
            'amount' => $this->amount,
            'date' => $this->date,
            'note' => $this->note,
        ]);

        $this->reset(['amount', 'note', 'category_name']);
        $this->date = date('Y-m-d');

        $this->dispatch('transaction-updated');
        
        session()->flash('message', 'Transaksi berhasil disimpan.');
    }

    public function render()
    {
        $categories = Category::all();

        return view('livewire.transaction-form', [
            'categories' => $categories
        ]);
    }
}
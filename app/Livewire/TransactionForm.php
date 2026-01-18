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

    public $categories = [];

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->loadCategories();
    }

    public function updatedType()
    {
        $this->category_id = null;
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::where('type', $this->type)->get();
    }

    protected $rules = [
        'type' => 'required|in:income,expense',
        'category_id' => 'required|exists:categories,id',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'note' => 'nullable|string',
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

        $this->reset(['amount', 'category_id', 'note']);
        $this->date = now()->format('Y-m-d');

        $this->dispatch('transaction-updated');

        session()->flash('message', 'Transaksi berhasil disimpan');
    }

    public function render()
    {
        return view('livewire.transaction-form');
    }
}

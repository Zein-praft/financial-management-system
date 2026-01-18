<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\Category;
use Livewire\Attributes\On;
use Carbon\Carbon;

class Dashboard extends Component
{
    // --- VARIABEL CHART & SUMMARY ---
    public $totalIncome = 0;
    public $totalExpense = 0;
    public $balance = 0;
    public $transactions = [];
    public $chartPeriod = 'year'; 
    public $chartLabels = [];
    public $incomeData = [];
    public $expenseData = [];

    // --- VARIABEL FORM ---
    public $type = 'income';
    public $date;
    public $amount;
    public $category_id;
    public $note;
    public $categories = [];

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->loadCategories();
        $this->loadSummary(); 
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

    #[On('transaction-updated')]
    public function loadSummary()
    {
        // --- LOGIC SUMMARY (Tanpa Filter User) ---
        $this->totalIncome = Transaction::where('type', 'income')->sum('amount');
        $this->totalExpense = Transaction::where('type', 'expense')->sum('amount');
        
        // Perhitungan Balance: Income - Expense
        $this->balance = $this->totalIncome - $this->totalExpense;

        // List Transaksi (Ambil semua)
        $this->transactions = Transaction::orderBy('date', 'desc')->limit(5)->get();

        // --- LOGIC CHART ---
        $this->updateChartData();
    }

    public function updatedChartPeriod()
    {
        $this->updateChartData();
    }

    public function save()
    {
        $this->validate([
            'date' => 'required',
            'amount' => 'required|numeric',
            'category_id' => 'required',
        ]);

        // SAVE DATA (Tanpa User ID)
        Transaction::create([
            'type' => $this->type,
            'date' => $this->date,
            'amount' => $this->amount,
            'category_id' => $this->category_id,
            'note' => $this->note,
        ]);

        $this->amount = '';
        $this->note = '';
        session()->flash('message', 'Transaction saved successfully!');
        $this->loadSummary();
        $this->dispatch('transaction-updated');
    }

    public function updateChartData()
    {
        // Query Chart (Ambil semua data)
        $transactions = Transaction::query();
        $startDate = null;
        $endDate = null;

        if ($this->chartPeriod == 'today') {
            $startDate = Carbon::today()->startOfDay();
            $endDate = Carbon::today()->endOfDay();
        } elseif ($this->chartPeriod == 'month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($this->chartPeriod == 'last_month') {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();
        } elseif ($this->chartPeriod == 'year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        }

        if ($startDate) {
            $transactions->whereBetween('date', [$startDate, $endDate]);
        }

        if ($this->chartPeriod == 'year') {
            $data = $transactions->get()->groupBy(function($item) {
                return Carbon::parse($item->date)->format('M'); 
            });
        } elseif ($this->chartPeriod == 'today') {
            $data = $transactions->get()->groupBy(function($item) {
                return Carbon::parse($item->date)->format('H:00'); 
            });
        } else {
            $data = $transactions->get()->groupBy(function($item) {
                return Carbon::parse($item->date)->format('d');
            });
        }

        $labels = [];
        $incomes = [];
        $expenses = [];

        foreach ($data as $key => $trans) {
            $labels[] = $key;
            $incomes[] = $trans->where('type', 'income')->sum('amount');
            $expenses[] = $trans->where('type', 'expense')->sum('amount');
        }

        $this->chartLabels = $labels;
        $this->incomeData = $incomes;
        $this->expenseData = $expenses;
    }

    public function getIcon($categoryName)
    {
        return 'fa-tag';
    }

    public function delete($id)
    {
        // Hapus langsung tanpa cek user
        $transaction = Transaction::find($id);
        if($transaction) {
            $transaction->delete();
            $this->loadSummary();
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
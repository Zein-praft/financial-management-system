<?php

// namespace App\Livewire;

// use Livewire\Component;
// use App\Models\Transaction;
// use Illuminate\Support\Facades\Auth;

// class DashboardStats extends Component
// {
//     public $totalIncome = 0;
//     public $totalExpense = 0;
//     public $balance = 0;
//     // Kalau chartPeriod dipake di filter, lu bole nambahin ini
//     // public $chartPeriod = 'month'; 

//     // FIX 1: Ganti jadi listener array (Lebih aman gak salah ketik)
//     protected $listeners = ['refreshTransaction' => 'calculateStats'];

//     public function mount(): void
//     {
//         $this->calculateStats();
//     }

//     // FIX 2: Benerin Logic Query (Pisah Income & Expense biar gak tabrakan)
//     public function calculateStats(): void
//     {
//         $userId = Auth::id();

//         // Hitung Income (Query Bersih)
//         $this->totalIncome = Transaction::where('user_id', $userId)
//                                         ->where('type', 'income')
//                                         ->sum('amount');
                                        
//         // Hitung Expense (Query Terpisah)
//         $this->totalExpense = Transaction::where('user_id', $userId)
//                                         ->where('type', 'expense')
//                                         ->sum('amount');
                                        
//         $this->balance = $this->totalIncome - $this->totalExpense;
//     }

//     public function render()
//     {
//         return view('livewire.dashboard-stats');
//     }
// }
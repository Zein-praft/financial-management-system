<?php

namespace App\Livewire;

use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;

class BillReminder extends Component
{
    // Properties untuk Form
    public $name;
    public $due_date;
    public $amount;
    
    public $isModalOpen = false;

    public function render()
    {
        
        $bills = Bill::where('user_id', Auth::id())
            ->orderBy('due_date', 'asc')
            ->get();
       
        $dueTodayCount = $bills->filter(function ($bill) {
            return $bill->due_date->isToday();
        })->count();

        return view('livewire.bill-reminder', [
            'bills' => $bills,
            'dueTodayCount' => $dueTodayCount,
        ]);
    }

    public function openModal()
    {
        $this->reset(['name', 'due_date', 'amount']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function saveBill()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'due_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
        ]);

        Bill::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'due_date' => $this->due_date,
            'amount' => $this->amount,
        ]);

        $this->closeModal();
        
        
        session()->flash('message', 'Bill berhasil ditambahkan!');
    }

    public function deleteBill($id)
    {
        $bill = Bill::find($id);
        if ($bill && $bill->user_id === Auth::id()) {
            $bill->delete();
        }
    }

    public function getDaysDiff($dueDate)
    {
        return today()->diffInDays($dueDate, false); 
    }
    
    
    public function formatAmount($amount)
    {
        return '$' . number_format($amount, 2);
    }

    // --- NEW: FUNCTION UNTUK NOTIFIKASI ---
    // Method ini dipanggil sama Javascript buat cek bill jatuh tempo
    public function getDueBills()
    {
        return Bill::where('user_id', Auth::id())
            ->where('due_date', '<=', now()->format('Y-m-d')) // Due today atau overdue
            ->where('is_paid', false) // Belum lunas
            ->orderBy('due_date', 'asc')
            ->take(5) // Ambil max 5 bill biar ga spam
            ->get(['id', 'name', 'due_date', 'amount']);
    }
}
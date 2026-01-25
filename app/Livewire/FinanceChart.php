<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FinanceChart extends Component
{
    public $chartPeriod = 'today';

    public function mount()
    {
        $this->updateChartData();
    }

    public function updatedChartPeriod()
    {
        $this->updateChartData();
    }

    private function updateChartData()
    {
        $query = Transaction::where('user_id', Auth::id());

        switch ($this->chartPeriod) {
            case 'today':
                $query->whereDate('created_at', today());
                break;

            case 'month':
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
                break;

            case 'last_month':
                $query->whereMonth('created_at', now()->subMonth()->month)
                      ->whereYear('created_at', now()->subMonth()->year);
                break;

            case 'year':
                $query->whereYear('created_at', now()->year);
                break;
        }

        $transactions = $query->orderBy('created_at')->get();

        $labels = [];
        $income = [];
        $expense = [];

        if ($this->chartPeriod === 'year') {
            $income = array_fill(0, 12, 0);
            $expense = array_fill(0, 12, 0);

            foreach ($transactions as $t) {
                $i = Carbon::parse($t->created_at)->month - 1;

                if ($t->type === 'income') {
                    $income[$i] += $t->amount;
                } else {
                    $expense[$i] += $t->amount;
                }
            }

            $labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        } else {
            $grouped = $transactions->groupBy(fn ($t) =>
                Carbon::parse($t->created_at)->format('Y-m-d')
            );

            foreach ($grouped as $date => $items) {
                $labels[] = Carbon::parse($date)->format('d M');
                $income[] = $items->where('type', 'income')->sum('amount');
                $expense[] = $items->where('type', 'expense')->sum('amount');
            }
        }

        $this->dispatch('updateChart', [
            'labels' => $labels,
            'income' => $income,
            'expense' => $expense,
        ]);
    }

    public function render()
    {
        return view('livewire.finance-chart');
    }
}

        {{-- PHP LOGIC LOCAL (FIX DATA BOCOR & ERROR AUTH) --}}
        @php
            // 1. Ambil parameter filter
            $period = request()->input('chartPeriod', 'month');
            
            // 2. Query Dasar TRANSAKSI (WAJIB FILTER USER ID)
            // GUNAKAN NAMESPACE LENGKAP AGAR ERROR UNDEFINED HILANG
            $query = \App\Models\Transaction::where('user_id', \Illuminate\Support\Facades\Auth::id());
            
            // 3. Logika Filter Waktu
            if ($period == 'today') {
                $query->whereDate('date', \Carbon\Carbon::today());
            } elseif ($period == 'last_month') {
                $query->whereMonth('date', \Carbon\Carbon::now()->subMonth()->month)
                       ->whereYear('date', \Carbon\Carbon::now()->subMonth()->year);
            } elseif ($period == 'year') {
                $query->whereYear('date', \Carbon\Carbon::now()->year);
            } else {
                // Default Month
                $query->whereMonth('date', \Carbon\Carbon::now()->month)
                       ->whereYear('date', \Carbon\Carbon::now()->year);
            }

            $transactions = $query->orderBy('date', 'asc')->get();

            // 4. Grouping untuk Chart
            $grouped = $transactions->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
            });

            $labels = [];
            $incomeData = [];
            $expenseData = [];

            foreach ($grouped as $date => $items) {
                $labels[] = \Carbon\Carbon::parse($date)->format('M d');
                $incomeData[] = $items->where('type', 'income')->sum('amount');
                $expenseData[] = $items->where('type', 'expense')->sum('amount');
            }

            // 5. Hitung Statistik Total (ALL TIME)
            // Pastikan hitungan JUGA filter by user
            $statsQuery = \App\Models\Transaction::where('user_id', \Illuminate\Support\Facades\Auth::id());
            
            $totalIncome = $statsQuery->where('type', 'income')->sum('amount');
            $totalExpense = $statsQuery->where('type', 'expense')->sum('amount');
            $balance = $totalIncome - $totalExpense;
        @endphp
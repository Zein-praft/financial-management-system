<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Income -->
    <div class="bg-white p-6 rounded-2xl shadow-soft border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-arrow-down"></i>
                </div>
                <span class="text-sm font-medium text-slate-500">Total Income</span>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">
                Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </h3>
        </div>
    </div>

    <!-- Expense -->
    <div class="bg-white p-6 rounded-2xl shadow-soft border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                    <i class="fa-solid fa-arrow-up"></i>
                </div>
                <span class="text-sm font-medium text-slate-500">Total Expense</span>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">
                Rp {{ number_format($totalExpense, 0, ',', '.') }}
            </h3>
        </div>
    </div>

    <!-- Balance -->
    <div class="bg-gradient-to-br from-indigo-600 to-violet-600 p-6 rounded-2xl shadow-glow text-white relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute right-0 bottom-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-10 -mb-10"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2 opacity-90">
                <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <span class="text-sm font-medium">Current Balance</span>
            </div>
            <h3 class="text-3xl font-bold">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </h3>
        </div>
    </div>
</div>
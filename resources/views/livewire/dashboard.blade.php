<div>
    <!-- MAIN CONTENT WRAPPER -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">

        <!-- ROW 1: CARDS SUMMARY -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- INCOME CARD -->
            <div
                class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div
                    class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/20 rounded-bl-full -mr-4 -mt-4 group-hover:scale-110 transition">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <div
                            class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                            <i class="fa-solid fa-arrow-down"></i>
                        </div>
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Income</span>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white">
                        Rp {{ number_format($this->totalIncome ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <!-- EXPENSE CARD -->
            <div
                class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div
                    class="absolute right-0 top-0 w-24 h-24 bg-red-50 dark:bg-red-900/20 rounded-bl-full -mr-4 -mt-4 group-hover:scale-110 transition">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <div
                            class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-400 flex items-center justify-center">
                            <i class="fa-solid fa-arrow-up"></i>
                        </div>
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Expense</span>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white">
                        Rp {{ number_format($this->totalExpense ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <!-- BALANCE CARD -->
            <div
                class="bg-gradient-to-br from-blue-400 to-blue-600 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="absolute right-0 bottom-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-10 -mb-10"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2 opacity-90">
                        <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <span class="text-sm font-medium">Current Balance</span>
                    </div>
                    <h3 class="text-3xl font-bold">
                        Rp {{ number_format($this->balance ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- MAIN GRID (CHART & FORM) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT: CHART & LIST (Lebar 2/3) -->
            <div class="lg:col-span-2 space-y-8">

                <!-- CHART COMPONENT (Panggil Livewire Terpisah) -->
                <livewire:finance-chart />

                <!-- TRANSACTION LIST -->
                <livewire:transaction-list />
            </div>

            <!-- RIGHT: FORM (Lebar 1/3) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <livewire:transaction-form />
                </div>
            </div>
        </div>

    </main>

    <!-- SCRIPT KOSONG (Logic Chart udah pindah ke finance-chart.blade.php) -->
    {{-- @push('scripts')
    @endpush --}}
</div>

<!-- Wrapper Modal (Hidden by default, controlled by parent logic or just standalone) -->
<div x-data="{ showModal: true }" @keydown.escape.window="showModal = false" class="relative z-50">

    <!-- Modal Overlay -->
    <div x-show="showModal" x-transition.opacity.duration.300ms
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

    <!-- Modal Container -->
    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

            <div
                class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-5xl">

                <!-- Modal Header -->
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-6 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-700/30">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Transaction History</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Search detailed financial records</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span
                            class="px-4 py-2 rounded-full bg-slate-200 dark:bg-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300">
                            {{ count($this->transactions) }} Records
                        </span>
                        <button x-on:click="showModal = false"
                            class="w-10 h-10 rounded-xl bg-white dark:bg-slate-600 text-slate-500 dark:text-slate-200 hover:text-red-500 dark:hover:text-red-400 border border-slate-200 dark:border-slate-500 flex items-center justify-center transition-colors shadow-sm">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">

                    <!-- Filter Panel -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 mb-6 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-primary rounded-l-2xl"></div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Date -->
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Specific
                                    Date</label>
                                <input type="date" wire:model.live="filters.date"
                                    class="w-full bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent block w-full p-3 outline-none transition-shadow">
                            </div>

                            <!-- Month -->
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Month</label>
                                <div class="relative">
                                    <select wire:model.live="filters.month"
                                        class="w-full bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent block w-full p-3 outline-none cursor-pointer appearance-none">
                                        <option value="">All Months</option>
                                        <option value="0">January</option>
                                        <option value="1">February</option>
                                        <option value="2">March</option>
                                        <option value="3">April</option>
                                        <option value="4">May</option>
                                        <option value="5">June</option>
                                        <option value="6">July</option>
                                        <option value="7">August</option>
                                        <option value="8">September</option>
                                        <option value="9">October</option>
                                        <option value="10">November</option>
                                        <option value="11">December</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Year -->
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Year</label>
                                <input type="number" wire:model.live="filters.year" placeholder="e.g. 2026"
                                    class="w-full bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent block w-full p-3 outline-none transition-shadow">
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700 flex justify-end">
                            <button wire:click="resetFilters"
                                class="text-xs font-bold text-primary hover:text-primaryDark transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-rotate-right"></i> Reset Filters
                            </button>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Income -->
                        <div
                            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 relative overflow-hidden">
                            <div class="flex items-start justify-between relative z-10">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Income</p>
                                    <h3 class="text-xl font-bold text-emerald-600 dark:text-emerald-400">
                                        Rp {{ number_format($this->totals['income'], 0, ',', '.') }}
                                    </h3>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                    <i class="fa-solid fa-wallet"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Expense -->
                        <div
                            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 relative overflow-hidden">
                            <div class="flex items-start justify-between relative z-10">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Expense</p>
                                    <h3 class="text-xl font-bold text-red-500 dark:text-red-400">
                                        Rp {{ number_format($this->totals['expense'], 0, ',', '.') }}
                                    </h3>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-500 dark:text-red-400">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Balance -->
                        <div
                            class="bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-700 dark:to-slate-600 rounded-2xl shadow-glow p-5 relative overflow-hidden">
                            <div class="flex items-start justify-between relative z-10">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Balance</p>
                                    <h3 class="text-xl font-bold text-white">
                                        Rp
                                        {{ number_format($this->totals['income'] - $this->totals['expense'], 0, ',', '.') }}
                                    </h3>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white">
                                    <i class="fa-solid fa-scale-balanced"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- History Table -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider bg-slate-50/50 dark:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700">
                                        <th class="px-6 py-4">Transaction</th>
                                        <th class="px-6 py-4">Category</th>
                                        <th class="px-6 py-4">Note</th>
                                        <th class="px-6 py-4 text-right">Amount</th>
                                        <th class="px-6 py-4 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="text-sm text-slate-600 dark:text-slate-300 divide-y divide-slate-50 dark:divide-slate-700/50">
                                    @forelse($this->transactions as $t)
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-10 h-10 flex-shrink-0 rounded-xl {{ $t->type == 'income' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-500' }} dark:{{ $t->type == 'income' ? 'bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-900/30 dark:text-red-400' }} flex items-center justify-center shadow-sm">
                                                        <i
                                                            class="fa-solid {{ $t->type == 'income' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} text-sm"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div
                                                            class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                                            {{ $t->date }}</div>
                                                        <div class="text-xs text-slate-400">{{ ucfirst($t->type) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                                    {{ $t->category }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400 text-sm">
                                                {{ $t->note ?? '-' }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-right text-base font-bold {{ $t->type == 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500 dark:text-red-400' }}">
                                                {{ $t->type == 'income' ? '+' : '-' }} Rp
                                                {{ number_format($t->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <button wire:click="delete({{ $t->id }})"
                                                    wire:confirm="Are you sure you want to delete this transaction?"
                                                    class="w-8 h-8 rounded-lg bg-transparent text-slate-400 hover:text-red-500 dark:text-slate-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all flex items-center justify-center mx-auto">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                class="py-16 flex flex-col items-center justify-center text-center">
                                                <div
                                                    class="w-20 h-20 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                                                    <i
                                                        class="fa-solid fa-magnifying-glass text-slate-400 dark:text-slate-500 text-3xl"></i>
                                                </div>
                                                <h3 class="font-bold text-xl text-slate-700 dark:text-slate-200">No
                                                    records found</h3>
                                                <p class="text-sm text-slate-400 mt-2">Try adjusting your filters.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

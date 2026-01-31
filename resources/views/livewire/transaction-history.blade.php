<div x-data="{ showModal: true }" 
     @keydown.escape.window="showModal = false" 
     x-show="showModal"
     class="relative z-50">

    <div x-show="showModal" 
         x-transition.opacity.duration.300ms
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

            <div x-show="showModal"
                x-transition:enter="ease-out duration-300" 
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-5xl">

                <div wire:loading flex class="absolute inset-0 z-50 bg-white/50 dark:bg-slate-800/50 backdrop-blur-[1px] items-center justify-center">
                    <div class="flex flex-col items-center">
                        <i class="fa-solid fa-circle-notch animate-spin text-3xl text-primary"></i>
                        <span class="text-xs font-medium mt-2 text-slate-500">Updating records...</span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-6 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-700/30">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Transaction History</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Search detailed financial records</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="px-4 py-2 rounded-full bg-slate-200 dark:bg-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300">
                            {{ count($this->transactions) }} Records
                        </span>
                        <button @click="showModal = false"
                            class="w-10 h-10 rounded-xl bg-white dark:bg-slate-600 text-slate-500 dark:text-slate-200 hover:text-red-500 border border-slate-200 dark:border-slate-500 flex items-center justify-center transition-all shadow-sm">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="p-6">

                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 mb-6 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500 rounded-l-2xl"></div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Specific Date</label>
                                <input type="date" wire:model.live="filters.date"
                                    class="w-full bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 outline-none p-3 transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Month</label>
                                <div class="relative">
                                    <select wire:model.live="filters.month"
                                        class="w-full bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 p-3 outline-none cursor-pointer appearance-none">
                                        <option value="">All Months</option>
                                        @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Year</label>
                                <input type="number" wire:model.live.debounce.500ms="filters.year" placeholder="e.g. 2026"
                                    class="w-full bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 p-3 outline-none transition-all">
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700 flex justify-end">
                            <button wire:click="resetFilters" wire:loading.attr="disabled"
                                class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-rotate-right" wire:loading.class="animate-spin"></i> Reset Filters
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        @php
                            $income = $this->totals['income'] ?? 0;
                            $expense = $this->totals['expense'] ?? 0;
                            $balance = $income - $expense;
                        @endphp
                        
                        <div class="bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800/50 rounded-2xl p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-emerald-600/70 dark:text-emerald-400/70 uppercase">Total Income</p>
                                    <h3 class="text-xl font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($income, 0, ',', '.') }}</h3>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none">
                                    <i class="fa-solid fa-arrow-up-long"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-red-50/50 dark:bg-red-900/10 border border-red-100 dark:border-red-800/50 rounded-2xl p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-red-600/70 dark:text-red-400/70 uppercase">Total Expense</p>
                                    <h3 class="text-xl font-bold text-red-500 dark:text-red-400">Rp {{ number_format($expense, 0, ',', '.') }}</h3>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-red-500 text-white flex items-center justify-center shadow-lg shadow-red-200 dark:shadow-none">
                                    <i class="fa-solid fa-arrow-down-long"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-900 dark:bg-slate-700 border border-slate-800 rounded-2xl p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Net Balance</p>
                                    <h3 class="text-xl font-bold text-white">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-white/10 text-white flex items-center justify-center">
                                    <i class="fa-solid fa-scale-balanced"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-xs font-semibold text-slate-400 uppercase tracking-wider bg-slate-50/50 dark:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700">
                                        <th class="px-6 py-4">Transaction</th>
                                        <th class="px-6 py-4">Category</th>
                                        <th class="px-6 py-4">Note</th>
                                        <th class="px-6 py-4 text-right">Amount</th>
                                        <th class="px-6 py-4 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-slate-50 dark:divide-slate-700/50">
                                    @forelse($this->transactions as $t)
                                        <tr wire:key="tr-{{ $t->id }}" class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="w-9 h-9 flex-shrink-0 rounded-lg {{ $t->type == 'income' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-500 dark:bg-red-900/30 dark:text-red-400' }} flex items-center justify-center">
                                                        <i class="fa-solid {{ $t->type == 'income' ? 'fa-plus' : 'fa-minus' }} text-xs"></i>
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</div>
                                                        <div class="text-[10px] uppercase font-bold tracking-tight text-slate-400">{{ $t->type }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                                    {{ $t->category->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400 text-xs italic">
                                                {{ $t->note ?: 'No notes' }}
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold {{ $t->type == 'income' ? 'text-emerald-600' : 'text-red-500' }}">
                                                {{ $t->type == 'income' ? '+' : '-' }} {{ number_format($t->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <button wire:click="delete({{ $t->id }})" 
                                                        wire:confirm="Hapus transaksi ini?"
                                                        class="w-8 h-8 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all flex items-center justify-center mx-auto">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-20 text-center">
                                                <div class="flex flex-col items-center justify-center opacity-50">
                                                    <i class="fa-solid fa-folder-open text-4xl mb-3"></i>
                                                    <p class="font-bold text-slate-500">No records found</p>
                                                    <p class="text-xs text-slate-400">Try changing your filters</p>
                                                </div>
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
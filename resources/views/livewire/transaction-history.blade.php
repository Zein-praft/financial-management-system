{{-- x-data: Gabungan logic Modal Tampil (showModal) + logic Modal Hapus (confirmDeleteModal) --}}
<div x-data="{
    showModal: true,
    confirmDeleteModal: false,
    transactionToDelete: null
}" x-show="showModal" @keydown.escape.window="showModal = false" class="relative z-50">

    <!-- BACKDROP -->
    <div x-show="showModal" x-transition.opacity.duration.300ms class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm">
    </div>

    <!-- MODAL WRAPPER -->
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 sm:p-0">

            <div x-show="showModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="relative w-full max-w-5xl rounded-[2.5rem] bg-white dark:bg-slate-900 shadow-2xl border border-white/50 dark:border-white/5 overflow-hidden">

                <!-- HEADER -->
                <div
                    class="flex justify-between items-center p-8 border-b border-slate-100 dark:border-slate-800 bg-gradient-to-r from-blue-50 to-white dark:from-indigo-900/20 dark:to-slate-900">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-800 dark:text-white font-heading">Transaction History
                        </h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Search detailed financial records</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span
                            class="px-4 py-2 rounded-full bg-slate-200 dark:bg-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300">
                            {{ count($this->transactions) }} Records
                        </span>

                        <button @click="showModal = false"
                            class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all shadow-sm">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- BODY -->
                <div class="p-8">

                    <!-- FILTER SECTION (STYLE LOGIN + TOMBOL APPLY) -->
                    <div
                        class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 rounded-[2.5rem] p-8 mb-8 relative overflow-hidden shadow-sm">
                        {{-- Dekorasi Garis Biru --}}
                        <div
                            class="absolute left-0 top-0 h-full w-1.5 bg-gradient-to-b from-blue-400 to-indigo-600 rounded-l-[2.5rem]">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <!-- Specific Date -->
                            <div class="space-y-2">
                                <label
                                    class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Specific
                                    Date</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i
                                            class="fa-regular fa-calendar text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                    </div>
                                    <input type="date" wire:model.defer="filters.date"
                                        class="w-full pl-11 pr-4 py-4 rounded-2xl border border-blue-100 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 text-slate-800 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all duration-300 font-body">
                                </div>
                            </div>

                            <!-- Month -->
                            <div class="space-y-2">
                                <label
                                    class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Month</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i
                                            class="fa-solid fa-calendar-days text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                    </div>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                    <select wire:model.defer="filters.month"
                                        class="w-full pl-11 pr-10 py-4 rounded-2xl border border-blue-100 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 text-slate-800 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all duration-300 font-body appearance-none cursor-pointer">
                                        <option value="">All Months</option>
                                        @foreach (range(1, 12) as $m)
                                            <option value="{{ $m }}">
                                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Year -->
                            <div class="space-y-2">
                                <label
                                    class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Year</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i
                                            class="fa-solid fa-calendar-check text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                    </div>
                                    <input type="number" wire:model.defer="filters.year" placeholder="2026"
                                        class="w-full pl-11 pr-4 py-4 rounded-2xl border border-blue-100 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 text-slate-800 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all duration-300 font-body">
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700 flex justify-between items-center flex-wrap gap-4">
                            <!-- Info Kecil -->
                            <p class="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                <i class="fa-solid fa-info-circle"></i> Click "Apply" to update data
                            </p>

                            <!-- Tombol Reset & Apply -->
                            <div class="flex items-center gap-3">
                                <button wire:click="resetFilters"
                                    class="text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 flex items-center gap-2 transition-colors font-heading">
                                    <i class="fa-solid fa-rotate-right"></i> Reset Filters
                                </button>

                                {{-- TOMBOL APPLY FILTER (UPDATED LOADING UX) --}}
                                <button wire:click="applyFilters" wire:loading.attr="disabled"
                                    class="group relative overflow-hidden bg-gradient-to-r from-blue-400 to-indigo-600 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 font-heading flex items-center gap-2 text-sm">
                                    <span class="relative z-10" wire:loading.remove>Apply Filter</span>
                                    <span class="relative z-10 hidden" wire:loading>Processing...</span>
                                    <i class="fa-solid fa-filter relative z-10 text-xs"></i>
                                    <div
                                        class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/20">
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- SUMMARY CARDS (STYLE DASHBOARD) -->
                    @php
                        $income = $this->totals['income'] ?? 0;
                        $expense = $this->totals['expense'] ?? 0;
                        $balance = $income - $expense;
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Income -->
                        <div
                            class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-white/5 hover:shadow-md transition-shadow">
                            <p
                                class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">
                                Total Income</p>
                            <h3 class="text-2xl font-bold text-slate-800 dark:text-white font-heading">
                                Rp {{ number_format($income, 0, ',', '.') }}
                            </h3>
                        </div>

                        <!-- Expense -->
                        <div
                            class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-white/5 hover:shadow-md transition-shadow">
                            <p class="text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-wider mb-1">
                                Total Expense</p>
                            <h3 class="text-2xl font-bold text-slate-800 dark:text-white font-heading">
                                Rp {{ number_format($expense, 0, ',', '.') }}
                            </h3>
                        </div>

                        <!-- Balance (Gradasi Biru) -->
                        <div
                            class="relative overflow-hidden bg-gradient-to-br from-blue-400 to-indigo-600 p-6 rounded-[2rem] shadow-xl shadow-blue-500/20 text-white border border-white/10">
                            <div class="absolute inset-0 bg-grid-dots opacity-20 pointer-events-none"></div>
                            <div class="relative z-10">
                                <p class="text-xs font-bold text-white/80 uppercase tracking-wider mb-1">Net Balance</p>
                                <h3 class="text-2xl font-bold text-white font-heading">
                                    Rp {{ number_format($balance, 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- TABLE (UPDATED STYLE) -->
                    <div
                        class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 rounded-[2rem] overflow-hidden shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead
                                    class="bg-slate-50/50 dark:bg-slate-800/50 text-xs uppercase text-slate-400 font-bold border-b border-slate-100 dark:border-slate-700">
                                    <tr>
                                        <th class="px-6 py-4 text-left">Transaction</th>
                                        <th class="px-6 py-4 text-left">Category</th>
                                        <th class="px-6 py-4 text-left">Note</th>
                                        <th class="px-6 py-4 text-right">Amount</th>
                                        <th class="px-6 py-4 text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody
                                    class="min-h-[260px] text-sm text-slate-600 dark:text-slate-300 divide-y divide-slate-50 dark:divide-slate-700/50">
                                    @forelse($this->transactions as $t)
                                        <?php
                                        $isIncome = $t->type == 'income';
                                        $amountColor = $isIncome ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500 dark:text-red-400';
                                        ?>
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group">
                                            <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-200">
                                                {{ \Carbon\Carbon::parse($t->date)->isoFormat('DD MMM YYYY') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                                    <i class="fa-solid fa-tag text-[10px]"></i> {{ $t->category->name }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 text-xs italic text-slate-400 dark:text-slate-500 max-w-[200px] truncate">
                                                {{ $t->note ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold {{ $amountColor }} font-body">
                                                {{ $isIncome ? '+' : '-' }} Rp
                                                {{ number_format($t->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                {{-- BUTTON HAPUS: Trigger AlpineJS --}}
                                                <button
                                                    @click="transactionToDelete = {{ $t->id }}; confirmDeleteModal = true"
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors mx-auto">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-20 text-center opacity-60">
                                                <div class="flex flex-col items-center">
                                                    <i
                                                        class="fa-solid fa-folder-open text-4xl mb-4 text-slate-300 dark:text-slate-600"></i>
                                                    <p class="font-bold text-slate-400">No records found</p>
                                                    <p class="text-xs mt-1">Try changing filters above.</p>
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

    {{-- MODAL KONFIRMASI HAPUS (ALPINE.JS) --}}
    <div x-show="confirmDeleteModal" x-transition.opacity.duration.200ms
        class="fixed inset-0 z-[80] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4"
        style="display: none;">
        <div x-transition.scale.duration.200ms
            class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl w-full max-w-sm p-6 border border-slate-100 dark:border-white/5 relative overflow-hidden">
            {{-- Header Danger Gradient --}}
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-500 to-pink-600"></div>

            <div class="text-center">
                <div
                    class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-4 text-red-500 dark:text-red-400">
                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                </div>

                <h3 class="text-xl font-bold text-slate-800 dark:text-white font-heading mb-2">Delete Transaction?</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                    Are you sure you want to remove this transaction? This action cannot be undone.
                </p>
            </div>

            <div class="flex gap-3 mt-8">
                <button @click="confirmDeleteModal = false; transactionToDelete = null"
                    class="flex-1 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-heading text-sm">
                    Cancel
                </button>

                <button
                    @click="$wire.delete(transactionToDelete); confirmDeleteModal = false; transactionToDelete = null;"
                    class="flex-1 bg-gradient-to-r from-red-500 to-pink-600 text-white font-bold py-3 rounded-2xl shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 font-heading text-sm">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

</div>

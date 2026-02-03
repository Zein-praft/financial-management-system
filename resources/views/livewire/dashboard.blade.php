<!-- Wrapper Alpine.js -->
<div x-data="{ showHistory: false }" x-cloak @open-history-modal.window="showHistory = true"
    @refreshTransaction.window="setTimeout(() => window.scrollTo({ top: 0, behavior: 'smooth' }), 100)">

    <!-- MAIN CONTENT -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">

        <!-- SUMMARY CARDS (UPDATED) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- INCOME -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-white/5 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <i class="fa-solid fa-arrow-down text-sm"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Total
                            Income</span>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white font-heading tracking-tight">
                    Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                </h3>
            </div>

            <!-- EXPENSE -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-white/5 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                            <i class="fa-solid fa-arrow-up text-sm"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Total
                            Expense</span>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white font-heading tracking-tight">
                    Rp {{ number_format($totalExpense ?? 0, 0, ',', '.') }}
                </h3>
            </div>

            <!-- BALANCE -->
            <div
                class="relative overflow-hidden bg-gradient-to-br from-blue-400 to-indigo-600 p-6 rounded-[2rem] shadow-xl shadow-blue-500/20 text-white border border-white/10 transition-all duration-300 hover:shadow-blue-500/30">
                <div class="absolute inset-0 bg-grid-dots opacity-20 pointer-events-none"></div>
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>
                <div class="absolute top-10 -left-10 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 shadow-sm">
                                <i class="fa-solid fa-wallet text-lg"></i>
                            </div>
                            <span class="text-sm font-bold text-white/80 uppercase tracking-wide font-heading">Current
                                Balance</span>
                        </div>
                        <div class="p-2 rounded-full bg-white/10">
                            <i class="ph-fill ph-chart-line-up text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl md:text-4xl font-bold text-white font-heading tracking-tight drop-shadow-sm">
                        Rp {{ number_format($balance ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

        </div>

        <!-- MAIN GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT -->
            <div class="lg:col-span-2 space-y-8">
                <livewire:transaction-list />
                <livewire:bill-reminder />
            </div>

            <!-- RIGHT -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <livewire:transaction-form />
                </div>
            </div>

        </div>

    </main>

    <!-- ================= MODAL HISTORY (FIXED) ================= -->

    <div x-show="showHistory" wire:ignore.self
        class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4"
        @keydown.escape.window="showHistory = false" @click.self="showHistory = false" x-transition.opacity>

        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden border border-white/50 dark:border-white/5"
            @click.stop x-transition.scale>

            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-heading">Transaction History</h2>
                    <p class="text-sm text-slate-500">Search detailed financial records</p>
                </div>

                <button @click="showHistory = false"
                    class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- BODY (LAZY LOAD) -->
            <div class="flex-1 overflow-y-auto bg-white dark:bg-slate-900">
                <template x-if="showHistory">
                    @livewire('transaction-history', [], key('transaction-history-modal'))
                </template>
            </div>

        </div>
    </div>

</div>

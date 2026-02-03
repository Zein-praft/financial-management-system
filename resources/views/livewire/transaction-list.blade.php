<div x-data="{
    confirmDeleteModal: false,
    transactionToDelete: null
}"
    class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-white/5 overflow-hidden flex flex-col">

    <!-- HEADER (STYLE PREMIUM) -->
    <div
        class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50 flex-shrink-0">

        <!-- Kiri: Judul & Count -->
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white font-heading">Recent Transactions</h2>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                {{ $transactions->count() }} transactions found
            </p>
        </div>

        <!-- Kanan: TOMBOL TAMPILKAN SEMUA -->
        <button @click="$dispatch('open-history-modal')"
            class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-blue-500 dark:hover:border-blue-400 hover:text-blue-600 dark:hover:text-blue-400 transition-all shadow-sm group">
            <i class="fa-solid fa-list-ul group-hover:scale-110 transition-transform"></i>
            <span>View All</span>
        </button>
    </div>

    <!-- TABEL DENGAN SCROLL (STYLE CLEAN) -->
    <div class="overflow-auto max-h-[400px] relative">
        <table class="w-full text-left border-collapse">
            <thead>
                <!-- Sticky Top Header -->
                <tr
                    class="sticky top-0 z-10 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-100 dark:border-slate-700 bg-slate-50/95 dark:bg-slate-700/95 shadow-sm">
                    <th class="px-6 py-4">Transaction</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4 text-right">Amount</th>
                    <th class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-600 dark:text-slate-300 divide-y divide-slate-50 dark:divide-slate-700/50">
                @forelse($transactions as $transaction)
                    {{-- PHP Block Logic --}}
                    <?php
                    $isIncome = $transaction->type == 'income';
                    // Tentuin warna icon (Style Soft)
                    $iconBg = $isIncome ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-500';
                    $darkIconBg = $isIncome ? 'dark:bg-emerald-900/20 dark:text-emerald-400' : 'dark:bg-red-900/20 dark:text-red-400';
                    // Panggil fungsi helper getIcon dari PHP
                    $iconClass = $this->getIcon($transaction->category->name ?? '');
                    ?>

                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/50 group transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div
                                        class="h-10 w-10 rounded-full {{ $iconBg }} {{ $darkIconBg }} flex items-center justify-center border border-white/50 dark:border-slate-600">
                                        <i
                                            class="fa-solid {{ $isIncome ? 'fa-arrow-down' : 'fa-arrow-up' }} text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    {{-- 1. BOLD: NAMA KATEGORI --}}
                                    <div class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                        {{ $transaction->category->name }}
                                    </div>
                                    {{-- 2. TIPIS KECIL: NOTE --}}
                                    <div class="text-xs text-slate-400 dark:text-slate-500">
                                        {{ $transaction->note ?: '-' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300">
                                <i class="fa-solid {{ $iconClass }} text-[10px]"></i>
                                {{ $transaction->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400 dark:text-slate-500">
                            {{ \Carbon\Carbon::parse($transaction->date)->isoFormat('DD MMM YYYY') }}
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $isIncome ? 'text-emerald-600' : 'text-red-600 dark:text-red-400' }}">
                            {{ $isIncome ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            {{-- BUTTON HAPUS: Trigger AlpineJS --}}
                            <button @click="transactionToDelete = {{ $transaction->id }}; confirmDeleteModal = true"
                                class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-300 dark:text-slate-600 hover:text-red-500 dark:hover:text-red-400 transition-colors hover:bg-red-50 dark:hover:bg-red-900/20 opacity-0 group-hover:opacity-100">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400 dark:text-slate-500">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-receipt text-3xl mb-3 text-slate-300 dark:text-slate-600"></i>
                                <p class="font-bold text-slate-700 dark:text-slate-300">No transactions found.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ MODAL KONFIRMASI HAPUS (ALPINE.JS) --}}
    <div x-show="confirmDeleteModal" x-transition.opacity.duration.200ms
        class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4"
        style="display: none;">
        <div x-transition.scale.duration.200ms
            class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl w-full max-w-sm p-6 border border-slate-100 dark:border-white/5 relative overflow-hidden">
            {{-- Header Danger Gradient --}}
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-500 to-pink-600"></div>

            <div class="text-center">
                {{-- Icon Peringatan --}}
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
                {{-- Button Batal --}}
                <button @click="confirmDeleteModal = false; transactionToDelete = null"
                    class="flex-1 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-heading text-sm">
                    Cancel
                </button>

                {{-- Button Hapus (Trigger Livewire) --}}
                <button
                    @click="$wire.delete(transactionToDelete); confirmDeleteModal = false; transactionToDelete = null;"
                    class="flex-1 bg-gradient-to-r from-red-500 to-pink-600 text-white font-bold py-3 rounded-2xl shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 font-heading text-sm">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

</div>

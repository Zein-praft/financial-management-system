<div
    class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col">

    <!-- HEADER (Sudah ditambahin Tombol Tampilkan Semua) -->
    <div
        class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-700/30 flex-shrink-0">

        <!-- Kiri: Judul & Count -->
        <div>
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Transaction History</h2>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $transactions->count() }} transactions found
            </p>
        </div>

        <!-- Kanan: TOMBOL TAMPILKAN SEMUA -->
        <!-- Dispatch event ke dashboard.blade.php buat buka modal -->
        <button @click="$dispatch('open-history-modal')"
            class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-primary dark:hover:border-primary transition-all shadow-sm">
            <i class="fa-solid fa-list-ul"></i>
            <span>Tampilkan Semua</span>
        </button>
    </div>

    <!-- TABEL DENGAN SCROLL (LIMIT TINGGI 5 BARIS) -->
    <!-- max-h-[400px] mengatur tinggi scroll -->
    <!-- overflow-auto mengaktifkan scroll vertikal -->
    <div class="overflow-auto max-h-[400px] relative">
        <table class="w-full text-left border-collapse">
            <thead>
                <!-- sticky top-0 biar header tetap terlihat pas scroll -->
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
                    // Tentuin warna icon
                    $iconBg = $isIncome ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-500';
                    $darkIconBg = $isIncome ? 'dark:bg-emerald-900/50 dark:text-emerald-400' : 'dark:bg-red-900/50 dark:text-red-400';
                    // Panggil fungsi helper getIcon dari PHP
                    $iconClass = $this->getIcon($transaction->category->name ?? '');
                    ?>

                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/50 group transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div
                                        class="h-10 w-10 rounded-full {{ $iconBg }} {{ $darkIconBg }} flex items-center justify-center">
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
                                class="px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-300">
                                <i class="fa-solid {{ $iconClass }} mr-1"></i> {{ $transaction->category->name }}
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
                            <button wire:click="delete({{ $transaction->id }})"
                                wire:confirm="Yakin ingin menghapus transaksi ini?"
                                class="text-slate-300 dark:text-slate-600 hover:text-red-500 dark:hover:text-red-400 transition-colors p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400 dark:text-slate-500">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-receipt text-3xl mb-3 text-slate-300 dark:text-slate-600"></i>
                                <p>No transactions found.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

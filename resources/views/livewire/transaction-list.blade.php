<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-700/30">
        <div>
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Transaction History</h2>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $transactions->count() }} transactions found</p>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-100 dark:border-slate-700">
                    <th class="px-6 py-4">Transaction</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4 text-right">Amount</th>
                    <th class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-600 dark:text-slate-300 divide-y divide-slate-50 dark:divide-slate-700/50">
                @forelse($transactions as $transaction)
                    <?php 
                        $isIncome = $transaction->type == 'income';
                        $iconBg = $isIncome ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-500';
                        $darkIconBg = $isIncome ? 'dark:bg-emerald-900/50 dark:text-emerald-400' : 'dark:bg-red-900/50 dark:text-red-400';
                        $iconClass = $this->getIcon($transaction->category->name ?? '');
                    ?>
                    
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/50 group transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full {{ $iconBg }} {{ $darkIconBg }} flex items-center justify-center">
                                        <i class="fa-solid {{ $isIncome ? 'fa-arrow-down' : 'fa-arrow-up' }} text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $transaction->note ?: $transaction->category->name }}</div>
                                    <div class="text-xs text-slate-400 dark:text-slate-500">{{ $transaction->category->name ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-300">
                                <i class="fa-solid {{ $iconClass }} mr-1"></i> {{ $transaction->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400 dark:text-slate-500">
                            {{ \Carbon\Carbon::parse($transaction->date)->isoFormat('DD MMM YYYY') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $isIncome ? 'text-emerald-600' : 'text-slate-800 dark:text-slate-200' }}">
                            {{ $isIncome ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button wire:click="delete({{ $transaction->id }})" class="text-slate-300 dark:text-slate-600 hover:text-red-500 dark:hover:text-red-400 transition-colors p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20" onclick="if(!confirm('Yakin ingin menghapus?')) return false;">
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
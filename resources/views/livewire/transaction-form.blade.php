<div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl border border-slate-100 dark:border-white/5 p-6">
    <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
        <i class="fa-solid fa-circle-plus text-blue-500"></i> Add Transaction
    </h2>

    {{-- NOTIFIKASI SUKSES --}}
    @if ($message)
        <div
            class="mb-4 p-3 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg text-sm border border-green-200 dark:border-green-800 flex justify-between items-center animate-pulse">
            <span>{{ $message }}</span>
            <button wire:click="$set('message', '')"
                class="text-green-800 dark:text-green-600 hover:text-green-900 dark:hover:text-green-500 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif

    <form wire:submit="save" class="space-y-5">

        <!-- Type Toggle (Clean Style) -->
        <div class="grid grid-cols-2 gap-3 p-1 bg-slate-100 dark:bg-slate-700 rounded-xl">
            <label class="cursor-pointer relative">
                <input type="radio" name="type" wire:model="type" value="income" class="peer sr-only">
                <div
                    class="text-center py-2 rounded-lg text-sm font-medium transition-all peer-checked:bg-white peer-checked:text-emerald-600 peer-checked:shadow-sm dark:peer-checked:bg-slate-600 dark:peer-checked:text-emerald-400">
                    Income
                </div>
                <div
                    class="absolute inset-0 ring-1 ring-inset ring-slate-900/10 dark:ring-slate-600 rounded-lg peer-checked:ring-emerald-500 dark:peer-checked:ring-emerald-400">
                </div>
            </label>
            <label class="cursor-pointer relative">
                <input type="radio" name="type" wire:model="type" value="expense" class="peer sr-only">
                <div
                    class="text-center py-2 rounded-lg text-sm font-medium transition-all peer-checked:bg-white peer-checked:text-red-500 peer-checked:shadow-sm dark:peer-checked:bg-slate-600 dark:peer-checked:text-red-400">
                    Expense
                </div>
                <div
                    class="absolute inset-0 ring-1 ring-inset ring-slate-900/10 dark:ring-slate-600 rounded-lg peer-checked:ring-red-500 dark:peer-checked:ring-red-400">
                </div>
            </label>
        </div>

        <!-- Date (Premium Input Style) -->
        <div class="space-y-2">
            <label
                class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Date</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i
                        class="fa-regular fa-calendar text-slate-400 group-focus-within:text-blue-500 transition-colors duration-300"></i>
                </div>
                <input type="date" wire:model="date"
                    class="w-full bg-white/50 dark:bg-slate-800/50 border border-blue-100 dark:border-slate-700 text-slate-800 dark:text-white text-sm rounded-2xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all duration-300 font-body pl-11 pr-4 py-4"
                    required>
            </div>
        </div>

        <!-- Amount (Premium Input Style) -->
        <div class="space-y-2">
            <label
                class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Amount</label>
            <div class="relative group">
                <div
                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 dark:text-slate-400 font-bold text-sm">
                    Rp
                </div>
                <input type="number" wire:model="amount" step="0.01" min="0" placeholder="0.00"
                    class="w-full bg-white/50 dark:bg-slate-800/50 border border-blue-100 dark:border-slate-700 text-slate-800 dark:text-white text-sm rounded-2xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all duration-300 font-body font-medium pl-12 pr-4 py-4"
                    required>
                @error('amount')
                    <span class="text-xs text-red-500 mt-1 ml-1 flex items-center gap-1"><i
                            class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Category (Premium Input Style) -->
        <div class="space-y-2">
            <label
                class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Category</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i
                        class="fa-solid fa-tag text-slate-400 group-focus-within:text-blue-500 transition-colors duration-300"></i>
                </div>
                <input type="text" wire:model="category_name" placeholder="Type or select category..."
                    list="category-list"
                    class="w-full bg-white/50 dark:bg-slate-800/50 border border-blue-100 dark:border-slate-700 text-slate-800 dark:text-white text-sm rounded-2xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all duration-300 font-body pl-11 pr-4 py-4 appearance-none cursor-text"
                    required>

                <!-- Datalist -->
                <datalist id="category-list">
                    @foreach ($categories as $category)
                        <option value="{{ $category->name }}">
                    @endforeach
                </datalist>
            </div>
            @error('category_name')
                <span class="text-xs text-red-500 mt-1 ml-1 flex items-center gap-1"><i
                        class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</span>
            @enderror
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">* Type a new category or select from list.</p>
        </div>

        <!-- Note (Premium Input Style) -->
        <div class="space-y-2">
            <label
                class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Note</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i
                        class="fa-regular fa-pen-to-square text-slate-400 group-focus-within:text-blue-500 transition-colors duration-300"></i>
                </div>
                <input type="text" wire:model="note" placeholder="Short description..."
                    class="w-full bg-white/50 dark:bg-slate-800/50 border border-blue-100 dark:border-slate-700 text-slate-800 dark:text-white text-sm rounded-2xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all duration-300 font-body pl-11 pr-4 py-4">
            </div>
        </div>

        <!-- Button Save (Premium Gradient) -->
        <button type="submit"
            class="group relative overflow-hidden w-full bg-gradient-to-r from-blue-400 to-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-1 active:scale-95 transition-all duration-300 mt-2">
            <span class="relative z-10 flex items-center justify-center gap-2 text-lg">
                Save Transaction
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </span>
            <div
                class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-transform duration-300 group-hover:scale-100 group-hover:bg-white/20">
            </div>
        </button>
    </form>
</div>

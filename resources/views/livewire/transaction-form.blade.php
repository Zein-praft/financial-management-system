<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 p-6">
    <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
        <i class="fa-solid fa-circle-plus text-blue-500"></i> Add Transaction
    </h2>
    
    @if(session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm border border-green-200">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-5">
        <!-- Type Toggle -->
        <div class="grid grid-cols-2 gap-3 p-1 bg-slate-100 dark:bg-slate-700 rounded-xl">
            <label class="cursor-pointer relative">
                <input type="radio" name="type" wire:model="type" value="income" class="peer sr-only">
                <div class="text-center py-2 rounded-lg text-sm font-medium transition-all peer-checked:bg-white peer-checked:text-blue-600 peer-checked:shadow-sm dark:peer-checked:bg-slate-600 dark:peer-checked:text-blue-400">
                    Income
                </div>
                <div class="absolute inset-0 ring-1 ring-inset ring-slate-900/10 dark:ring-slate-600 rounded-lg peer-checked:ring-blue-500 dark:peer-checked:ring-blue-400"></div>
            </label>
            <label class="cursor-pointer relative">
                <input type="radio" name="type" wire:model="type" value="expense" class="peer sr-only">
                <div class="text-center py-2 rounded-lg text-sm font-medium transition-all peer-checked:bg-white peer-checked:text-red-500 peer-checked:shadow-sm dark:peer-checked:bg-slate-600 dark:peer-checked:text-red-400">
                    Expense
                </div>
                <div class="absolute inset-0 ring-1 ring-inset ring-slate-900/10 dark:ring-slate-600 rounded-lg peer-checked:ring-red-500 dark:peer-checked:ring-red-400"></div>
            </label>
        </div>

        <!-- Date -->
        <div class="relative">
            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase mb-1.5 ml-1">Date</label>
            <div class="relative">
                <input type="date" wire:model="date" class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-full pl-10 p-3 outline-none transition-shadow" required>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 transition-colors">
                    <i class="fa-regular fa-calendar"></i>
                </div>
            </div>
        </div>

        <!-- Amount -->
        <div class="relative">
            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase mb-1.5 ml-1">Amount</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500 dark:text-slate-400 font-bold text-sm">Rp</div>
                <input type="number" wire:model="amount" step="0.01" min="0" placeholder="0.00" class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-full pl-10 p-3 outline-none transition-shadow font-medium" required>
                @error('amount') <span class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- CATEGORY (CUSTOM INPUT) -->
        <div class="relative">
            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase mb-1.5 ml-1">Category</label>
            <div class="relative">
                <!-- Ubah dari select menjadi input text -->
                <input type="text" wire:model="category_name" placeholder="Type or select category..." list="category-list" class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-full pl-10 p-3 outline-none appearance-none cursor-text" required>
                
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 transition-colors">
                    <i class="fa-solid fa-tag"></i>
                </div>
                
                <!-- Datalist untuk autocomplete kategori yang sudah ada -->
                <datalist id="category-list">
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}">
                    @endforeach
                </datalist>
            </div>
            @error('category_name') <span class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</span> @enderror
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">* Ketik nama kategori baru atau pilih dari yang ada.</p>
        </div>

        <!-- Note -->
        <div class="relative">
            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase mb-1.5 ml-1">Note</label>
            <div class="relative">
                <input type="text" wire:model="note" placeholder="Short description..." class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-full pl-10 p-3 outline-none transition-shadow">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 transition-colors">
                    <i class="fa-regular fa-pen-to-square"></i>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-slate-200 dark:bg-blue-600 dark:shadow-blue-500/30 hover:bg-slate-800 dark:hover:bg-blue-700 active:scale-95 transition-all flex justify-center items-center gap-2 mt-2 group">
            <span>Save Transaction</span>
            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
        </button>
    </form>
</div>
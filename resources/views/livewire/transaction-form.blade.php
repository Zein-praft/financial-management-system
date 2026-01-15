<div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
        <i class="fa-solid fa-circle-plus text-primary"></i> Add Transaction
    </h2>
    
    @if(session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm border border-green-200">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-5">
        <!-- Type Toggle -->
        <div class="grid grid-cols-2 gap-3 p-1 bg-slate-100 rounded-xl">
            <label class="cursor-pointer relative">
                <input type="radio" name="type" wire:model="type" value="income" class="peer sr-only">
                <div class="text-center py-2 rounded-lg text-sm font-medium transition-all peer-checked:bg-white peer-checked:text-emerald-600 peer-checked:shadow-sm">
                    Income
                </div>
                <div class="absolute inset-0 ring-1 ring-inset ring-slate-900/10 rounded-lg peer-checked:ring-emerald-500"></div>
            </label>
            <label class="cursor-pointer relative">
                <input type="radio" name="type" wire:model="type" value="expense" class="peer sr-only">
                <div class="text-center py-2 rounded-lg text-sm font-medium transition-all peer-checked:bg-white peer-checked:text-red-500 peer-checked:shadow-sm">
                    Expense
                </div>
                <div class="absolute inset-0 ring-1 ring-inset ring-slate-900/10 rounded-lg peer-checked:ring-red-500"></div>
            </label>
        </div>

        <!-- Date -->
        <div class="relative">
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5 ml-1">Date</label>
            <div class="relative">
                <input type="date" wire:model="date" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent block w-full pl-10 p-3 outline-none transition-shadow" required>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none input-icon text-slate-400 transition-colors">
                    <i class="fa-regular fa-calendar"></i>
                </div>
            </div>
        </div>

        <!-- Amount -->
        <div class="relative">
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5 ml-1">Amount</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500 font-bold text-sm">Rp</div>
                <input type="number" wire:model="amount" step="0.01" min="0" placeholder="0.00" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent block w-full pl-10 p-3 outline-none transition-shadow font-medium" required>
                @error('amount') <span class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Category -->
        <div class="relative">
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5 ml-1">Category</label>
            <div class="relative">
                <select wire:model="category_id" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent block w-full pl-10 p-3 outline-none appearance-none cursor-pointer" required>
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none input-icon text-slate-400 transition-colors">
                    <i class="fa-solid fa-tag"></i>
                </div>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
                @error('category_id') <span class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Note -->
        <div class="relative">
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5 ml-1">Note</label>
            <div class="relative">
                <input type="text" wire:model="note" placeholder="Short description..." class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent block w-full pl-10 p-3 outline-none transition-shadow">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none input-icon text-slate-400 transition-colors">
                    <i class="fa-regular fa-pen-to-square"></i>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-slate-200 hover:bg-slate-800 active:scale-95 transition-all flex justify-center items-center gap-2 mt-2 group">
            <span>Save Transaction</span>
            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
        </button>
    </form>
</div>
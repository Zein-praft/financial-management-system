<div class="bg-white rounded-2xl shadow-blue-500/20 shadow-lg border border-slate-100 p-6 h-fit sticky top-24">
    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
        <i class="fa-solid fa-circle-plus text-primary"></i> Add Transaction
    </h2>

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg text-sm border border-green-200">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-5">

        {{-- TYPE --}}
        <div class="grid grid-cols-2 gap-3 p-1 bg-slate-100 rounded-xl">
            <label class="cursor-pointer">
                <input type="radio" wire:model.live="type" value="income" class="peer hidden">
                <div
                    class="text-center py-2 rounded-lg text-sm font-semibold text-slate-700
                    peer-checked:bg-white peer-checked:text-emerald-600 peer-checked:shadow">
                    Income
                </div>
            </label>

            <label class="cursor-pointer">
                <input type="radio" wire:model.live="type" value="expense" class="peer hidden">
                <div
                    class="text-center py-2 rounded-lg text-sm font-semibold text-slate-700
                    peer-checked:bg-white peer-checked:text-red-600 peer-checked:shadow">
                    Expense
                </div>
            </label>
        </div>

        {{-- DATE --}}
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Date</label>
            <input type="date" wire:model="date"
                class="w-full bg-white border border-slate-300 rounded-xl p-3 text-sm text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>

        {{-- AMOUNT --}}
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Amount</label>
            <input type="number" wire:model="amount"
                class="w-full bg-white border border-slate-300 rounded-xl p-3 text-sm text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition"
                placeholder="0">
        </div>

        {{-- CATEGORY --}}
        <div wire:key="category-{{ $type }}">
            <label class="block text-xs font-semibold text-slate-700 mb-1">Category</label>

            <select wire:model="category_id"
                class="w-full bg-white border border-slate-300 rounded-xl p-3 text-sm text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" class="text-slate-900">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- NOTE --}}
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Note</label>
            <input type="text" wire:model="note"
                class="w-full bg-white border border-slate-300 rounded-xl p-3 text-sm text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition"
                placeholder="Optional note...">
        </div>

        <!-- BUTTON SAVE (BIRU MUDA SEGAR) -->
        <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition duration-300 shadow-lg shadow-blue-500/30 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Save Transaction
        </button>
    </form>
</div>
<div x-data="{
    confirmDeleteModal: false,
    billToDelete: null
}">
    {{-- BAGIAN 1: UPCOMING BILLS CARD --}}
    <div
        class="bg-gradient-to-br from-blue-50 via-white to-white dark:from-slate-900 dark:via-slate-900 dark:to-slate-900 rounded-[2rem] shadow-xl border border-white/50 dark:border-white/5 overflow-hidden relative transition-all duration-300">

        {{-- Garis Dekorasi Kiri --}}
        <div
            class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-blue-400 to-indigo-600 rounded-r-lg shadow-[0_0_15px_rgba(99,102,241,0.3)]">
        </div>

        {{-- Header Card --}}
        <div
            class="p-6 border-b border-blue-100/50 dark:border-slate-800 flex justify-between items-center bg-gradient-to-r from-blue-50/50 to-white dark:from-indigo-900/20 dark:to-transparent">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white font-heading flex items-center gap-2">
                    <div
                        class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                        <i class="fa-solid fa-bell text-sm"></i>
                    </div>
                    Upcoming Bills
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                    {{ $bills->count() }} bills scheduled

                    {{-- Badge Due Today --}}
                    @if ($dueTodayCount > 0)
                        <span
                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-600 border border-red-200">
                            {{ $dueTodayCount }} Due Today
                        </span>
                    @endif
                </p>
            </div>

            {{-- Button Tambah Bill --}}
            <button wire:click="openModal"
                class="group relative overflow-hidden bg-gradient-to-r from-blue-400 to-indigo-600 text-white font-bold py-2 px-5 rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 flex items-center gap-2">
                <span class="relative z-10 text-sm">Add Bill</span>
                <div
                    class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/20">
                </div>
            </button>
        </div>

        {{-- List Bills --}}
        <div class="p-6">
            @if ($bills->count() === 0)
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div
                        class="w-16 h-16 bg-blue-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4 border border-blue-100 dark:border-slate-700">
                        <i class="fa-solid fa-check text-blue-400 text-2xl"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200">No upcoming bills</h3>
                    <p class="text-xs text-slate-400 mt-1">Everything looks good!</p>
                    <button wire:click="openModal"
                        class="mt-3 text-sm text-blue-500 dark:text-blue-400 font-bold hover:underline">Add
                        one?</button>
                </div>
            @else
                {{-- DIV SCROLLABLE DISINI --}}
                {{-- max-h-[350px]: Batas tinggi list --}}
                {{-- overflow-y-auto: Aktifkan scroll --}}
                {{-- pr-2: Padding kanan biar scrollbar ga nutup konten --}}
                <div class="space-y-3 overflow-y-auto max-h-[350px] pr-2 custom-scrollbar">
                    @foreach ($bills as $bill)
                        <?php
                        // Logic warna status
                        $diff = $this->getDaysDiff($bill->due_date);
                        if ($diff < 0) {
                            $statusClass = 'bg-red-500 shadow-red-500/50';
                            $statusText = 'Overdue by ' . abs($diff) . ' days';
                        } elseif ($diff === 0) {
                            $statusClass = 'bg-red-500 shadow-red-500/50';
                            $statusText = 'Due Today';
                        } elseif ($diff <= 3) {
                            $statusClass = 'bg-orange-400 shadow-orange-400/50';
                            $statusText = 'Due in ' . $diff . ' day' . ($diff > 1 ? 's' : '');
                        } else {
                            $statusClass = 'bg-blue-500 shadow-blue-500/50';
                            $statusText = 'Due in ' . $diff . ' days';
                        }
                        ?>

                        {{-- Item Bill --}}
                        <div
                            class="flex items-center justify-between p-4 rounded-2xl bg-white/60 dark:bg-slate-800/60 border border-blue-50/50 dark:border-slate-700 hover:shadow-md hover:border-blue-100 dark:hover:border-indigo-900/30 transition-all duration-300 group backdrop-blur-sm">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-3 h-3 rounded-full {{ $statusClass }} shadow-sm ring-4 ring-white dark:ring-slate-900">
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 font-heading">
                                        {{ $bill->name }}</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">
                                        {{ $statusText }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-200 font-body">
                                    Rp {{ number_format($bill->amount, 0, ',', '.') }}
                                </span>
                                {{-- Tombol Hapus --}}
                                <button @click="billToDelete = {{ $bill->id }}; confirmDeleteModal = true"
                                    class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all opacity-0 group-hover:opacity-100">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- BAGIAN 2: MODAL ADD BILL --}}
    @if ($isModalOpen)
        <div
            class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 transition-opacity duration-300">
            <div
                class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] w-full max-w-md overflow-hidden relative transform transition-all duration-300 scale-100 opacity-100 border border-white/50 dark:border-white/5">

                {{-- Header Modal --}}
                <div
                    class="flex justify-between items-center p-8 border-b border-blue-50/50 dark:border-slate-800 bg-gradient-to-r from-blue-50 to-white dark:from-indigo-900/30 dark:to-slate-900">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                            <i class="fa-solid fa-file-invoice-dollar text-lg"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white font-heading">Add New Bill</h3>
                    </div>
                    <button wire:click="closeModal"
                        class="w-10 h-10 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-600 dark:hover:text-white transition-colors shadow-sm border border-slate-100 dark:border-slate-700">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                {{-- Form Modal --}}
                <form wire:submit="saveBill" class="p-8 space-y-6">

                    {{-- Input Bill Name --}}
                    <div class="space-y-2">
                        <label
                            class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Bill
                            Name</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="fa-solid fa-tag text-slate-400 group-focus-within:text-blue-500 transition-colors duration-300"></i>
                            </div>
                            <input type="text" wire:model="name" placeholder="Masukan"
                                class="w-full pl-11 pr-4 py-4 rounded-2xl border border-blue-100 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 text-slate-800 dark:text-white placeholder-slate-400 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all duration-300 font-body">
                        </div>
                        @error('name')
                            <span class="text-red-500 text-xs font-medium ml-1 flex items-center gap-1"><i
                                    class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Due Date --}}
                    <div class="space-y-2">
                        <label
                            class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Due
                            Date</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="fa-regular fa-calendar text-slate-400 group-focus-within:text-blue-500 transition-colors duration-300"></i>
                            </div>
                            <input type="date" wire:model="due_date"
                                class="w-full pl-11 pr-4 py-4 rounded-2xl border border-blue-100 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 text-slate-800 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all duration-300 font-body">
                        </div>
                        @error('due_date')
                            <span class="text-red-500 text-xs font-medium ml-1 flex items-center gap-1"><i
                                    class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Amount --}}
                    <div class="space-y-2">
                        <label
                            class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Amount</label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 font-bold">
                                Rp
                            </div>
                            <input type="number" step="1000" wire:model="amount" placeholder="0"
                                class="w-full pl-12 pr-4 py-4 rounded-2xl border border-blue-100 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 text-slate-800 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all duration-300 font-body font-bold">
                        </div>
                        @error('amount')
                            <span class="text-red-500 text-xs font-medium ml-1 flex items-center gap-1"><i
                                    class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="button" wire:click="closeModal"
                            class="flex-1 py-4 rounded-2xl border border-blue-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold hover:bg-blue-50 dark:hover:bg-slate-800 transition-colors font-heading">Cancel</button>
                        <button type="submit"
                            class="flex-1 group relative overflow-hidden bg-gradient-to-r from-blue-400 to-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-1 active:scale-95 transition-all duration-300 font-heading">
                            <span class="relative z-10 flex items-center justify-center gap-2 text-sm">
                                Save Bill <i class="fa-solid fa-check"></i>
                            </span>
                            <div
                                class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/20">
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- BAGIAN 3: MODAL KONFIRMASI HAPUS (ALPINE.JS) --}}
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

                <h3 class="text-xl font-bold text-slate-800 dark:text-white font-heading mb-2">Delete Bill?</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                    Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan
                </p>
            </div>

            <div class="flex gap-3 mt-8">
                {{-- Button Batal --}}
                <button @click="confirmDeleteModal = false; billToDelete = null"
                    class="flex-1 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-heading text-sm">
                    Cancel
                </button>

                {{-- Button Hapus (Trigger Livewire) --}}
                <button @click="$wire.deleteBill(billToDelete); confirmDeleteModal = false; billToDelete = null;"
                    class="flex-1 bg-gradient-to-r from-red-500 to-pink-600 text-white font-bold py-3 rounded-2xl shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 font-heading text-sm">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

    {{-- STYLE SCROLLBAR CANTIK --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #CBD5E1;
            border-radius: 20px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #475569;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #94a3b8;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #64748b;
        }
    </style>

    {{-- SCRIPT NOTIFICATION (DEBUG MODE AKTIF) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            console.log("Notification system initialized...");

            // Interval ngecek setiap 10 detik (10000 ms) biar cepat kelihatan hasilnya
            // Kalau udah jalan, bisa ganti balik ke 30000 (30 detik)
            setInterval(() => {
                console.log("Running scheduled check...");
                checkDueBills();
            }, 10000);

            // Jalankan sekali pas baru load
            setTimeout(checkDueBills, 5000);

            function checkDueBills() {
                // Panggil method Livewire 'getDueBills'
                @this.getDueBills().then(bills => {
                    console.log("Data bills from PHP:", bills); // CEK INI DI CONSOLE

                    if (bills.length > 0) {
                        // Ambil list ID bill yang sudah di-notify di browser ini
                        let notifiedIds = JSON.parse(sessionStorage.getItem('notifiedBills')) || [];

                        bills.forEach(bill => {
                            console.log("Checking bill:", bill.name, "Date:", bill.due_date);

                            // Kalau bill ini belum pernah di-notify
                            if (!notifiedIds.includes(bill.id)) {
                                
                                // Format pesan
                                let statusText = "";
                                let type = "info"; // warna notif (info = biru, danger = merah)

                                // Cek apakah overdue (simple check string comparison)
                                const todayStr = new Date().toISOString().split('T')[0];
                                if (bill.due_date < todayStr) {
                                    statusText = "Sudah overdue!";
                                    type = "danger";
                                } else if (bill.due_date === todayStr) {
                                    statusText = "Jatuh tempo hari ini.";
                                    type = "info";
                                } else {
                                    statusText = "Jatuh tempo besok.";
                                    type = "info";
                                }

                                const message = `Bill "${bill.name}" Rp ${bill.amount} ${statusText}`;
                                
                                console.log("Dispatching Toast:", message); // CEK INI JUGA

                                // Munculkan notif via Event Global (Window)
                                window.dispatchEvent(new CustomEvent('toast-add', {
                                    detail: { message: message, type: type }
                                }));

                                // Masukan ID ke list agar ga diulang
                                notifiedIds.push(bill.id);
                                sessionStorage.setItem('notifiedBills', JSON.stringify(notifiedIds));
                            } else {
                                console.log("Bill sudah di-notify sebelumnya:", bill.name);
                            }
                        });
                    } else {
                        console.log("Tidak ada bill jatuh tempo saat ini.");
                    }
                }).catch(error => {
                    console.error("Error fetching bills:", error);
                });
            }
        });
    </script>
</div>
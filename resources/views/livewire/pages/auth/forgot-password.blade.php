<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', __($status));
    }
}; ?>

<!-- WRAPPER UTAMA: Mengatur Background dan Split Screen -->
<x-guest-layout title="Lupa Password - FinTrack">
    <!-- Fonts & Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Memanggil Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        .font-body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .bg-grid-dots {
            background-image: radial-gradient(#ffffff15 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>

    <!-- CARD UTAMA (LUPA PASSWORD) -->
    <div
        class="w-full max-w-[1000px] bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.15)] overflow-hidden flex flex-col md:flex-row min-h-[700px] relative z-10 border border-white/50 dark:border-white/5 transition-all duration-500">

        <!-- KOLOM KIRI (BRANDING - Sesuai Desain Login) -->
        <div
            class="w-full md:w-5/12 
                bg-[#4F46E5] dark:bg-[#1e1b4b] 
                relative flex flex-col justify-between p-10 md:p-12 text-white overflow-hidden">

            <div class="absolute inset-0 bg-grid-dots opacity-30 pointer-events-none"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute top-20 -left-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>

            <!-- Bagian Atas -->
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-8">
                    <div
                        class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20">
                        <i class="ph-fill ph-wallet text-2xl"></i>
                    </div>
                    <span class="font-heading font-bold text-xl tracking-wide">FinTrack</span>
                </div>

                <h1 class="font-heading text-3xl md:text-4xl font-bold leading-tight mb-6 drop-shadow-md">
                    Financial <br>Management <br>
                    <span class="text-white/90">System</span>
                </h1>

                <p class="text-indigo-100 text-sm md:text-base leading-relaxed font-medium opacity-90">
                    Platform all-in-one yang dirancang untuk mengontrol alur kas bisnis Anda.
                </p>
            </div>

            <!-- Bagian Bawah: Card Keamanan (Disesuaikan konteks) -->
            <div class="relative z-10 mt-8 mb-20">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="ph-fill ph-shield-check text-2xl text-emerald-400"></i>
                        <span class="font-bold text-lg">Secure Recovery</span>
                    </div>
                    <p class="text-xs text-indigo-100 leading-relaxed">
                        Kami mengutamakan keamanan data. Proses reset password Anda dilindungi enkripsi end-to-end.
                    </p>
                </div>
            </div>

            <!-- TOMBOL KEMBALI -->
            <div class="absolute bottom-8 left-8 z-20">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-2 text-white/70 hover:text-white transition-colors font-medium text-sm group cursor-pointer">
                    <i class="ph-bold ph-arrow-u-up-left group-hover:-translate-x-1 transition-transform"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- KOLOM KANAN: FORM -->
        <div class="w-full md:w-7/12 bg-white dark:bg-slate-900 p-8 md:p-12 flex flex-col justify-center relative">

            <!-- Tombol Close / X (Mobile) -->
            <div class="absolute top-6 right-6 md:hidden">
                <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="ph ph-x text-2xl"></i>
                </a>
            </div>

            <!-- Theme Toggle (Desktop) -->
            <button onclick="toggleDarkMode()"
                class="absolute top-8 right-8 hidden md:flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors border border-slate-200 dark:border-slate-700">
                <i class="ph-fill ph-moon text-lg dark:hidden"></i>
                <i class="ph-fill ph-sun text-lg hidden dark:block"></i>
            </button>

            <!-- Header Form -->
            <div class="mb-10 max-w-md">
                <h2 class="font-heading text-3xl font-bold text-slate-900 dark:text-white mb-2">Lupa Password?</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Masukkan alamat email yang terdaftar, kami akan mengirimkan link untuk mengatur ulang kata sandi Anda.</p>
            </div>

            <!-- Form (Livewire) -->
            <form wire:submit="sendPasswordResetLink" class="space-y-6">
                
                <!-- Status Message -->
                @if (session('status'))
                    <div class="rounded-2xl bg-emerald-50 p-4 mb-6 text-sm font-medium text-emerald-700 ring-1 ring-emerald-200/50">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Input Email (Style sama persis dengan Login) -->
                <div class="space-y-2">
                    <label
                        class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Email
                        Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i
                                class="ph ph-envelope-simple text-lg text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300"></i>
                        </div>
                        <input type="email" id="email" name="email" wire:model="email" required autofocus
                            class="w-full pl-11 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 text-slate-800 dark:text-white placeholder-slate-400 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all duration-300 font-body"
                            placeholder="name@company.com">
                    </div>
                    @error('email')
                        <span class="text-red-500 text-xs font-medium ml-1 flex items-center gap-1"><i
                                class="ph-bold ph-warning-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Button Submit (Style sama persis dengan Login) -->
                <button type="submit"
                    class="group w-full relative overflow-hidden bg-gradient-to-br from-blue-400 to-indigo-600 text-white font-heading font-bold py-4 rounded-2xl shadow-lg shadow-blue-500/40 hover:shadow-xl hover:-translate-y-1 active:scale-95 transition-all duration-300">
                    <span class="relative z-10 flex items-center justify-center gap-2 text-lg">
                        <span wire:loading.remove>Kirim Link Reset</span>
                        <span wire:loading>Kirim...</span>
                    </span>
                    <!-- Overlay putih transparan pas hover -->
                    <div
                        class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-transform duration-300 group-hover:scale-100 group-hover:bg-white/20">
                    </div>
                </button>
            </form>

            <!-- Footer Form -->
            <div class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400 font-medium">
                Ingat kata sandi Anda?
                <a href="{{ route('login') }}"
                    class="text-indigo-600 dark:text-indigo-400 font-bold hover:text-indigo-500 hover:underline ml-1">Kembali ke Login</a>
            </div>

        </div>
    </div>

    <!-- SCRIPT TOGGLE MODE -->
    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</x-guest-layout>
<x-guest-layout title="Register - FinTrack">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        .font-heading { font-family: 'Outfit', sans-serif; }
        .font-body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-grid-dots { background-image: radial-gradient(#ffffff15 1px, transparent 1px); background-size: 20px 20px; }
        
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
    </style>

    <div class="min-h-screen flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        
        <!-- Background Decorations -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-purple-300 dark:bg-indigo-900 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-300 dark:bg-purple-900 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000 translate-x-1/2 translate-y-1/2"></div>

        <!-- CARD REGISTER UTAMA -->
        <div class="w-full max-w-[1000px] bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.15)] overflow-hidden flex flex-col md:flex-row min-h-[700px] relative z-10 border border-white/50 dark:border-white/5 transition-all duration-500">

            <!-- KOLOM KIRI (Flat Color - Indigo) -->
            <div class="w-full md:w-5/12 
                bg-[#4F46E5] dark:bg-[#1e1b4b] 
                relative flex flex-col justify-between p-10 md:p-12 text-white overflow-hidden">
                
                <div class="absolute inset-0 bg-grid-dots opacity-30 pointer-events-none"></div>
                <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute top-20 -left-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>

                <!-- Bagian Atas -->
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20">
                            <i class="ph-fill ph-wallet text-2xl"></i>
                        </div>
                        <span class="font-heading font-bold text-xl tracking-wide">FinTrack</span>
                    </div>

                    <h1 class="font-heading text-3xl md:text-4xl font-bold leading-tight mb-6 drop-shadow-md">
                        Mulai <br>Perjalanan <br>
                        <span class="text-white/90">Bisnis Anda</span>
                    </h1>
                    
                    <p class="text-indigo-100 text-sm md:text-base leading-relaxed font-medium opacity-90">
                        Bergabunglah dengan ribuan pengusaha yang telah merapikan keuangan bisnis mereka dalam satu platform terintegrasi.
                    </p>
                </div>

                <!-- Bagian Bawah (STATIS) -->
                <div class="relative z-10 mt-8">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="ph-fill ph-rocket-launch text-2xl text-amber-400"></i>
                            <span class="font-bold text-lg">Mulai Sekarang</span>
                        </div>
                        <p class="text-xs text-indigo-100 leading-relaxed">
                            Pendaftaran gratis dan akses penuh ke fitur dashboard dalam hitungan detik.
                        </p>
                    </div>
                </div>

                <!-- TOMBOL KEMBALI -->
                <div class="absolute bottom-8 left-8 z-20">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-white/70 hover:text-white transition-colors font-medium text-sm group cursor-pointer">
                        <i class="ph-bold ph-arrow-u-up-left group-hover:-translate-x-1 transition-transform"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

            <!-- KOLOM KANAN: FORM -->
            <div class="w-full md:w-7/12 bg-white dark:bg-slate-900 p-8 md:p-12 flex flex-col justify-center relative overflow-y-auto">
                
                <!-- Tombol Close / X (Mobile) -->
                <div class="absolute top-6 right-6 md:hidden">
                    <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <i class="ph ph-x text-2xl"></i>
                    </a>
                </div>

                <!-- Theme Toggle (Desktop) -->
                <button onclick="toggleDarkMode()" class="absolute top-8 right-8 hidden md:flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors border border-slate-200 dark:border-slate-700">
                    <i class="ph-fill ph-moon text-lg dark:hidden"></i>
                    <i class="ph-fill ph-sun text-lg hidden dark:block"></i>
                </button>

                <!-- Header Form -->
                <div class="mb-6">
                    <h2 class="font-heading text-3xl font-bold text-slate-900 dark:text-white mb-2">Buat Akun Baru</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Isi formulir di bawah ini untuk memulai.</p>
                </div>

                <!-- Global Error Alert -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50/80 dark:bg-red-900/20 backdrop-blur-sm border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-2xl text-sm">
                        <div class="flex items-center gap-2 font-bold mb-1">
                            <i class="ph-bold ph-warning-circle text-lg"></i> 
                            Perhatian!
                        </div>
                        <p>Ada kesalahan pada formulir pendaftaran Anda.</p>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Input Name -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Full Name</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-user text-lg text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300"></i>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                class="w-full pl-11 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 text-slate-800 dark:text-white placeholder-slate-400 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all duration-300 font-body"
                                placeholder="John Doe">
                        </div>
                        @error('name')
                            <span class="text-red-500 text-xs font-medium ml-1 flex items-center gap-1"><i class="ph-bold ph-warning-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input Email -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Email Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-envelope-simple text-lg text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-11 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 text-slate-800 dark:text-white placeholder-slate-400 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all duration-300 font-body"
                                placeholder="name@company.com">
                        </div>
                        @error('email')
                            <span class="text-red-500 text-xs font-medium ml-1 flex items-center gap-1"><i class="ph-bold ph-warning-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-lock-key text-lg text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-11 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 text-slate-800 dark:text-white placeholder-slate-400 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all duration-300 font-body"
                                placeholder="•••••">
                        </div>
                        @error('password')
                            <span class="text-red-500 text-xs font-medium ml-1 flex items-center gap-1"><i class="ph-bold ph-warning-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input Password Confirmation -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider ml-1">Confirm Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-shield-check text-lg text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full pl-11 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 text-slate-800 dark:text-white placeholder-slate-400 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all duration-300 font-body"
                                placeholder="•••••">
                        </div>
                        @error('password_confirmation')
                            <span class="text-red-500 text-xs font-medium ml-1 flex items-center gap-1"><i class="ph-bold ph-warning-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Button Submit -->
                    <button type="submit"
                        class="group w-full relative overflow-hidden bg-slate-900 dark:bg-indigo-600 text-white font-heading font-bold py-4 rounded-2xl shadow-lg shadow-slate-900/20 dark:shadow-indigo-600/40 hover:shadow-xl hover:-translate-y-1 active:scale-95 transition-all duration-300">
                        <span class="relative z-10 flex items-center justify-center gap-2 text-lg">
                            Buat Akun Baru <i class="ph-bold ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-transform duration-300 group-hover:scale-100 group-hover:bg-indigo-600/20 dark:group-hover:bg-white/10"></div>
                    </button>
                </form>

                <!-- Footer Form -->
                <div class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400 font-medium">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:text-indigo-500 hover:underline ml-1">Login disini</a>
                </div>

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
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</x-guest-layout>
<x-guest-layout title="Register">
    <div
        class="w-full max-w-md bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 p-8">

        <!-- Title dengan Ikon Biru -->
        <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
            <i class="fa-solid fa-circle-plus text-blue-600"></i> Create Account
        </h2>

        <!-- Error Message (Jika ada error) -->
        @if ($errors->any())
            <div
                class="mb-4 p-4 bg-red-50 text-red-700 rounded-lg text-sm border border-red-200 dark:bg-red-900/20 dark:border-red-800">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                    <div>
                        <p class="font-bold">Gagal mendaftar!</p>
                        @error('name')
                            <span class="text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 uppercase mb-1.5">Full
                    Name</label>
                <div class="relative">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                        placeholder="John Doe">
                </div>
                @error('name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 uppercase mb-1.5">Email
                    Address</label>
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 transition-colors">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 outline-none transition-all placeholder="john@example.com"
                        required>
                </div>
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label
                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 uppercase mb-1.5">Password</label>
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 transition-colors">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 outline-none transition-all"
                        placeholder="••••••••" required>
                </div>
                @error('password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 uppercase mb-1.5">Confirm
                    Password</label>
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 transition-colors">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" type="password"
                        required
                        class="w-full bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 outline-none transition-all placeholder="••••••••"
                        required>
                </div>
                @error('password_confirmation')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button (Warna Biru Segar + Shadow) -->
            <!-- Saya tambahin class 'group' di tombol biar animasi panahnya jalan -->
            <button type="submit"
                class="group w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-500/30 dark:shadow-none hover:bg-blue-700 active:scale-95 transition-all flex justify-center items-center gap-2">
                <span>Create Account</span>
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">
                Login disini
            </a>
        </div>
    </div>
</x-guest-layout>

<x-guest-layout title="Login">
    <div class="w-full max-w-md bg-white dark:bg-slate-800 shadow-2xl rounded-3xl p-8 md:p-12 relative transition-colors duration-300">
        
        <!-- Dark Mode Toggle -->
        <button onclick="toggleDarkMode()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors z-10">
            <i class="fa-solid fa-sun text-lg hidden dark:block text-yellow-400"></i>
            <i class="fa-solid fa-moon text-lg block dark:hidden text-indigo-600"></i>
        </button>

        <!-- Tabs (Login Active) -->
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Welcome Back</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Please enter your details to continue.</p>
            
            <div class="flex gap-6 mt-6 border-b border-slate-200 dark:border-slate-700 justify-center">
                <a href="{{ route('login') }}" class="pb-2 text-sm font-semibold text-primary border-b-2 border-primary transition-colors cursor-default">Sign In</a>
                <a href="{{ route('register') }}" class="pb-2 text-sm font-semibold text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">Sign Up</a>
            </div>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" placeholder="john@example.com">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" placeholder="•••••••">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-between items-center text-sm">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-slate-400">
                    <input type="checkbox" name="remember" class="rounded text-primary focus:ring-primary"> Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-primary hover:underline font-medium">Forgot Password?</a>
                @endif
            </div>

            <button type="submit" class="w-full bg-primary text-white font-bold py-3.5 rounded-xl hover:bg-primaryDark active:scale-95 transition-all shadow-lg shadow-indigo-200 dark:shadow-none">Sign In</button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
            By continuing, you agree to our <a href="#" class="text-primary hover:underline">Terms of Service</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a>.
        </p>
    </div>
</x-guest-layout>
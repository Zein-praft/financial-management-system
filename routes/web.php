<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;

// 1. HOME (LEMPAR KE LOGIN)
Route::get('/', function () {
    return redirect('/login');
});

// 2. LOGIN (STANDALONE, TANPA MIDDLEWARE GUEST)
// Kita hilangkan 'guest' biar user yg stuck bisa masuk halaman ini
Route::view('/login', 'livewire.pages.auth.login')
    ->name('login');

// 3. REGISTER
Route::view('/register', 'livewire.pages.auth.register')
    ->name('register');

// 4. DASHBOARD (BUTUH LOGIN)
Route::get('/dashboard', Dashboard::class)
    ->middleware('auth')
    ->name('dashboard');

// 5. PROFILE & LAINNYA (BAWAAN BREEZE)
Route::view('/profile', 'profile')
    ->middleware('auth')
    ->name('profile');

// Require file auth bawaan breeze (forgot password, dll)
require __DIR__.'/auth.php';
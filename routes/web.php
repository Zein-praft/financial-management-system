<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;

// 1. HOME (LEMPAR KE WELCOME)
Route::view('/', 'welcome')->name('home');

// 2. LOGIN (PASTIKAN ADA ->name('login'))
Route::view('/login', 'livewire.pages.auth.login')
    ->name('login');

// 3. REGISTER (PASTIKAN ADA ->name('register'))
Route::view('/register', 'livewire.pages.auth.register')
    ->name('register');

// 4. DASHBOARD
Route::get('/dashboard', Dashboard::class) 
    ->middleware('auth')
    ->name('dashboard');

// 5. PROFILE
Route::view('/profile', 'profile')
    ->middleware('auth')
    ->name('profile');

require __DIR__.'/auth.php';
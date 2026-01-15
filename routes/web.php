<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // Import Controller Login/Logout

// --- REDIRECT OTOMATIS ---
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
// ----------------------------

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// --- TAMBAHKAN BARIS INI UNTUK MEMPERBAIKI ERROR LOGOUT ---
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
     ->name('logout')
     ->middleware('auth');
// -------------------------------------------------------------

// Breeze Routes (Include file auth.php)
require __DIR__.'/auth.php';
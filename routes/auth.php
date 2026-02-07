<?php

use Illuminate\Support\Facades\Route;

// Kita tetap menggunakan Controller untuk Logout & Email Verification 
// karena biasanya logika ini lebih rumit perlu handling khusus dari Laravel
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::middleware(['guest'])->group(function () {
    
    // ---------------------------------------------------
    // BAGIAN LOGIN & REGISTER (LIVEWIRE)
    // Kita arahkan langsung ke View Livewire
    // ---------------------------------------------------
    
    // Register (Livewire)
    Route::view('register', 'livewire.pages.auth.register')
                ->name('register');

    // Login (Livewire)
    Route::view('login', 'livewire.pages.auth.login')
                ->name('login');

    // Forgot Password (Livewire)
    Route::view('forgot-password', 'livewire.pages.auth.forgot-password')
                ->name('password.request');

    // Reset Password (Livewire)
    // Karena ada parameter {token}, kita pakai function kecil untuk melempar token ke view
    Route::get('reset-password/{token}', function ($token) {
        return view('livewire.pages.auth.reset-password', ['token' => $token]);
    })->name('password.reset');
});

Route::middleware(['auth'])->group(function () {
    
    // Email Verification (Biarkan pakai Controller Laravel Standar)
    Route::get('verify-email', [VerifyEmailController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    // Logout (Biarkan pakai Controller Laravel Standar)
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
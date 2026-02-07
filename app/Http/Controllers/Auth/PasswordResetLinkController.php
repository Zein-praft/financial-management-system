<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Tampilkan halaman forgot password.
     * 
     * PERHATIAN: Pastikan 'view(...)' mengarah ke file blade yang benar.
     * Berdasarkan file web.php Anda, Anda menggunakan struktur 'livewire.pages.auth'.
     * Jika file blade Anda ada di resources/views/pages/auth/forgot-password.blade.php
     * Ubah baris di bawah menjadi: return view('pages.auth.forgot-password');
     */
    public function create(): View
    {
        return view('livewire.pages.auth.forgot-password'); // Cek bagian catatan di bawah jika error view not found
    }

    /**
     * Proses kirim link reset.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Mengirim link reset password
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
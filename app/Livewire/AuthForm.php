<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthForm extends Component
{
    public $mode = 'login'; // 'login' atau 'register'
    public $email = '';
    public $password = '';
    public $name = '';
    public $password_confirmation = '';
    public $remember = false;

    protected $listeners = ['switchMode' => 'changeMode'];

    public function mount($mode = 'login')
    {
        $this->mode = $mode;
    }

    public function changeMode($newMode)
    {
        $this->mode = $newMode;
        $this->reset(['email', 'password', 'name', 'password_confirmation', 'remember']);
    }

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials, $this->remember)) {
            $this->reset();

            session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function register()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        $this->reset();

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth-form');
    }
}
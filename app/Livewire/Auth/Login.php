<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            if (Auth::user()->hasRole('customer')) {
                session()->flash('success', 'Login successful!');
                return redirect(route('home.web'));
            }
        } else {
            session()->flash('error', 'Invalid credentials!');
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}

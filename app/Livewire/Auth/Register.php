<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function register()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        $user->password = $this->password;
        $user->save();
        $user->assignRole('customer');
        Auth::login($user);

        session()->flash('success', 'Registration successful!');
        return redirect(route('home.web'));
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}

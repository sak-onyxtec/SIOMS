<?php

namespace App\Livewire\Staff;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public $password;
    public $password_confirmation;
    public $showModal = true;

    protected function rules(): array
    {
        return [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function updatePassword()
    {
        $this->validate();

        $user = Auth::user();

        // Only allow if user is staff and first_login is true
        if (!$user->hasRole('staff') || !$user->first_login) {
            session()->flash('error', 'You are not authorized to change password.');
            return;
        }

        $user->password = $this->password;
        $user->first_login = false;
        $user->save();

        // Reset form
        $this->reset(['password', 'password_confirmation']);
        $this->showModal = false;
        
        session()->flash('success', 'Password changed successfully! You can now use the dashboard.');
        
        // Refresh the page to update the user state
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.staff.change-password');
    }
}


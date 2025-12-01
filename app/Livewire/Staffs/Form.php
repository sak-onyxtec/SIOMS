<?php

namespace App\Livewire\Staffs;

use App\Models\User;
use App\Traits\FileManagerTrait;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads, FileManagerTrait;

    public $staff_id, $name, $email, $password, $password_confirmation;

    public function mount($id = null)
    {
        if ($id) {
            $staff = User::role('staff')->findOrFail($id);
            $this->staff_id = $staff->id;
            $this->name = $staff->name;
            $this->email = $staff->email;
        }
    }

    public function save()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . ($this->staff_id ? ',' . $this->staff_id : ''),
        ];

        if (!$this->staff_id) {
            $rules['password'] = 'required|confirmed';
        } elseif ($this->password) {
            $rules['password'] = 'confirmed';
        }

        $validated = $this->validate($rules);

        if ($this->staff_id) {
            $staff = User::findOrFail($this->staff_id);
            $staff->name = $this->name;
            $staff->email = $this->email;
            $staff->assignRole('staff');
            $staff->save();
        } else {
            $staff = User::create([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            $staff->password = $this->password;
            $staff->save();
            $staff->assignRole('staff');
        }

        return redirect()->route('staff.index')->with('success', 'User saved!');
    }

    public function render()
    {
        return view('livewire.staffs.form');
    }
}

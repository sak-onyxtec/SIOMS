<?php

namespace App\Livewire\Staffs;

use App\Models\User;
use App\Traits\FileManagerTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\StaffTemporaryPasswordMail;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads, FileManagerTrait;

    public $staff_id, $name, $email, $profile_image, $oldProfileImage;

    public function mount($id = null)
    {
        if ($id) {
            $staff = User::role('staff')->findOrFail($id);
            $this->staff_id = $staff->id;
            $this->name = $staff->name;
            $this->email = $staff->email;
            $this->oldProfileImage = $staff->profile_image ? $staff->profile_image : null;
        }
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:25',
            'email' => 'required|email|max:100|unique:users,email' . ($this->staff_id ? ',' . $this->staff_id : ''),
            'profile_image' => 'nullable|image|max:2048',
        ];

        $validated = $this->validate($rules);

        $profileImageFilename = $this->oldProfileImage;
        if ($this->profile_image) {
            $profileImageFilename = $this->upload('uploads/users/', $this->profile_image, $this->oldProfileImage);
        }

        if ($this->staff_id) {
            $staff = User::findOrFail($this->staff_id);
            $staff->name = $this->name;
            $staff->email = $this->email;
            if ($profileImageFilename) {
                $staff->profile_image = $profileImageFilename;
            }
            $staff->assignRole('staff');
            $staff->save();
        } else {
            $temporaryPassword = Str::random(10);

            $staff = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'profile_image' => $profileImageFilename,
            ]);
            $staff->password = $temporaryPassword;
            $staff->first_login = true;
            $staff->is_active = true;
            $staff->save();
            $staff->assignRole('staff');

            // Send temporary password email
            try {
                Mail::to($staff->email)->send(
                    new StaffTemporaryPasswordMail($staff, $temporaryPassword)
                );
            } catch (\Throwable $e) {
                // Do not break staff creation if mail fails; log for debugging
                logger()->error('Failed to send staff temporary password email', [
                    'staff_id' => $staff->id ?? null,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('staff.index')->with('success', 'User saved!');
    }

    public function render()
    {
        return view('livewire.staffs.form');
    }
}

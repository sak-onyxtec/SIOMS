<?php

namespace App\Livewire\Web\Profile;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Traits\FileManagerTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, FileManagerTrait;

    public $name;
    public $email;
    public $profile_image;
    public $oldProfileImage;
    public $currentImage;

    public function mount()
    {
        /** @var User $user */
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->oldProfileImage = $user->getRawOriginal('profile_image');
        $this->currentImage = $user->profile_image; // accessor returns full URL
    }

    public function save()
    {
        $user = Auth::user();

        $validator = Validator::make(
            [
                'name' => $this->name,
                'email' => $this->email,
                'profile_image' => $this->profile_image,
            ],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    'unique:users,email,' . $user->id,
                ],
                'profile_image' => 'nullable|image|max:2048',
            ]
        );

        $validated = $validator->validate();

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($this->profile_image) {
            $filename = $this->upload('uploads/users', $this->profile_image, $this->oldProfileImage);
            $user->profile_image = $filename;
            $this->oldProfileImage = $filename;
            $this->currentImage = $user->profile_image; // accessor for fresh URL
        }

        $user->save();

        session()->flash('status', 'profile-updated');
    }

    public function render()
    {
        return view('livewire.web.profile.edit');
    }
}



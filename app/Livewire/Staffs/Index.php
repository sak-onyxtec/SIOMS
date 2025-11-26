<?php

namespace App\Livewire\Staffs;

use Livewire\Component;
use App\Models\User;

class Index extends Component
{
    public function delete($id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();
    }

    public function render()
    {
        return view('livewire.staffs.index', [
            'staffs' => User::role('staff')->get()
        ]);
    }
}

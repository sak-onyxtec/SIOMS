<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleIndex extends Component
{
    public function render()
    {
        return view('livewire.roles.role-index', [
            'roles' => Role::all()
        ]);
    }
}

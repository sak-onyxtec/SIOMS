<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissions extends Component
{
    public $role;
    public $permissions = [];
    public $selectedPermissions = [];

    public function mount($id)
    {
        $this->role     = Role::find($id);
        $this->permissions = Permission::all();
        $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function savePermissions()
    {
        $this->role->syncPermissions($this->selectedPermissions);
        session()->flash('success', 'Permissions updated successfully!');
    }


    public function render()
    {
        $selectedPermissions = $this->selectedPermissions;
        return view('livewire.roles.role-permissions', [
            'selectedPermissions' => $selectedPermissions
        ]);
    }
}

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
    public $newPermissionName = '';

    public function mount($id)
    {
        $this->role     = Role::find($id);
        $this->permissions = Permission::all();
        $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function addPermission()
    {
        $this->validate([
            'newPermissionName' => 'required|string|max:255|unique:permissions,name',
        ]);

        // Normalise permission name (optional: kebab-case)
        $name = trim($this->newPermissionName);

        $permission = Permission::create([
            'name' => $name,
            'guard_name' => config('auth.defaults.guard', 'web'),
        ]);

        // Refresh permissions list
        $this->permissions = Permission::all();

        // Attach new permission to this role by default
        $this->role->givePermissionTo($permission);
        $this->selectedPermissions[] = $permission->name;

        $this->newPermissionName = '';
        session()->flash('success', 'Permission created and assigned to role.');
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

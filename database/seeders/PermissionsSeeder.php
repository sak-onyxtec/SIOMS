<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{

    public function run(): void
    {
        $permissions = [
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
            'manage-users',
            'manage-staffs',
            'manage-permissions',
            'manage-orders',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::findByName('admin');
        $staff = Role::findByName('staff');

        $admin->givePermissionTo(Permission::all());

        $staff->givePermissionTo([
            'view-products',
            'create-products',
            'edit-products',
        ]);
    }
}

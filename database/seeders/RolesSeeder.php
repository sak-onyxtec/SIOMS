<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin role
        Role::create(['name' => 'admin']);

        // Create Staff role
        Role::create(['name' => 'staff']);

        // Create Customer role
        Role::create(['name' => 'customer']);
    }
}

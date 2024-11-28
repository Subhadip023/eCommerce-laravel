<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 // Create permissions
 Permission::create(['name' => 'manage posts']);
 Permission::create(['name' => 'manage users']);

 // Create roles and assign permissions
 $adminRole = Role::create(['name' => 'admin']);
 $adminRole->givePermissionTo(['manage posts', 'manage users']);

 $editorRole = Role::create(['name' => 'editor']);
 $editorRole->givePermissionTo('manage posts');    }
}

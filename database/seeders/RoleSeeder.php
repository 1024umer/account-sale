<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'User';
        $role->save();

        $permission = Permission::where('name', 'None')->first();
        $role_permission = new RolePermission();
        $role_permission->role_id = $role->id;
        $role_permission->permission_id = $permission->id;
        $role_permission->save();

        $role = new Role();
        $role->name = 'Super Admin';
        $role->save();

        $permission = Permission::where('name', 'All')->first();
        $role_permission = new RolePermission();
        $role_permission->role_id = $role->id;
        $role_permission->permission_id = $permission->id;
        $role_permission->save();

    }
}

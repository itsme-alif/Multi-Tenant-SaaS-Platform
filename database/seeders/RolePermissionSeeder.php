<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define roles
        $admin = Role::create(['name' => 'admin']);
        $tenantOwner = Role::create(['name' => 'tenant_owner']);
        $tenantUser = Role::create(['name' => 'tenant_user']);

        // Define permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage tenants']);
        Permission::create(['name' => 'view reports']);

        // Assign permissions to roles
        $admin->givePermissionTo(['manage users', 'manage tenants', 'view reports']);
        $tenantOwner->givePermissionTo(['manage users', 'view reports']);
        $tenantUser->givePermissionTo(['view reports']);
    }
}


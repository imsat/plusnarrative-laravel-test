<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User permission
            ['name' => 'User Add', 'slug' => 'user_add', 'module_name' => 'User'],
            ['name' => 'User Edit', 'slug' => 'user_edit', 'module_name' => 'User'],
            ['name' => 'User Delete', 'slug' => 'user_delete', 'module_name' => 'User'],
            ['name' => 'User View', 'slug' => 'user_view', 'module_name' => 'User'],
            ['name' => 'Administer Users', 'slug' => 'administer_users', 'module_name' => 'User'],

            // Role permission
            ['name' => 'Role Add', 'slug' => 'role_add', 'module_name' => 'Role'],
            ['name' => 'Role Edit', 'slug' => 'role_edit', 'module_name' => 'Role'],
            ['name' => 'Role Delete', 'slug' => 'role_delete', 'module_name' => 'Role'],
            ['name' => 'Role View', 'slug' => 'role_view', 'module_name' => 'Role'],

            // Other permission
            ['name' => 'Admin Dashboard View', 'slug' => 'admin_dashboard_view', 'module_name' => 'Other'],
        ];

        DB::table('permissions')->insert($permissions);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);

        // For admin
        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'email' => 'admin@mail.com',
        ]);
        $admin->assignRoles(['admin', 'content_manager', 'user']);

        // For content manager
        $contentManager = User::factory()->create([
            'first_name' => 'Content Manager',
            'email' => 'content_manager@mail.com',
        ]);
        $contentManager->assignRole('content_manager');

        // Get all permissions
        $permissions = Permission::all();

        // Assign admin permissions
        $adminRole = Role::whereSlug('admin')->first();
        $permissions->each(function ($permission) use ($adminRole) {
            $adminRole->givePermissionTo($permission);
        });

        // Assign content manager permissions
        $adminDashboardViewPermission = $permissions->where('slug', 'admin_dashboard_view')->first();
        if (!blank($adminDashboardViewPermission)) {
            $contentManagerRole = Role::whereSlug('content_manager')->first();
            $contentManagerRole->givePermissionTo($adminDashboardViewPermission);
        }

        // For normal user
        User::factory(100)->create();
    }
}

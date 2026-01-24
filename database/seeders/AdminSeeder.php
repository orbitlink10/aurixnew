<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'Manage services', 'slug' => 'manage_services'],
            ['name' => 'Manage packages', 'slug' => 'manage_packages'],
            ['name' => 'Manage orders', 'slug' => 'manage_orders'],
            ['name' => 'Manage order messages', 'slug' => 'manage_messages'],
            ['name' => 'Manage order files', 'slug' => 'manage_files'],
            ['name' => 'Manage blog posts', 'slug' => 'manage_blogs'],
            ['name' => 'Manage categories', 'slug' => 'manage_categories'],
            ['name' => 'Manage tags', 'slug' => 'manage_tags'],
            ['name' => 'Manage users', 'slug' => 'manage_users'],
            ['name' => 'Manage roles', 'slug' => 'manage_roles'],
            ['name' => 'Manage permissions', 'slug' => 'manage_permissions'],
            ['name' => 'Manage leads', 'slug' => 'manage_leads'],
            ['name' => 'View reports', 'slug' => 'view_reports'],
            ['name' => 'Manage invoices', 'slug' => 'manage_invoices'],
        ];

        $permissionModels = collect($permissions)->map(function ($perm) {
            return Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
        });

        $adminRole = Role::firstOrCreate(['slug' => 'admin'], [
            'name' => 'Administrator',
            'description' => 'Full access to the admin portal',
        ]);
        $editorRole = Role::firstOrCreate(['slug' => 'editor'], [
            'name' => 'Content Editor',
            'description' => 'Manage blog content and categories',
        ]);
        $salesRole = Role::firstOrCreate(['slug' => 'sales'], [
            'name' => 'Sales',
            'description' => 'Handle leads, quotes, and orders',
        ]);

        $adminRole->permissions()->sync($permissionModels->pluck('id'));
        $editorRole->permissions()->sync(
            $permissionModels->whereIn('slug', ['manage_blogs', 'manage_categories', 'manage_tags', 'view_reports'])->pluck('id')
        );
        $salesRole->permissions()->sync(
            $permissionModels->whereIn('slug', ['manage_leads', 'manage_orders', 'manage_messages', 'manage_files', 'manage_invoices', 'view_reports'])->pluck('id')
        );

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@aurix.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        $demoAdmin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Demo Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $adminUser->roles()->sync([$adminRole->id]);
        $adminUser->permissions()->sync($permissionModels->pluck('id'));

        $demoAdmin->roles()->sync([$adminRole->id]);
        $demoAdmin->permissions()->sync($permissionModels->pluck('id'));
    }
}

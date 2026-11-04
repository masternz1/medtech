<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ─── Permissions ──────────────────────────────────────────────────
        $permissions = [
            // Products
            'view_products', 'create_products', 'edit_products', 'delete_products',
            // Categories
            'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
            // Brands
            'view_brands', 'create_brands', 'edit_brands', 'delete_brands',
            // Inventory
            'view_inventory', 'manage_inventory',
            // Orders
            'view_orders', 'manage_orders', 'cancel_orders',
            // Payments
            'view_payments', 'manage_payments',
            // Quotations
            'view_quotations', 'manage_quotations', 'send_quotations',
            // Customers
            'view_customers', 'manage_customers',
            // Enquiries
            'view_enquiries', 'manage_enquiries',
            // Content
            'view_content', 'manage_content',
            // Blog
            'view_blog', 'create_blog', 'edit_blog', 'delete_blog',
            // Settings
            'view_settings', 'manage_settings',
            // Staff
            'view_staff', 'manage_staff', 'manage_roles',
            // Reports
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ─── Roles ────────────────────────────────────────────────────────

        // Super Admin — gets all permissions automatically via Gate::before
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // Administrator — all permissions except role management
        $admin = Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'web']);
        $admin->syncPermissions(array_filter($permissions, fn($p) => $p !== 'manage_roles'));

        // Sales Manager
        $salesManager = Role::firstOrCreate(['name' => 'sales_manager', 'guard_name' => 'web']);
        $salesManager->syncPermissions([
            'view_products', 'create_products', 'edit_products',
            'view_categories', 'view_brands',
            'view_orders', 'manage_orders',
            'view_quotations', 'manage_quotations', 'send_quotations',
            'view_customers', 'manage_customers',
            'view_enquiries', 'manage_enquiries',
            'view_reports',
        ]);

        // Inventory Manager
        $inventoryManager = Role::firstOrCreate(['name' => 'inventory_manager', 'guard_name' => 'web']);
        $inventoryManager->syncPermissions([
            'view_products', 'create_products', 'edit_products',
            'view_categories', 'create_categories', 'edit_categories',
            'view_brands', 'create_brands', 'edit_brands',
            'view_inventory', 'manage_inventory',
            'view_reports',
        ]);

        // Order Manager
        $orderManager = Role::firstOrCreate(['name' => 'order_manager', 'guard_name' => 'web']);
        $orderManager->syncPermissions([
            'view_orders', 'manage_orders', 'cancel_orders',
            'view_payments', 'manage_payments',
            'view_quotations', 'manage_quotations', 'send_quotations',
            'view_customers',
            'view_reports',
        ]);

        // Content Manager
        $contentManager = Role::firstOrCreate(['name' => 'content_manager', 'guard_name' => 'web']);
        $contentManager->syncPermissions([
            'view_content', 'manage_content',
            'view_blog', 'create_blog', 'edit_blog', 'delete_blog',
        ]);

        $this->command->info('Roles and permissions seeded: ' . count($permissions) . ' permissions, 6 roles.');
    }
}

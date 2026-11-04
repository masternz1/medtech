<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@medequippro.com'],
            [
                'name'              => 'Super Admin',
                'password'          => bcrypt('password'),
                'is_staff'          => true,
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super_admin');

        // Create demo staff accounts
        $demoStaff = [
            ['name' => 'Sales Manager', 'email' => 'sales@medequippro.com', 'role' => 'sales_manager'],
            ['name' => 'Inventory Manager', 'email' => 'inventory@medequippro.com', 'role' => 'inventory_manager'],
            ['name' => 'Order Manager', 'email' => 'orders@medequippro.com', 'role' => 'order_manager'],
            ['name' => 'Content Manager', 'email' => 'content@medequippro.com', 'role' => 'content_manager'],
        ];

        foreach ($demoStaff as $staff) {
            $user = User::firstOrCreate(
                ['email' => $staff['email']],
                [
                    'name'              => $staff['name'],
                    'password'          => bcrypt('password'),
                    'is_staff'          => true,
                    'email_verified_at' => now(),
                ]
            );
            $user->assignRole($staff['role']);
        }

        // Create a demo customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name'              => 'Demo Customer',
                'password'          => bcrypt('password'),
                'is_staff'          => false,
                'email_verified_at' => now(),
            ]
        );

        $customer->profile()->firstOrCreate([], [
            'phone'             => '+234 801 234 5678',
            'organization_name' => 'City General Hospital',
            'organization_type' => 'hospital',
            'country'           => 'Nigeria',
        ]);

        $this->command->info('Admin and demo users seeded. Login: admin@medequippro.com / password');
    }
}

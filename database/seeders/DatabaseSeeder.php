<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,      // 1. Permissions and roles first
            CategorySeeder::class,  // 2. Product categories
            BrandSeeder::class,     // 3. Manufacturer brands
            ProductSeeder::class,   // 4. Products with inventory + specs
            ContentSeeder::class,   // 5. Settings, shipping, testimonials, services, FAQs
            AdminSeeder::class,     // 6. Admin users + demo customer (needs roles)
        ]);
    }
}

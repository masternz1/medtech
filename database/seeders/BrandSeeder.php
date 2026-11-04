<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Philips Healthcare', 'slug' => 'philips-healthcare', 'website' => 'https://www.philips.com/healthcare', 'is_featured' => true],
            ['name' => 'GE Healthcare', 'slug' => 'ge-healthcare', 'website' => 'https://www.gehealthcare.com', 'is_featured' => true],
            ['name' => 'Mindray', 'slug' => 'mindray', 'website' => 'https://www.mindray.com', 'is_featured' => true],
            ['name' => 'Dräger', 'slug' => 'drager', 'website' => 'https://www.draeger.com', 'is_featured' => true],
            ['name' => 'Hamilton Medical', 'slug' => 'hamilton-medical', 'website' => 'https://www.hamilton-medical.com', 'is_featured' => true],
            ['name' => 'Medtronic', 'slug' => 'medtronic', 'website' => 'https://www.medtronic.com', 'is_featured' => true],
            ['name' => 'Getinge', 'slug' => 'getinge', 'website' => 'https://www.getinge.com', 'is_featured' => false],
            ['name' => 'Nihon Kohden', 'slug' => 'nihon-kohden', 'website' => 'https://www.nihonkohden.com', 'is_featured' => false],
            ['name' => 'Edan Instruments', 'slug' => 'edan-instruments', 'website' => 'https://www.edan.com', 'is_featured' => false],
            ['name' => 'Comen Medical', 'slug' => 'comen-medical', 'website' => 'https://www.comen.com', 'is_featured' => false],
            ['name' => 'Yuwell', 'slug' => 'yuwell', 'website' => 'https://www.yuwell.com', 'is_featured' => false],
            ['name' => 'DeVilbiss Healthcare', 'slug' => 'devilbiss-healthcare', 'website' => 'https://www.devilbisshealthcare.com', 'is_featured' => false],
        ];

        foreach ($brands as $i => $brand) {
            Brand::firstOrCreate(
                ['slug' => $brand['slug']],
                array_merge($brand, ['is_active' => true, 'sort_order' => $i + 1])
            );
        }

        $this->command->info('Seeded ' . count($brands) . ' equipment brands.');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Ultrasound Systems',
                'slug' => 'ultrasound-systems',
                'description' => 'Ultrasound scanners for general imaging, obstetrics, cardiology and point-of-care use.',
                'icon' => 'scan',
                'sort_order' => 1,
            ],
            [
                'name' => 'CT Scanners',
                'slug' => 'ct-scanners',
                'description' => 'Computed tomography systems for hospitals and diagnostic centres.',
                'icon' => 'scan',
                'sort_order' => 2,
            ],
            [
                'name' => 'X-Ray Machines',
                'slug' => 'x-ray-machines',
                'description' => 'Fixed and mobile digital X-ray systems and accessories.',
                'icon' => 'scan',
                'sort_order' => 3,
            ],
            [
                'name' => 'Ventilators',
                'slug' => 'ventilators',
                'description' => 'ICU, transport and portable ventilators, plus BiPAP and respiratory support.',
                'icon' => 'wind',
                'sort_order' => 4,
            ],
            [
                'name' => 'Vital Sign Monitors',
                'slug' => 'vital-sign-monitors',
                'description' => 'Patient monitors and vital-sign equipment: ECG, SpO2, blood pressure and temperature.',
                'icon' => 'heart-pulse',
                'sort_order' => 5,
            ],
            [
                'name' => 'Dialysis Machines',
                'slug' => 'dialysis-machines',
                'description' => 'Haemodialysis machines and related consumables.',
                'icon' => 'droplets',
                'sort_order' => 6,
            ],
            [
                'name' => 'Analyzers',
                'slug' => 'analyzers',
                'description' => 'Haematology, biochemistry and other laboratory analyzers.',
                'icon' => 'flask-conical',
                'sort_order' => 7,
            ],
            [
                'name' => 'MRI Machines',
                'slug' => 'mri-machines',
                'description' => 'Magnetic resonance imaging systems.',
                'icon' => 'scan',
                'sort_order' => 8,
            ],
            [
                'name' => 'Mammography',
                'slug' => 'mammography',
                'description' => 'Digital mammography systems for breast screening and diagnosis.',
                'icon' => 'scan',
                'sort_order' => 9,
            ],
            [
                'name' => 'Other Medical Equipment',
                'slug' => 'other-medical-equipment',
                'description' => 'Oxygen concentrators, hospital beds, surgical equipment and consumables.',
                'icon' => 'package',
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, ['is_active' => true])
            );
        }

        $this->command->info('Seeded ' . count($categories) . ' product categories.');
    }
}

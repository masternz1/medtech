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
                'name' => 'ICU Ventilators',
                'slug' => 'icu-ventilators',
                'description' => 'Intensive care unit ventilators for critical care patient management. Advanced respiratory support systems for hospitals.',
                'icon' => 'activity',
                'sort_order' => 1,
            ],
            [
                'name' => 'Portable Ventilators',
                'slug' => 'portable-ventilators',
                'description' => 'Lightweight and mobile ventilators for emergency transport and home care ventilation.',
                'icon' => 'wind',
                'sort_order' => 2,
            ],
            [
                'name' => 'BiPAP Machines',
                'slug' => 'bipap-machines',
                'description' => 'Bilevel positive airway pressure devices for non-invasive ventilation and sleep therapy.',
                'icon' => 'lungs',
                'sort_order' => 3,
            ],
            [
                'name' => 'Oxygen Concentrators',
                'slug' => 'oxygen-concentrators',
                'description' => 'Medical oxygen concentrators for continuous supplemental oxygen therapy in clinical and home settings.',
                'icon' => 'droplets',
                'sort_order' => 4,
            ],
            [
                'name' => 'Patient Monitors',
                'slug' => 'patient-monitors',
                'description' => 'Multi-parameter patient monitoring systems for vital signs tracking including ECG, SpO2, NIBP and temperature.',
                'icon' => 'heart-pulse',
                'sort_order' => 5,
            ],
            [
                'name' => 'Hospital Beds',
                'slug' => 'hospital-beds',
                'description' => 'Electric and manual hospital beds, ICU beds and specialty care beds for patient comfort.',
                'icon' => 'bed-double',
                'sort_order' => 6,
            ],
            [
                'name' => 'Laboratory Equipment',
                'slug' => 'laboratory-equipment',
                'description' => 'Medical laboratory instruments including centrifuges, analysers, microscopes and diagnostic equipment.',
                'icon' => 'flask-conical',
                'sort_order' => 7,
            ],
            [
                'name' => 'Diagnostic Equipment',
                'slug' => 'diagnostic-equipment',
                'description' => 'Medical diagnostic instruments including ultrasound, X-ray, ECG machines and clinical analysers.',
                'icon' => 'scan',
                'sort_order' => 8,
            ],
            [
                'name' => 'Surgical Equipment',
                'slug' => 'surgical-equipment',
                'description' => 'Surgical instruments, electrosurgical units, operating lights and theatre equipment for medical facilities.',
                'icon' => 'scissors',
                'sort_order' => 9,
            ],
            [
                'name' => 'Medical Consumables',
                'slug' => 'medical-consumables',
                'description' => 'Disposable medical supplies including gloves, syringes, breathing circuits, catheters and wound care products.',
                'icon' => 'pill',
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

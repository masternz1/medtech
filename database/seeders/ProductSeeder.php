<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Inventory;
use App\Models\ProductSpecification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');
        $brands = Brand::all()->keyBy('slug');

        $products = [
            // ICU Ventilators
            [
                'category' => 'ventilators', 'brand' => 'hamilton-medical',
                'name' => 'Hamilton C6 ICU Ventilator', 'sku' => 'VENT-HAM-C6',
                'model_number' => 'C6', 'price' => 45000.00, 'pricing_type' => 'quote_preferred',
                'short_description' => 'Advanced ICU ventilator with Adaptive Support Ventilation for critical care.',
                'description' => "The Hamilton C6 is an advanced ICU ventilator designed for adult and paediatric patients. Featuring Hamilton Medical's proprietary Adaptive Support Ventilation (ASV) technology, the C6 automatically adjusts ventilation parameters to optimize patient breathing.\n\nBuilt for the demands of modern intensive care units, this ventilator provides comprehensive ventilation modes, integrated lung mechanics monitoring, and intelligent weaning protocols.",
                'features' => "Adaptive Support Ventilation (ASV)\nIntelliCuff automated cuff management\nIntegrated nebulizer\n15-inch colour touchscreen\nBuilt-in battery backup\nFull range of ventilation modes\nAutomatic tube compensation\nLung protective ventilation strategies",
                'warranty_info' => '2-year manufacturer warranty with optional extended service agreement.',
                'status' => 'active', 'is_featured' => true, 'is_new' => false,
                'stock' => 3, 'low_stock' => 2,
                'specs' => [
                    ['group' => 'Technical', 'label' => 'Patient Type', 'value' => 'Adult, Paediatric, Neonatal (optional)'],
                    ['group' => 'Technical', 'label' => 'Tidal Volume Range', 'value' => '20–2000 mL'],
                    ['group' => 'Technical', 'label' => 'Respiratory Rate', 'value' => '1–80 breaths/min'],
                    ['group' => 'Technical', 'label' => 'PEEP Range', 'value' => '0–50 cmH2O'],
                    ['group' => 'Physical', 'label' => 'Weight', 'value' => '25 kg'],
                    ['group' => 'Physical', 'label' => 'Display', 'value' => '15-inch capacitive touchscreen'],
                    ['group' => 'Power', 'label' => 'Power Supply', 'value' => '100–240 VAC, 50/60 Hz'],
                    ['group' => 'Power', 'label' => 'Battery Backup', 'value' => 'Up to 3 hours'],
                ],
            ],
            [
                'category' => 'ventilators', 'brand' => 'drager',
                'name' => 'Dräger Evita V800 Ventilator', 'sku' => 'VENT-DRG-V800',
                'model_number' => 'Evita V800', 'price' => 52000.00, 'pricing_type' => 'quote_preferred',
                'short_description' => 'Premium ICU ventilation platform with SmartCare for automated weaning.',
                'description' => "The Dräger Evita V800 is a high-end ICU ventilator platform designed for demanding critical care environments. With its integrated knowledge-based weaning system SmartCare/PS, the V800 brings automation and intelligence to the ICU.\n\nThe system supports all ventilation modes from invasive to non-invasive, with real-time monitoring and decision support tools.",
                'features' => "SmartCare/PS automated weaning\nAutoFlow auto-regulated pressure-controlled ventilation\nNeoFlow for neonatal ventilation\nIntegrated CO2 monitoring\nPulmonary function testing\n19-inch high-resolution display\nQuarantine mode for infection control",
                'warranty_info' => '2-year manufacturer warranty.',
                'status' => 'active', 'is_featured' => true, 'is_new' => true,
                'stock' => 2, 'low_stock' => 1,
                'specs' => [
                    ['group' => 'Technical', 'label' => 'Patient Type', 'value' => 'Adult, Paediatric, Neonatal'],
                    ['group' => 'Technical', 'label' => 'Tidal Volume Range', 'value' => '2–3000 mL'],
                    ['group' => 'Technical', 'label' => 'FiO2 Range', 'value' => '21–100%'],
                    ['group' => 'Physical', 'label' => 'Weight', 'value' => '42 kg (with accessories)'],
                    ['group' => 'Physical', 'label' => 'Display', 'value' => '19-inch TFT touchscreen'],
                ],
            ],
            // Portable Ventilators
            [
                'category' => 'ventilators', 'brand' => 'hamilton-medical',
                'name' => 'Hamilton T1 Transport Ventilator', 'sku' => 'VENT-HAM-T1',
                'model_number' => 'T1', 'price' => 28000.00, 'pricing_type' => 'fixed',
                'short_description' => 'Military-grade transport ventilator for intra-hospital and emergency transport.',
                'description' => "The Hamilton T1 is a high-performance transport ventilator built to withstand the rigors of patient transport. From the ICU to the ambulance, the T1 provides ICU-level ventilation in a rugged, portable package.",
                'features' => "MIL-STD-810G certified rugged design\nIntegrated SpO2 and EtCO2 monitoring\nASV adaptive ventilation\nHot-swappable batteries\n10-inch daylight-readable display\nIntegrated turbine — no compressed air needed",
                'warranty_info' => '2-year manufacturer warranty.',
                'status' => 'active', 'is_featured' => true, 'is_new' => false,
                'stock' => 5, 'low_stock' => 2,
                'specs' => [
                    ['group' => 'Technical', 'label' => 'Patient Type', 'value' => 'Adult, Paediatric, Neonatal (optional)'],
                    ['group' => 'Technical', 'label' => 'Tidal Volume Range', 'value' => '20–2000 mL'],
                    ['group' => 'Physical', 'label' => 'Weight', 'value' => '5.6 kg'],
                    ['group' => 'Physical', 'label' => 'Protection Rating', 'value' => 'IP22'],
                    ['group' => 'Power', 'label' => 'Battery Life', 'value' => 'Up to 8 hours (dual battery)'],
                ],
            ],
            // Oxygen Concentrators
            [
                'category' => 'other-medical-equipment', 'brand' => 'yuwell',
                'name' => 'Yuwell 8F-5AW Oxygen Concentrator', 'sku' => 'OXY-YUW-8F5AW',
                'model_number' => '8F-5AW', 'price' => 850.00, 'pricing_type' => 'fixed',
                'short_description' => '5-litre medical oxygen concentrator with nebulizer function for home and clinical use.',
                'description' => "The Yuwell 8F-5AW is a reliable 5-litre per minute medical oxygen concentrator suitable for home oxygen therapy and small clinic use. With its integrated nebulizer port and quiet operation, it provides continuous oxygen supply for patients requiring supplemental oxygen.",
                'features' => "5 LPM continuous flow\nOxygen purity ≥93%\nBuilt-in nebulizer port\nLCD display with timer\nLow oxygen alarm\nQuiet operation (≤45 dB)\nSIFI medical certification",
                'warranty_info' => '1-year manufacturer warranty.',
                'status' => 'active', 'is_featured' => true, 'is_new' => false,
                'stock' => 20, 'low_stock' => 5,
                'specs' => [
                    ['group' => 'Technical', 'label' => 'Flow Rate', 'value' => '1–5 LPM'],
                    ['group' => 'Technical', 'label' => 'Oxygen Purity', 'value' => '≥93% (±3%)'],
                    ['group' => 'Technical', 'label' => 'Noise Level', 'value' => '≤45 dB'],
                    ['group' => 'Physical', 'label' => 'Weight', 'value' => '23 kg'],
                    ['group' => 'Power', 'label' => 'Power Consumption', 'value' => '350W'],
                ],
            ],
            // Patient Monitors
            [
                'category' => 'vital-sign-monitors', 'brand' => 'mindray',
                'name' => 'Mindray ePM 15M Patient Monitor', 'sku' => 'MON-MND-EPM15',
                'model_number' => 'ePM 15M', 'price' => 3500.00, 'pricing_type' => 'fixed',
                'short_description' => '15-inch multi-parameter patient monitor with ECG, SpO2, NIBP and temperature.',
                'description' => "The Mindray ePM 15M is a versatile bedside patient monitor designed for general wards, emergency departments and operating rooms. Its modular design allows easy configuration expansion to meet evolving clinical needs.",
                'features' => "15-inch high-resolution LED display\n7-lead ECG with ST analysis\nMasimo SpO2 option\nDual-channel IBP\nEtCO2 capnography (optional)\nIntegrated thermal recorder\nHL7 connectivity for EMR integration",
                'warranty_info' => '2-year manufacturer warranty.',
                'status' => 'active', 'is_featured' => true, 'is_new' => true,
                'stock' => 12, 'low_stock' => 3,
                'specs' => [
                    ['group' => 'Monitoring', 'label' => 'Parameters', 'value' => 'ECG, HR, SpO2, NIBP, TEMP, RESP, IBP (opt), EtCO2 (opt)'],
                    ['group' => 'Monitoring', 'label' => 'ECG Leads', 'value' => '3/5/12 lead'],
                    ['group' => 'Physical', 'label' => 'Display', 'value' => '15.6-inch TFT LED'],
                    ['group' => 'Physical', 'label' => 'Weight', 'value' => '5.5 kg'],
                    ['group' => 'Power', 'label' => 'Battery', 'value' => 'Up to 4 hours lithium-ion'],
                ],
            ],
            // Hospital Beds
            [
                'category' => 'other-medical-equipment', 'brand' => 'ge-healthcare',
                'name' => '5-Function Electric ICU Bed', 'sku' => 'BED-5FUNC-ICU',
                'model_number' => 'MED-ICU-5E', 'price' => null, 'pricing_type' => 'quote_only',
                'short_description' => 'Premium 5-function electric ICU bed with CPR release, Trendelenburg and weighing system.',
                'description' => "This premium 5-function electric ICU hospital bed is designed for intensive care units requiring maximum functionality and patient comfort. Features include electric adjustment of height, back rest, leg rest, Trendelenburg and reverse Trendelenburg positions.",
                'features' => "5 electric functions\nBuilt-in weighing system\nCPR quick release\nAnti-bacterial surfaces\nCollision-proof bumpers\n4-section ABS bed platform\nCentral locking system\nIV pole mounting points",
                'warranty_info' => '3-year structural warranty, 1-year electrical components.',
                'status' => 'active', 'is_featured' => false, 'is_new' => false,
                'stock' => 8, 'low_stock' => 2,
                'specs' => [
                    ['group' => 'Dimensions', 'label' => 'Overall Length', 'value' => '2180 mm'],
                    ['group' => 'Dimensions', 'label' => 'Overall Width', 'value' => '960 mm'],
                    ['group' => 'Technical', 'label' => 'Safe Working Load', 'value' => '250 kg'],
                    ['group' => 'Technical', 'label' => 'Height Range', 'value' => '400–760 mm'],
                    ['group' => 'Technical', 'label' => 'Backrest Angle', 'value' => '0–80°'],
                ],
            ],
            // Laboratory Equipment
            [
                'category' => 'analyzers', 'brand' => 'mindray',
                'name' => 'Mindray BC-5000 Haematology Analyser', 'sku' => 'LAB-MND-BC5000',
                'model_number' => 'BC-5000', 'price' => 12500.00, 'pricing_type' => 'quote_preferred',
                'short_description' => '5-part differential haematology analyser with 60 samples per hour throughput.',
                'description' => "The Mindray BC-5000 is a compact 5-part differential haematology analyser delivering high-throughput CBC analysis with WBC differential. Ideal for hospital laboratories and large clinics requiring reliable blood count analysis.",
                'features' => "5-part WBC differential\n60 samples/hour throughput\n23 reportable parameters + 3 histograms\nAutomatic sample mixing\n10.4-inch touchscreen\nBi-directional LIS connectivity\nReagent management and alerts",
                'warranty_info' => '1-year manufacturer warranty plus installation.',
                'status' => 'active', 'is_featured' => false, 'is_new' => false,
                'stock' => 4, 'low_stock' => 1,
                'specs' => [
                    ['group' => 'Performance', 'label' => 'Throughput', 'value' => '60 samples/hour'],
                    ['group' => 'Performance', 'label' => 'Sample Volume', 'value' => '15 µL (whole blood)'],
                    ['group' => 'Performance', 'label' => 'Parameters', 'value' => '23 parameters + 3 histograms'],
                    ['group' => 'Physical', 'label' => 'Weight', 'value' => '42 kg'],
                ],
            ],
            // Diagnostic Equipment
            [
                'category' => 'vital-sign-monitors', 'brand' => 'edan-instruments',
                'name' => 'Edan SE-1201 12-Channel ECG Machine', 'sku' => 'DIA-EDN-SE1201',
                'model_number' => 'SE-1201', 'price' => 2800.00, 'pricing_type' => 'fixed',
                'short_description' => 'Professional 12-channel resting ECG with automatic interpretation and thermal printer.',
                'description' => "The Edan SE-1201 is a professional 12-channel resting ECG machine designed for cardiology departments, clinics and medical practices. It provides high-fidelity ECG recording with automatic interpretation powered by the EDAN algorithm.",
                'features' => "12 simultaneous leads\nAutomatic interpretation (Glasgow Algorithm)\n8-inch colour LCD display\nBuilt-in thermal printer\nUSB and WiFi connectivity\nPDF export capability\nHR, ST-segment and arrhythmia analysis",
                'warranty_info' => '1-year manufacturer warranty.',
                'status' => 'active', 'is_featured' => false, 'is_new' => true,
                'stock' => 10, 'low_stock' => 3,
                'specs' => [
                    ['group' => 'Technical', 'label' => 'Channels', 'value' => '12 simultaneous acquisition'],
                    ['group' => 'Technical', 'label' => 'Sampling Rate', 'value' => '8000 Hz per channel'],
                    ['group' => 'Technical', 'label' => 'Frequency Response', 'value' => '0.05–300 Hz'],
                    ['group' => 'Physical', 'label' => 'Weight', 'value' => '3.5 kg'],
                    ['group' => 'Power', 'label' => 'Battery', 'value' => 'Rechargeable lithium-ion, 3 hours'],
                ],
            ],
            // Surgical Equipment
            [
                'category' => 'other-medical-equipment', 'brand' => 'ge-healthcare',
                'name' => 'LED Surgical Operating Light (Double Dome)', 'sku' => 'SUR-LED-DD700',
                'model_number' => 'SL-700DD', 'price' => null, 'pricing_type' => 'quote_only',
                'short_description' => 'Ceiling-mounted double-dome LED surgical light with 160,000 lux illuminance.',
                'description' => "Professional ceiling-mounted double-dome LED surgical operating light providing shadow-free illumination for operating theatres. Advanced LED technology delivers high colour rendering index (CRI > 95) for accurate tissue differentiation.",
                'features' => "160,000 lux maximum illuminance\nCRI > 95 for accurate colour rendering\nColour temperature 3,700–5,000K adjustable\nShadow-free illumination pattern\nSterilizable handle\nIntegrated HD camera option\nEnergy-efficient LED (50,000 hour lifespan)",
                'warranty_info' => '3-year warranty including installation.',
                'status' => 'active', 'is_featured' => false, 'is_new' => false,
                'stock' => 3, 'low_stock' => 1,
                'specs' => [
                    ['group' => 'Illumination', 'label' => 'Max Illuminance', 'value' => '160,000 lux'],
                    ['group' => 'Illumination', 'label' => 'CRI', 'value' => '> 95'],
                    ['group' => 'Illumination', 'label' => 'Colour Temperature', 'value' => '3,700–5,000 K'],
                    ['group' => 'Physical', 'label' => 'Dome Diameter', 'value' => '700 mm + 500 mm'],
                    ['group' => 'Technical', 'label' => 'LED Lifespan', 'value' => '50,000 hours'],
                ],
            ],
            // Medical Consumables
            [
                'category' => 'other-medical-equipment', 'brand' => 'philips-healthcare',
                'name' => 'Adult Ventilator Breathing Circuit (Pack of 20)', 'sku' => 'CON-CIRC-AD20',
                'model_number' => 'BC-AD-22', 'price' => 180.00, 'pricing_type' => 'fixed',
                'short_description' => 'Disposable adult ventilator breathing circuit with water trap, 22mm, 1.8m length.',
                'description' => "Medical grade disposable adult ventilator breathing circuit designed for single-patient use. Compatible with most ICU ventilators. Includes integrated water trap and flexible corrugated tubing.",
                'features' => "Single-patient use disposable\n22mm standard connector\n1.8m circuit length\nIntegrated water trap\nLatex-free\nDEHP-free material\nCompatible with most ICU ventilators",
                'warranty_info' => 'Sterility guaranteed until package opened. Check expiry date.',
                'status' => 'active', 'is_featured' => false, 'is_new' => false,
                'stock' => 100, 'low_stock' => 20,
                'specs' => [
                    ['group' => 'Specifications', 'label' => 'Connector Size', 'value' => '22mm ISO'],
                    ['group' => 'Specifications', 'label' => 'Length', 'value' => '1.8 metres'],
                    ['group' => 'Specifications', 'label' => 'Material', 'value' => 'Medical grade PP, latex-free'],
                    ['group' => 'Packaging', 'label' => 'Quantity', 'value' => '20 units per pack'],
                ],
            ],
        ];

        foreach ($products as $p) {
            $category = $categories[$p['category']] ?? null;
            $brand = $brands[$p['brand']] ?? null;
            if (!$category) continue;

            $product = Product::firstOrCreate(
                ['sku' => $p['sku']],
                [
                    'category_id'           => $category->id,
                    'brand_id'              => $brand?->id,
                    'name'                  => $p['name'],
                    'slug'                  => Str::slug($p['name']),
                    'sku'                   => $p['sku'],
                    'model_number'          => $p['model_number'],
                    'short_description'     => $p['short_description'],
                    'description'           => $p['description'],
                    'features'              => $p['features'],
                    'price'                 => $p['price'],
                    'pricing_type'          => $p['pricing_type'],
                    'warranty_info'         => $p['warranty_info'],
                    'status'                => $p['status'],
                    'is_featured'           => $p['is_featured'],
                    'is_new'                => $p['is_new'],
                    'meta_title'            => $p['name'] . ' | MedEquip Pro',
                    'meta_description'      => $p['short_description'],
                ]
            );

            // Create inventory
            Inventory::firstOrCreate(
                ['product_id' => $product->id],
                [
                    'quantity'              => $p['stock'],
                    'low_stock_threshold'   => $p['low_stock'],
                ]
            );

            // Create specifications
            if (!empty($p['specs'])) {
                foreach ($p['specs'] as $i => $spec) {
                    ProductSpecification::firstOrCreate(
                        ['product_id' => $product->id, 'label' => $spec['label']],
                        [
                            'group_name'  => $spec['group'],
                            'value'       => $spec['value'],
                            'sort_order'  => $i + 1,
                        ]
                    );
                }
            }
        }

        $this->command->info('Seeded ' . count($products) . ' products with inventory and specifications.');
    }
}

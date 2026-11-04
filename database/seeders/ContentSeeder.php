<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\Testimonial;
use App\Models\Banner;
use App\Models\Service;
use App\Models\Faq;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Settings ─────────────────────────────────────────────────
        $settings = [
            ['group' => 'general', 'key' => 'company_name', 'value' => 'MedEquip Pro', 'type' => 'string', 'label' => 'Company Name'],
            ['group' => 'general', 'key' => 'company_tagline', 'value' => 'Professional Medical Equipment Solutions', 'type' => 'string', 'label' => 'Company Tagline'],
            ['group' => 'general', 'key' => 'company_description', 'value' => 'MedEquip Pro is a leading supplier of professional medical equipment, serving hospitals, clinics, laboratories and healthcare professionals with quality medical devices and exceptional customer support.', 'type' => 'text', 'label' => 'Company Description'],
            ['group' => 'contact', 'key' => 'company_phone', 'value' => '+234 000 000 0000', 'type' => 'string', 'label' => 'Phone Number'],
            ['group' => 'contact', 'key' => 'company_email', 'value' => 'info@medequippro.com', 'type' => 'string', 'label' => 'Email Address'],
            ['group' => 'contact', 'key' => 'company_whatsapp', 'value' => '+234 000 000 0000', 'type' => 'string', 'label' => 'WhatsApp Number'],
            ['group' => 'contact', 'key' => 'company_address', 'value' => 'Victoria Island, Lagos, Nigeria', 'type' => 'string', 'label' => 'Business Address'],
            ['group' => 'contact', 'key' => 'business_hours', 'value' => 'Monday – Friday: 8:00 AM – 6:00 PM | Saturday: 9:00 AM – 2:00 PM', 'type' => 'string', 'label' => 'Business Hours'],
            ['group' => 'social', 'key' => 'facebook_url', 'value' => '#', 'type' => 'string', 'label' => 'Facebook URL'],
            ['group' => 'social', 'key' => 'twitter_url', 'value' => '#', 'type' => 'string', 'label' => 'Twitter URL'],
            ['group' => 'social', 'key' => 'instagram_url', 'value' => '#', 'type' => 'string', 'label' => 'Instagram URL'],
            ['group' => 'social', 'key' => 'linkedin_url', 'value' => '#', 'type' => 'string', 'label' => 'LinkedIn URL'],
            ['group' => 'seo', 'key' => 'meta_title', 'value' => 'MedEquip Pro — Professional Medical Equipment Supplier', 'type' => 'string', 'label' => 'Default Meta Title'],
            ['group' => 'seo', 'key' => 'meta_description', 'value' => 'Leading medical equipment supplier. ICU ventilators, patient monitors, oxygen concentrators, hospital beds and laboratory equipment. Serving hospitals and clinics across Nigeria and West Africa.', 'type' => 'text', 'label' => 'Default Meta Description'],
            ['group' => 'payment', 'key' => 'default_currency', 'value' => 'NGN', 'type' => 'string', 'label' => 'Default Currency'],
            ['group' => 'payment', 'key' => 'vat_rate', 'value' => '0', 'type' => 'integer', 'label' => 'VAT Rate (%)'],
            ['group' => 'homepage', 'key' => 'hero_title', 'value' => 'Professional Medical Equipment', 'type' => 'string', 'label' => 'Hero Title'],
            ['group' => 'homepage', 'key' => 'hero_subtitle', 'value' => 'Quality medical devices for hospitals, clinics and healthcare professionals. Trusted equipment supplier with technical support and competitive pricing.', 'type' => 'text', 'label' => 'Hero Subtitle'],
            ['group' => 'homepage', 'key' => 'about_title', 'value' => 'About MedEquip Pro', 'type' => 'string', 'label' => 'About Section Title'],
            ['group' => 'homepage', 'key' => 'about_text', 'value' => 'With years of experience in the medical equipment industry, MedEquip Pro has built a reputation for reliability, quality and excellent customer service. We partner with leading global manufacturers to bring the best medical technology to healthcare facilities.', 'type' => 'text', 'label' => 'About Section Text'],
        ];

        foreach ($settings as $s) {
            Setting::firstOrCreate(['key' => $s['key']], $s);
        }

        // ─── Shipping Methods ─────────────────────────────────────────
        $shippingMethods = [
            ['name' => 'Standard Delivery', 'description' => 'Delivery within Lagos and surrounding areas.', 'base_cost' => 5000, 'estimated_days_min' => 3, 'estimated_days_max' => 7, 'sort_order' => 1],
            ['name' => 'Express Delivery', 'description' => 'Priority delivery with tracking.', 'base_cost' => 15000, 'estimated_days_min' => 1, 'estimated_days_max' => 3, 'sort_order' => 2],
            ['name' => 'Nationwide Delivery', 'description' => 'Delivery to all states across Nigeria.', 'base_cost' => 25000, 'estimated_days_min' => 5, 'estimated_days_max' => 14, 'sort_order' => 3],
            ['name' => 'Pickup', 'description' => 'Collect from our Lagos office.', 'base_cost' => 0, 'estimated_days_min' => 1, 'estimated_days_max' => 2, 'sort_order' => 4],
        ];

        foreach ($shippingMethods as $sm) {
            ShippingMethod::firstOrCreate(['name' => $sm['name']], array_merge($sm, ['is_active' => true]));
        }

        // ─── Testimonials ─────────────────────────────────────────────
        $testimonials = [
            ['name' => 'Dr. Adebayo Ogunlesi', 'title' => 'Medical Director', 'organization' => 'Lagos General Hospital', 'content' => 'MedEquip Pro has been our trusted supplier for critical care ventilators and patient monitors. Their technical support team is highly responsive and knowledgeable. Excellent service.', 'rating' => 5, 'sort_order' => 1],
            ['name' => 'Pharm. Chioma Nwosu', 'title' => 'Head of Procurement', 'organization' => 'St. Mary\'s Catholic Hospital', 'content' => 'We have purchased laboratory equipment and diagnostic devices from MedEquip Pro for over three years. Competitive pricing, genuine products and reliable delivery every time.', 'rating' => 5, 'sort_order' => 2],
            ['name' => 'Engr. Ibrahim Musa', 'title' => 'Biomedical Engineer', 'organization' => 'National Hospital Abuja', 'content' => 'The quality of equipment and after-sales support we receive from MedEquip Pro is outstanding. They provide genuine spare parts and technical training for our staff.', 'rating' => 5, 'sort_order' => 3],
            ['name' => 'Dr. Funke Adeyemi', 'title' => 'Consultant Pulmonologist', 'organization' => 'University College Hospital Ibadan', 'content' => 'We recently purchased several ICU ventilators from MedEquip Pro. The equipment arrived well-packaged, on schedule, and their installation team was professional and thorough.', 'rating' => 4, 'sort_order' => 4],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(
                ['name' => $t['name']],
                array_merge($t, ['is_active' => true])
            );
        }

        // ─── Services ─────────────────────────────────────────────────
        $services = [
            ['title' => 'Equipment Sales', 'slug' => 'equipment-sales', 'description' => 'We supply a comprehensive range of medical equipment from leading global manufacturers. From ICU ventilators to laboratory analysers, we provide genuine, quality medical devices for healthcare facilities of all sizes.', 'icon' => 'shopping-cart', 'sort_order' => 1],
            ['title' => 'Installation & Commissioning', 'slug' => 'installation-commissioning', 'description' => 'Our certified biomedical engineers handle professional installation and commissioning of all medical equipment. We ensure proper setup, calibration and testing before handover to your team.', 'icon' => 'wrench', 'sort_order' => 2],
            ['title' => 'Technical Support', 'slug' => 'technical-support', 'description' => 'We provide ongoing technical support and maintenance services for all equipment we supply. Our support team is available for troubleshooting, preventive maintenance and emergency repairs.', 'icon' => 'headphones', 'sort_order' => 3],
            ['title' => 'Training & Education', 'slug' => 'training-education', 'description' => 'We offer comprehensive operator training for clinical staff on all medical equipment. Our training programmes ensure your team can safely and effectively use every device we supply.', 'icon' => 'graduation-cap', 'sort_order' => 4],
            ['title' => 'Spare Parts Supply', 'slug' => 'spare-parts-supply', 'description' => 'We maintain stock of genuine spare parts and accessories for all equipment brands we carry. Fast sourcing and delivery to minimize equipment downtime.', 'icon' => 'cog', 'sort_order' => 5],
            ['title' => 'Equipment Consultation', 'slug' => 'equipment-consultation', 'description' => 'Our technical team provides expert consultation to help you select the right equipment for your facility. We assess your clinical requirements and recommend cost-effective solutions.', 'icon' => 'clipboard-list', 'sort_order' => 6],
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(['slug' => $s['slug']], array_merge($s, ['is_active' => true]));
        }

        // ─── FAQs ─────────────────────────────────────────────────────
        $faqs = [
            ['question' => 'Do you ship medical equipment nationwide?', 'answer' => 'Yes, we deliver medical equipment to all states across Nigeria. Delivery times vary by location and equipment size. Contact our sales team for a delivery estimate and shipping quote.', 'category' => 'shipping', 'sort_order' => 1],
            ['question' => 'What payment methods do you accept?', 'answer' => 'We accept bank transfers, credit/debit cards via Paystack and Flutterwave, and direct bank deposits for large orders. For institutional purchases, we can also arrange payment terms upon approval.', 'category' => 'payment', 'sort_order' => 2],
            ['question' => 'Do you offer warranties on medical equipment?', 'answer' => 'Yes, all medical equipment comes with the manufacturer\'s warranty. Warranty periods vary by product and brand, typically ranging from 1 to 3 years. Extended warranty and service contracts are available.', 'category' => 'products', 'sort_order' => 3],
            ['question' => 'Can I request a custom quotation for bulk orders?', 'answer' => 'Absolutely. We provide custom quotations for bulk purchases and institutional orders. Use our Request a Quote form or contact our sales team directly with your requirements.', 'category' => 'orders', 'sort_order' => 4],
            ['question' => 'Do you provide equipment installation services?', 'answer' => 'Yes, we provide professional installation and commissioning for all major medical equipment. Our biomedical engineering team handles setup, calibration, testing and operator training.', 'category' => 'services', 'sort_order' => 5],
            ['question' => 'How do I track my order?', 'answer' => 'Once your order is confirmed and dispatched, you will receive tracking information via email. You can also log into your customer account to check the current status of your order.', 'category' => 'orders', 'sort_order' => 6],
            ['question' => 'What is your return policy?', 'answer' => 'We accept returns for defective or incorrectly shipped items within 7 days of delivery. Equipment must be in original packaging and unused. Contact our support team to initiate a return. Custom-ordered items may not be eligible for return.', 'category' => 'shipping', 'sort_order' => 7],
            ['question' => 'Are your products NAFDAC/FDA approved?', 'answer' => 'All medical devices we supply comply with applicable regulatory standards. We source from certified manufacturers and can provide certificates of conformity, NAFDAC registration details, and ISO certificates upon request.', 'category' => 'products', 'sort_order' => 8],
        ];

        foreach ($faqs as $f) {
            Faq::firstOrCreate(
                ['question' => $f['question']],
                array_merge($f, ['is_active' => true])
            );
        }

        $this->command->info('Content seeded: settings, shipping methods, testimonials, services, FAQs.');
    }
}

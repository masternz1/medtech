<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicWebsiteAndEcommerceTest extends TestCase
{
    use RefreshDatabase;

    protected Category $category;
    protected Brand $brand;
    protected Product $product;
    protected ShippingMethod $shippingMethod;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::create([
            'name'        => 'ICU Ventilators',
            'slug'        => 'icu-ventilators',
            'description' => 'Intensive care unit ventilators.',
            'is_active'   => true,
            'sort_order'  => 1,
        ]);

        $this->brand = Brand::create([
            'name'        => 'Dräger',
            'slug'        => 'drager',
            'is_active'   => true,
            'is_featured' => true,
        ]);

        $this->product = Product::create([
            'category_id'       => $this->category->id,
            'brand_id'          => $this->brand->id,
            'name'              => 'Dräger Evita V800 Ventilator',
            'slug'              => 'drager-evita-v800-ventilator',
            'sku'               => 'VENT-DRG-V800',
            'model_number'      => 'Evita V800',
            'price'             => 52000.00,
            'pricing_type'      => 'fixed',
            'short_description' => 'Premium ICU ventilation platform with SmartCare.',
            'description'       => 'Full technical and clinical description of Dräger Evita V800.',
            'status'            => 'active',
            'is_featured'       => true,
            'is_new'            => true,
        ]);

        Inventory::create([
            'product_id'          => $this->product->id,
            'quantity'            => 5,
            'low_stock_threshold' => 1,
        ]);

        $this->shippingMethod = ShippingMethod::create([
            'name'        => 'Standard Logistics',
            'base_cost'   => 5000,
            'is_active'   => true,
            'sort_order'  => 1,
        ]);
    }

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Dräger Evita V800 Ventilator');
        $response->assertSee('ICU Ventilators');
    }

    public function test_products_catalog_loads_and_filters(): void
    {
        $response = $this->get('/products');
        $response->assertOk();
        $response->assertSee('Dräger Evita V800 Ventilator');

        // Test filtering by category
        $responseCategory = $this->get('/products?category=icu-ventilators');
        $responseCategory->assertOk();
        $responseCategory->assertSee('Dräger Evita V800 Ventilator');

        // Test search query
        $responseSearch = $this->get('/products?q=Evita');
        $responseSearch->assertOk();
        $responseSearch->assertSee('Dräger Evita V800 Ventilator');
    }

    public function test_product_detail_page_loads(): void
    {
        $response = $this->get('/products/' . $this->product->slug);

        $response->assertOk();
        $response->assertSee($this->product->name);
        $response->assertSee('VENT-DRG-V800');
    }

    public function test_static_pages_load(): void
    {
        $this->get('/about')->assertOk();
        $this->get('/services')->assertOk();
        $this->get('/contact')->assertOk();
        $this->get('/faq')->assertOk();
        $this->get('/terms')->assertOk();
        $this->get('/privacy')->assertOk();
    }

    public function test_contact_enquiry_submission(): void
    {
        $response = $this->post('/contact', [
            'name'         => 'Dr. Fatima Bello',
            'email'        => 'fatima@nationalhospital.org',
            'phone'        => '+2348011223344',
            'organization' => 'National Hospital',
            'subject'      => 'Request for ICU setup consultation',
            'message'      => 'We are looking to equip a new 10-bed ICU ward.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('enquiries', [
            'email' => 'fatima@nationalhospital.org',
            'subject' => 'Request for ICU setup consultation',
        ]);
    }

    public function test_cart_operations(): void
    {
        $user = User::factory()->create();

        // 1. Add item to cart
        $addResponse = $this->actingAs($user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity'   => 2,
        ]);

        $addResponse->assertSessionHas('success');

        // 2. View cart
        $viewResponse = $this->actingAs($user)->get('/cart');
        $viewResponse->assertOk();
        $viewResponse->assertSee($this->product->name);
        $viewResponse->assertSee('104,000.00'); // 52,000 * 2
    }

    public function test_checkout_and_order_placement(): void
    {
        $user = User::factory()->create();

        // Add item to cart
        $this->actingAs($user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity'   => 1,
        ]);

        // Access checkout page
        $this->actingAs($user)->get('/checkout')->assertOk();

        // Submit checkout
        $response = $this->actingAs($user)->post('/checkout', [
            'guest_name'         => 'Prof. Emeka Obi',
            'guest_email'        => 'emeka.obi@lagoshospital.com',
            'guest_phone'        => '+2348099887766',
            'organization_name'  => 'Lagos City Hospital',
            'shipping_method_id' => $this->shippingMethod->id,
            'payment_method'     => 'bank_transfer',
            'shipping_address'   => '100 Marina Road, ICU Wing',
            'shipping_city'      => 'Lagos Island',
            'shipping_state'     => 'Lagos',
            'shipping_country'   => 'Nigeria',
            'same_billing'       => 1,
        ]);

        $response->assertRedirect();

        // Verify order created in database
        $this->assertDatabaseHas('orders', [
            'guest_email' => 'emeka.obi@lagoshospital.com',
            'subtotal'    => 52000.00,
        ]);

        // Verify inventory decremented: 5 - 1 = 4
        $this->assertDatabaseHas('inventory', [
            'product_id' => $this->product->id,
            'quantity'   => 4,
        ]);

        // Verify stock movement created
        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $this->product->id,
            'type'       => 'sale',
            'quantity'   => -1,
        ]);
    }

    public function test_quotation_rfq_submission(): void
    {
        $response = $this->post('/quotations/request', [
            'organization_name' => 'Abuja Specialist Medical Center',
            'contact_name'      => 'Dr. Zainab Ahmed',
            'contact_email'     => 'zainab@abujaspecialist.ng',
            'contact_phone'     => '+2348022334455',
            'country'           => 'Nigeria',
            'requirements'      => 'Need tender pricing for 4 ICU ventilators with neonatal kit.',
            'items'             => [
                [
                    'product_id'   => $this->product->id,
                    'product_name' => $this->product->name,
                    'quantity'     => 4,
                    'notes'        => 'Include mobile cart and extended 2-year AMC.',
                ],
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('quotations', [
            'contact_email'     => 'zainab@abujaspecialist.ng',
            'organization_name' => 'Abuja Specialist Medical Center',
        ]);
    }

    public function test_order_tracking_lookup(): void
    {
        $order = Order::create([
            'order_number'       => 'ORD-20261104-TEST1',
            'status'             => 'confirmed',
            'payment_status'     => 'paid',
            'subtotal'           => 50000,
            'shipping_cost'      => 5000,
            'tax_amount'         => 0,
            'discount_amount'    => 0,
            'total'              => 55000,
            'currency'           => 'NGN',
            'shipping_method_id' => $this->shippingMethod->id,
            'guest_name'         => 'Test Hospital',
            'guest_email'        => 'track@hospital.org',
            'guest_phone'        => '0800000000',
            'shipping_snapshot'  => ['name' => 'Test Hospital', 'city' => 'Abuja'],
            'billing_snapshot'   => ['name' => 'Test Hospital'],
        ]);

        $response = $this->get('/orders/track?order_number=ORD-20261104-TEST1&email=track@hospital.org');
        $response->assertOk();
        $response->assertSee('ORD-20261104-TEST1');
        $response->assertSee('confirmed');
    }

    public function test_pdf_downloads(): void
    {
        $order = Order::create([
            'order_number'       => 'ORD-20261104-PDF1',
            'status'             => 'confirmed',
            'payment_status'     => 'paid',
            'subtotal'           => 50000,
            'shipping_cost'      => 5000,
            'tax_amount'         => 0,
            'discount_amount'    => 0,
            'total'              => 55000,
            'currency'           => 'NGN',
            'shipping_method_id' => $this->shippingMethod->id,
            'guest_name'         => 'Test Hospital',
            'guest_email'        => 'pdf@hospital.org',
            'guest_phone'        => '0800000000',
            'shipping_snapshot'  => ['name' => 'Test Hospital', 'city' => 'Abuja'],
            'billing_snapshot'   => ['name' => 'Test Hospital'],
        ]);

        $orderPdf = $this->get("/orders/{$order->order_number}/pdf");
        $orderPdf->assertOk();
        $this->assertEquals('application/pdf', $orderPdf->headers->get('content-type'));

        $quotation = Quotation::create([
            'quotation_number'  => 'QUO-20261104-PDF1',
            'status'            => 'submitted',
            'organization_name' => 'Test Hospital',
            'contact_name'      => 'Dr. Test',
            'contact_email'     => 'test@hospital.org',
            'contact_phone'     => '0800000000',
            'country'           => 'Nigeria',
        ]);

        $quotePdf = $this->get("/quotations/{$quotation->quotation_number}/pdf");
        $quotePdf->assertOk();
        $this->assertEquals('application/pdf', $quotePdf->headers->get('content-type'));
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku', 100)->unique();
            $table->string('model_number', 100)->nullable();
            $table->string('short_description', 500)->nullable();
            $table->text('description');
            $table->text('features')->nullable();
            $table->decimal('price', 12, 2)->nullable()->comment('NULL means quote-only');
            $table->decimal('compare_price', 12, 2)->nullable()->comment('Original price for showing discounts');
            $table->string('pricing_type', 20)->default('fixed')->comment('fixed,quote_only,quote_preferred');
            $table->unsignedInteger('minimum_order_quantity')->default(1);
            $table->text('warranty_info')->nullable();
            $table->decimal('weight', 8, 2)->nullable()->comment('kg');
            $table->string('status', 20)->default('draft')->comment('draft,active,inactive,discontinued');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('sku');
            $table->index('status');
            $table->index('is_featured');
            $table->index('pricing_type');
            $table->index(['category_id', 'status']);
            $table->index(['brand_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('quotation_number', 50)->unique();
            $table->string('status', 30)->default('submitted')
                ->comment('draft,submitted,under_review,quoted,accepted,rejected,converted,expired');
            $table->string('organization_name')->nullable();
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone', 30)->nullable();
            $table->string('country', 100)->nullable();
            $table->text('requirements')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('terms')->nullable();
            $table->decimal('subtotal', 12, 2)->nullable()->comment('Set by admin when quoting');
            $table->date('valid_until')->nullable();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete()->comment('Set when converted to order');
            $table->string('pdf_path', 500)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('quoted_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('quotation_number');
            $table->index('status');
            $table->index(['user_id', 'created_at']);
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 12, 2)->nullable()->comment('Set by admin');
            $table->decimal('subtotal', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('quotation_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('path', 500);
            $table->string('uploaded_by', 20)->default('customer')->comment('customer,admin');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_documents');
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotations');
    }
};

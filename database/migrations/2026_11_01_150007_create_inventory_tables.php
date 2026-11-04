<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique()->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0)->comment('Held by pending orders');
            $table->integer('low_stock_threshold')->default(5);
            $table->boolean('allow_backorder')->default(false);
            $table->timestamp('updated_at')->nullable();

            $table->index('quantity');
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('type', 30)->comment('addition,reduction,adjustment,reserved,released,return');
            $table->integer('quantity')->comment('Positive for additions, negative for reductions');
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->string('reference_type', 100)->nullable()->comment('App\\Models\\Order, manual_adjustment, etc.');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->nullable();

            $table->index(['product_id', 'created_at']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('inventory');
    }
};

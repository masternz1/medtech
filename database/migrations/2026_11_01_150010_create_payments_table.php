<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('provider', 30)->comment('paystack,flutterwave');
            $table->string('reference')->unique()->comment('Payment gateway reference');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('NGN');
            $table->string('status', 30)->default('initiated')
                ->comment('initiated,successful,failed,refunded');
            $table->json('provider_response')->nullable()->comment('Full webhook/verification payload');
            $table->timestamp('verified_at')->nullable()->comment('Server-side verification timestamp');
            $table->timestamps();

            $table->index('reference');
            $table->index('status');
            $table->index(['order_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

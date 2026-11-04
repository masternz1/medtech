<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('path', 500);
            $table->string('alt_text')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['product_id', 'sort_order']);
        });

        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('group_name', 100)->nullable()->comment('e.g. Technical Specifications, Physical Dimensions');
            $table->string('label');
            $table->string('value', 500);
            $table->unsignedInteger('sort_order')->default(0);

            $table->index(['product_id', 'sort_order']);
        });

        Schema::create('product_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type', 50)->default('manual')->comment('manual,datasheet,certificate,brochure,other');
            $table->string('path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size')->nullable()->comment('File size in bytes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_documents');
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('product_images');
    }
};

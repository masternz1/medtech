<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle', 500)->nullable();
            $table->string('image', 500);
            $table->string('link_url', 500)->nullable();
            $table->string('link_text', 100)->nullable();
            $table->string('position', 30)->default('hero')->comment('hero,promotional,category');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable()->comment('e.g. Head of Procurement, St. Mary\'s Hospital');
            $table->string('organization')->nullable();
            $table->text('content');
            $table->unsignedTinyInteger('rating')->nullable()->comment('1-5 stars');
            $table->string('avatar', 500)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon', 100)->nullable()->comment('Lucide icon name');
            $table->string('image', 500)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->text('answer');
            $table->string('category', 100)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group', 100)->default('general')
                ->comment('general,contact,seo,payment,social,email,homepage');
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type', 30)->default('string')
                ->comment('string,boolean,integer,json,text,image');
            $table->string('label')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('services');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('banners');
    }
};

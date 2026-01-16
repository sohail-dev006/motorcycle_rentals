<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motorcycles', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('sort_order')->default(0);

            // Brand
            $table->unsignedBigInteger('brand_id')->nullable();

            // Status & Visibility
            $table->enum('status', ['featured', 'unfeatured'])->default('featured');
            $table->enum('visibility', ['show', 'hide'])->default('show');

            // Pricing
            $table->decimal('base_price', 10, 2)->default(0);
            $table->decimal('extra_price', 10, 2)->default(0);

            // Description & Image
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motorcycles');
    }
};

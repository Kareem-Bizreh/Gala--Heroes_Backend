<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->references('id');
            $table->string('name');
            $table->string('image_url');
            $table->foreignId('category_id')->constrained('categories')->references('id');
            $table->float('price');
            $table->float('price_with_discount')->nullable();
            $table->integer('discount_rate')->default(0);
            $table->date('expiration_date');
            $table->foreignId('period_id')->constrained('periods')->references('id');
            $table->integer('count');
            $table->integer('views')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

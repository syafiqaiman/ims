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
        Schema::create('restock_request', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_weight', 8, 2); // Adjust the precision and scale as needed
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('rack_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('rack_id')->references('id')->on('rack_locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restock_request');
    }
};

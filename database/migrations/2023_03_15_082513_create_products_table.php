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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('rack_id')->nullable();
            $table->string('product_name');
            $table->integer('carton_quantity');
            $table->integer('item_per_carton');
            $table->string('product_desc')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_dimensions')->nullable();
            $table->integer('weight_per_item')->nullable();
            $table->integer('weight_per_carton')->nullable();
            $table->date('date_to_be_stored')->nullable();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('product_name');
            $table->integer('carton_quantity'); 
            $table->integer('item_per_carton'); 
            $table->string('product_desc');
            $table->string('product_image');
            $table->string('product_dimensions');
            $table->integer('weight_per_item');
            $table->integer('weight_per_carton');
            $table->date('date_to_be_stored');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

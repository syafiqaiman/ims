<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_request', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('product_name');
            $table->text('product_desc')->nullable();
            $table->integer('carton_quantity')->nullable();
            $table->integer('item_per_carton')->nullable();
            $table->string('product_dimensions')->nullable();
            $table->integer('weight_per_item')->nullable();
            $table->integer('weight_per_carton')->nullable();
            $table->decimal('total_weight', 10, 2)->nullable();
            $table->decimal('product_price', 10, 2)->nullable();
            $table->string('product_image')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('Under Review');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_request');
    }
};

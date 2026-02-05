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
        Schema::create('delivery', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            $table->unsignedBigInteger('user_id');
            $table->string('sender_name');
            $table->string('sender_address');
            $table->string('sender_postcode');
            $table->string('sender_state');
            $table->string('sender_phone');
            $table->string('receiver_name');
            $table->string('receiver_address');
            $table->string('receiver_postcode');
            $table->string('receiver_state');
            $table->string('receiver_phone');
            $table->string('status')->default('Pending');
            $table->timestamps();
        });

        // Pivot table for delivery-product relationship
        Schema::create('delivery_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_product');
        Schema::dropIfExists('delivery');
    }
};

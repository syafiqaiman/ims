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
        Schema::create('return_stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('return_no')->nullable();
            $table->string('receive_status')->default('Pending');
            $table->timestamps();
        });

        // Pivot table for return_stock-product relationship
        Schema::create('return_stock_pivot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('return_stock_id');
            $table->unsignedBigInteger('product_id');
            $table->string('status')->nullable();
            $table->integer('quantity')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_stock_pivot');
        Schema::dropIfExists('return_stock');
    }
};

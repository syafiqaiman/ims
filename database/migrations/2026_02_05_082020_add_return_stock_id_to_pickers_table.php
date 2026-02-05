<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pickers', function (Blueprint $table) {
            $table->unsignedBigInteger('return_stock_id')->nullable();
            $table->string('status')->nullable();
            $table->string('order_no')->nullable();
            $table->unsignedBigInteger('rack_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pickers', function (Blueprint $table) {
            $table->dropColumn(['return_stock_id', 'status', 'order_no', 'rack_id']);
        });
    }
};

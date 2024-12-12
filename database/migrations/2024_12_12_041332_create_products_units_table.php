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
        Schema::create('products_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');  // `product_id` sẽ sử dụng `bigint`
            $table->unsignedBigInteger('unit_id');  // `unit_id` cũng sẽ sử dụng `bigint`
            $table->integer('conversion_rate')->default(1); // Hệ số quy đổi
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_units');
    }
};

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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // `product_id` sử dụng `bigint`
            $table->decimal('purchase_price', 10, 2)->nullable();    // Giá nhập
            $table->decimal('sale_price', 10, 2)->nullable();        // Giá bán
            $table->decimal('declared_price', 10, 2)->nullable();    // Giá kê khai
            $table->decimal('cost_price', 10, 2)->nullable();        // Giá nhập giá vốn
            $table->decimal('listed_price', 10, 2)->nullable();      // Giá niêm yết
            $table->decimal('specific_cost', 10, 2)->nullable();     // Giá vốn đích danh
            $table->decimal('hapu_price', 10, 2)->nullable();        // Giá Hapu
            $table->date('hapu_price_updated')->nullable();          // Ngày cập nhật giá Hapu
            $table->decimal('min_sale_price', 10, 2)->nullable();    // Giá bán tối thiểu
            $table->decimal('max_sale_price', 10, 2)->nullable();    // Giá bán tối đa
            $table->timestamps(); // Tạo các cột created_at và updated_at

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};

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
            $table->unsignedBigInteger('product_id');
            $table->decimal('import_price', 15, 2); // Giá nhập
            $table->decimal('sell_price', 15, 2); // Giá bán
            $table->decimal('min_price', 15, 2)->nullable(); // Giá bán tối thiểu
            $table->decimal('max_price', 15, 2)->nullable(); // Giá bán tối đa
            $table->date('updated_at_price')->nullable(); // Ngày cập nhật giá
            $table->timestamps();

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

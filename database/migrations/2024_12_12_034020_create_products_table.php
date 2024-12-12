<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên hàng
            $table->string('short_name')->nullable(); // Tên tắt
            $table->string('specification')->nullable(); // Quy cách
            $table->unsignedBigInteger('category_id'); // Loại hàng
            $table->unsignedBigInteger('group_id')->nullable(); // Nhóm hàng
            $table->string('registration_number')->nullable(); // Số ĐKCL
            $table->text('notes')->nullable(); // Ghi chú thêm

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}

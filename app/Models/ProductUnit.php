<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;

    // Bảng liên kết với model này
    protected $table = 'products_units';

    // Các thuộc tính được phép gán hàng loạt (mass assignable)
    protected $fillable = [
        'product_id',
        'unit_id',
        'conversion_rate',
    ];

    /**
     * Mối quan hệ với bảng `Product`
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Mối quan hệ với bảng `Unit`
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}

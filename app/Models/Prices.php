<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'purchase_price',
        'sale_price',
        'declared_price',
        'cost_price',
        'listed_price',
        'specific_cost',
        'hapu_price',
        'hapu_price_updated',
        'min_sale_price',
        'max_sale_price',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

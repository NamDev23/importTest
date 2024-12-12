<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'import_price',
        'sell_price',
        'min_price',
        'max_price',
        'updated_at_price'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

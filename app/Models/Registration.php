<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'certificate_no', 'details'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

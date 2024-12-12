<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'specification',
        'category_id',
        'group_id',
        'registration_number',
        'notes',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'products_units')->withPivot('conversion_rate');
    }

    public function prices()
    {
        return $this->hasOne(Prices::class);
    }
    public function storages()
    {
        return $this->belongsToMany(Storage::class, 'product_storage');
    }
}

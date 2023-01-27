<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_category_id',
        'name',
        'sequence',
        'desc',
        'price',
        'duration',
        'status',
    ];

    public function product_items(){
        return $this->hasMany(ProductItem::class, 'id', 'product_id');
    }
    public function product_category(){
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }
}

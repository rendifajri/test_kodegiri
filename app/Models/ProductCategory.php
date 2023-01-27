<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'sequence',
        'desc',
        'status',
    ];

    public function products(){
        return $this->hasMany(Product::class, 'id', 'product_category_id');
    }
}

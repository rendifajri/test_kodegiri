<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCategory extends Model
{
    protected $fillable = [
        'name',
        'sequence',
        'desc',
        'status',
    ];

    public function payments(){
        return $this->hasMany(Payment::class, 'id', 'payment_category_id');
    }
}

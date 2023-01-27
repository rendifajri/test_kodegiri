<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_category_id',
        'name',
        'sequence',
        'desc',
        'consumer_key',
        'consumer_secret',
        'status',
    ];

    public function payment_category(){
        return $this->belongsTo(PaymentCategory::class, 'payment_category_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'product_id',
        'customer_id',
        'payemtn_id',
        'code',
        'reference_number',
        'consumer_key',
        'consumer_secret',
        'start_date',
        'end_date',
        'amount',
        'status',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function payment(){
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'name',
        'sequence',
        'status',
    ];

    public function bookings(){
        return $this->hasMany(Booking::class, 'id', 'session_id');
    }
}

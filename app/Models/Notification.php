<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'desc',
        'read',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

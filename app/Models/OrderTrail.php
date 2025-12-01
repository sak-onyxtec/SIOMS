<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTrail extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'status',
    ];

    protected $casts = [
        'order_id' => "integer",
        'user_id' => "integer",
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

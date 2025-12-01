<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'total',
    ];

    protected $casts = [
        'user_id' => "integer"
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trails()
    {
        return $this->hasMany(OrderTrail::class, 'order_id', 'id');
    }
}

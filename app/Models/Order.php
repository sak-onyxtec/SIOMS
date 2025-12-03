<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'total',
        'payment_method',
        'stripe_session_id',
        'stripe_payment_intent_id',
        'paid_at',
        'stripe_refund_id',
        'refunded_at',
    ];

    protected $casts = [
        'user_id' => "integer",
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
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

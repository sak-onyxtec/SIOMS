<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductChangeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'action_by',
        'action',
        'before',
        'after',
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'action_by');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

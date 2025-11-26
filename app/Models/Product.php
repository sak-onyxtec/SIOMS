<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'sku', 'category', 'quantity', 'price'];

    protected $casts = [
        "quantity" => "integer",
        "is_active" => "boolean"
    ];


    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getProductImageAttribute($value)
    {
        return $value ? asset("storage/uploads/products/{$value}") : null;
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'product_id', 'id');
    }

    public function change_logs()
    {
        return $this->hasMany(ProductChangeLog::class, 'product_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'short_description',
        'description',
        'slug',
        'sku',
        'category_id',
        'quantity',
        'price',
        'product_image',
    ];

    protected $casts = [
        "quantity" => "integer",
        "is_active" => "boolean"
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug) && !empty($product->name)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });

        static::updating(function ($product) {
            // Regenerate slug if name changed and slug wasn't explicitly set
            if ($product->isDirty('name') && !$product->isDirty('slug')) {
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    protected static function generateUniqueSlug($name, $excludeId = null)
    {
        $baseSlug = \Illuminate\Support\Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        $query = static::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
            $query = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }


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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function change_logs()
    {
        return $this->hasMany(ProductChangeLog::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id')->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'id')->where('is_primary', true);
    }
}

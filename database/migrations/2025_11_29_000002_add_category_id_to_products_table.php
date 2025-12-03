<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->after('sku')
                ->constrained('categories')
                ->nullOnDelete();
        });

        // Attempt to backfill category_id from existing string column, if present
        if (Schema::hasColumn('products', 'category')) {
            $categories = Product::query()
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->select('category')
                ->distinct()
                ->pluck('category');

            foreach ($categories as $name) {
                $slug = \Illuminate\Support\Str::slug($name);
                $category = Category::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $name]
                );

                Product::where('category', $name)->update([
                    'category_id' => $category->id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};






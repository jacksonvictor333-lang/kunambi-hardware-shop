<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'sku',
        'unit',
        'buying_price',
        'selling_price',
        'quantity',
        'minimum_stock',
        'description',
        'status',
    ];

    protected $casts = [
        'buying_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'quantity' => 'integer',
        'minimum_stock' => 'integer',
    ];

    protected $appends = [
        'stock_status',
    ];

    /**
     * Category this product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Brand this product belongs to.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Stock movements recorded for this product.
     */
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Computed stock status: out | low | in.
     * Used by products/index.blade.php and inventory/index.blade.php.
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->quantity <= 0) {
            return 'out';
        }

        if ($this->quantity <= $this->minimum_stock) {
            return 'low';
        }

        return 'in';
    }
}
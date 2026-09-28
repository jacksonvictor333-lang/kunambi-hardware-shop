<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'reference',
        'reason',
        'unit_cost',
        'user_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'quantity_before' => 'integer',
        'quantity_after' => 'integer',
        'unit_cost' => 'decimal:2',
    ];

    /**
     * Product associated with this stock movement.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * User who performed the stock movement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check whether this is stock in.
     */
    public function isStockIn(): bool
    {
        return $this->type === 'stock_in';
    }

    /**
     * Check whether this is stock out.
     */
    public function isStockOut(): bool
    {
        return $this->type === 'stock_out';
    }

    /**
     * Check whether this is an adjustment.
     */
    public function isAdjustment(): bool
    {
        return $this->type === 'adjustment';
    }
}

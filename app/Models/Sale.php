<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'subtotal',
        'discount',
        'total',
        'paid_amount',
        'balance',
        'payment_method',
        'status',
        'user_id',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    /**
     * Sale belongs to a customer.
     *
     * customer_id is currently nullable because
     * Customers module will be connected later.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Sale belongs to the user/cashier
     * who created the sale.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * One sale has many sale items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Check whether sale is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check whether sale is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check whether sale is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check whether sale has an outstanding balance.
     */
    public function hasBalance(): bool
    {
        return (float) $this->balance > 0;
    }

    /**
     * Check whether sale has been fully paid.
     */
    public function isFullyPaid(): bool
    {
        return (float) $this->balance <= 0;
    }
}
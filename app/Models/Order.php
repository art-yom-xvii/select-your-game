<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'customer_email',
        'customer_name',
        'customer_phone',
        'billing_address',
        'shipping_address',
        'payment_method',
        'payment_id',
        'paid_at',
        'subtotal',
        'tax',
        'shipping_cost',
        'discount',
        'total',
        'shipping_method',
        'tracking_number',
        'shipped_at',
        'customer_notes',
        'admin_notes',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'metadata' => 'json',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'SYG-'; // Select Your Game prefix
        $date = now()->format('Ymd');
        $randomString = strtoupper(substr(uniqid(), -4));

        $orderNumber = $prefix . $date . '-' . $randomString;

        // Ensure uniqueness
        while (static::query()->where('order_number', $orderNumber)->exists()) {
            $randomString = strtoupper(substr(uniqid(), -4));
            $orderNumber = $prefix . $date . '-' . $randomString;
        }

        return $orderNumber;
    }
}

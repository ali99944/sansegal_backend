<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code', 'status', 'first_name', 'last_name', 'email', 'phone',
        'secondary_phone', 'address', 'secondary_address', 'city', 'special_mark',
        'subtotal', 'shipping_cost', 'tax_amount', 'promo_code', 'promo_discount', 'grand_total'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function trackingHistory(): HasMany
    {
        return $this->hasMany(OrderTracking::class)->orderBy('created_at', 'asc');
    }
}

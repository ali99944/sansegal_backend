<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'guest_cart_token',
        'product_id',
        'quantity',
        // 'price_at_add',
        // 'addons_data',
    ];

    protected $casts = [
        'quantity' => 'integer',
        // 'price_at_add' => 'decimal:2',
        // 'addons_data' => 'array',
    ];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}

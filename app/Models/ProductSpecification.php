<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpecification extends Model
{
    use HasFactory;
    protected $table = 'product_specifications';
    protected $fillable = ['product_id', 'spec_key', 'spec_value'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'en_name',
        'ar_name',
        'en_description',
        'ar_description',
        'image',
        'original_price',
        'discount',
        'discount_type',
        'specifications',
    ];

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Define the many-to-many relationship with AppModel.
     * We explicitly specify the foreign keys to match our migration.
     */
    public function models(): BelongsToMany
    {
        return $this->belongsToMany(AppModel::class, 'model_product', 'product_id', 'model_id');
    }


    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }


    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class);
    }
}

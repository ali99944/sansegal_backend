<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AppModel extends Model
{
    use HasFactory;

    protected $table = 'models'; // Specify table name to avoid pluralization issues

    protected $fillable = [
        'image',
        'width',
        'height',
    ];

    /**
     * Define the many-to-many relationship with Product.
     * We explicitly specify the foreign keys to match our migration.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'model_product', 'model_id', 'product_id');
    }
}

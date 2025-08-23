<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'type', 'value', 'max_uses', 'uses', 'expires_at', 'is_active',
    ];

    protected $casts = [
        'value' => 'float',
        'max_uses' => 'integer',
        'uses' => 'integer',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}

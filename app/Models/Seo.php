<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;
    protected $fillable = [
        'key', 'title', 'description', 'keywords', 'canonical_url',
        'og_title', 'og_description', 'og_image', 'og_type', 'structured_data',
    ];

    protected $casts = ['structured_data' => 'array'];
}

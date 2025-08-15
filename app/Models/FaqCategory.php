<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqCategory extends Model
{

    public $table = 'faq_categories';

    protected $fillable = [
        'name',
        'position'
    ];

    public function faqs(): HasMany {
        return $this->hasMany(Faq::class);
    }
}

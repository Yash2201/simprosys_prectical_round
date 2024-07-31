<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'price',
        'status',
    ];

    // Getting The Associated categories
    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }
}

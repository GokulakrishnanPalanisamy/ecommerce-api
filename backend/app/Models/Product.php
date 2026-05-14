<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[Fillable(['name', 'category_id', 'slug', 'price', 'stock', 'description'])]
class Product extends Model
{
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}

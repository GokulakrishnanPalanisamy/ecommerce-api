<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug', 'price', 'stock', 'description'])]
#[ObservedBy(ProductObserver::class)]

class Product extends Model
{
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}

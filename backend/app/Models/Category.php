<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name','slug','description'])]
#[ObservedBy(CategoryObserver::class)]

class Category extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}

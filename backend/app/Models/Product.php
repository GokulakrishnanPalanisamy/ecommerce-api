<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['name', 'category_id', 'slug', 'price', 'stock', 'description'])]
class Product extends Model
{
    //
}

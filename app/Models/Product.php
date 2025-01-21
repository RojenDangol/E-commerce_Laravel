<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Wardrobe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function wardrobe(){
        return $this->belongsTo(Wardrobe::class,'wardrobe');
    }
}

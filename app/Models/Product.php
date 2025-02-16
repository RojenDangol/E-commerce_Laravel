<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Wardrobe;
use App\Models\ProductMeta;
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

    public function meta()
    {
        return $this->hasMany(ProductMeta::class);
    }

    public function setMetaValue($key, $value)
    {
        $meta = $this->meta()->updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? implode(',', $value) : $value]
        );
        return $meta;
    }

    public function getMetaValue($key)
    {
        $meta = $this->meta()->where('key', $key)->first();
        return $meta ? explode(',', $meta->value) : null;
    }

}

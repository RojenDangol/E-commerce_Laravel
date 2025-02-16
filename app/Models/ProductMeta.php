<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductMeta extends Model
{
    use HasFactory;
    protected $table = 'product_metas';
    
    protected $fillable = [
        'product_id', // the foreign key
        'key',        // the metadata key
        'value',      // the metadata value
    ];
}

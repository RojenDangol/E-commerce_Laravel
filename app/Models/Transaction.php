<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function order(){
        return $this->belongsTo(Order::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $with = ['order','product'];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    // has one gives error so using belongsTo
    public function product(){
        return $this->belongsTo(Product::class);
    }
}

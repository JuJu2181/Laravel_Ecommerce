<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubVendor extends Model
{
    use HasFactory;

    // relation between a vendor and a subvendor
    public function vendor(){
        return $this->belongsTo(User::class,'user_id');
    }
}

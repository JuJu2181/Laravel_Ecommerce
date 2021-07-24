<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubVendor extends Model
{
    use HasFactory;

    protected $table = "subvendors";

    protected $fillable = [
        'name',
        'email',
        'vendor_id',
        'responsibility'
    ];


    // relation between a vendor and a subvendor
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');
    }
}

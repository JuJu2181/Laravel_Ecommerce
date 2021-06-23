<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    //* relationship between comment and user 
    public function author(){
    // if the name of the function is different from the table name we need to explicitly specify the column name i-e user id
    return $this->belongsTo(User::class,'user_id');
    }

    //* relationship between comment and post
    public function post(){
        return $this->belongsTo(Post::class);
    }

    // * functions to access child comments
    public function children(){
        return $this->hasMany('App\Models\Comment','parent_id');
    }
}

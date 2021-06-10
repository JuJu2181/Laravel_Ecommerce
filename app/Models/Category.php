<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
    ];
    // default attributes for model
    protected $attributes = [
        'image' => '',
    ];
    // * relation between category and product 
    public function products(){
        return $this->hasMany(Product::class);
    }
    // * functions to access child categories
    public function children(){
        return $this->hasMany('App\Models\Category','parent_id');
    }
    // relation between category and post 
    public function posts(){
        return $this->hasMany(Post::class);
    }
}

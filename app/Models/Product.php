<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'slug',
        'image',
        'category_id',
    ];
    // default attributes for model
    protected $attributes = [
        'image' => '',
    ];

    // * instead of defining with in the route it can be directly defined in the model if it is widely used  amd we can sue without to remove with in route
    protected $with = ['category'];


    // * relation between product and category 
    //hasOne,hasMany,belongsTo,belongsToMany
    // here a belongsTo takes the relationship class as well as a foreign key
    // here the belongsTo function assumes the foreign key name based on the function name implicitly so if here we donb't specify the foreign_key name explicitly this belongsTo relationship will refer to the category_id by default
    // in case we named the function as cat then it will refer to cat_id in db so we get error and in such cases we need to explicitly define the foreign key in belongsTo() 
    public function category(){
        return $this->belongsTo(Category::class);
    }

}

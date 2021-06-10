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

    public function user(){
        return $this->belongsTo(User::class);
    }
    

    //* function for search scope to search products
    // this acts as a query builder for the search query 
    public function scopeSearch($query, array $terms){ 
        // getting search key and category from the search query
        $search = $terms['search'];
        $category = $terms['category'];
        // * alternative for using if we can use when
        // using closure for modifying sql for properly selecting category
        $query->when($search, function($query, $search){
            $query->where(function($query) use ($search){
                return $query->where('name', 'like', '%'. $search .'%')
                ->orWhere('description', 'like', '%'. $search .'%')->orWhere('slug', 'like', '%'. $search .'%');
            });
        }

        // * this function returns all the products when no input is given
        // , function($query){
        //     return $query->where('id', '>', 0);
        // }
        );

        $query->when($category, function($query, $category){
            return $query->whereCategoryId($category);

        });



        // * using if for category builder
        // if($search){
        //     $query->where(function($query) use ($search){
        //         return $query->where('name', 'like', '%'. $search .'%')
        //         ->orWhere('description', 'like', '%'. $search .'%')->orWhere('slug', 'like', '%'. $search .'%');
        //     });
        // }
        return $query;
    }

}

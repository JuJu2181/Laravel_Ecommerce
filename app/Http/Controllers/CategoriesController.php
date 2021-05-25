<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(){
        //? fetching from db
        $categories = Category::all();
        return view(
            'category.index',
            ['categories' => $categories]
        );
    }

    public function getSingle(Category $category){
        // * accessing product normally with categoryId
        // $products = Product::whereCategoryid($category->id)->get();
        // * accessing product for category using the eloquent relationship
        $products = $category->products;
        $categories = Category::all();
        return view(
            'category.single',
            ['products'=>$products,
            'category'=>$category,
            'categories'=>$categories]
        );
    }
}

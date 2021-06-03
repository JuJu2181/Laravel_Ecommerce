<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(){
        //? fetching from db
        // $categories = Category::latest('id')->get();
        $categories = Category::with('children')->whereParentId(0)->get();
        // return $categories;
        return view(
            'category.index',
            ['categories' => $categories]
        );
    }

    public function getSingle(Category $category){
        // * accessing product normally with categoryId
        // $products = Product::whereCategoryid($category->id)->get();
        // * accessing product for category using the eloquent relationship with its children
        $categories = Category::with('children')->get();
        // return $categories;
        // * By default if it has no children then products will be sent to next page
        $products_or_subcategories = $category->products;
        $title = "Products";
        $nxtroute = 'product.single';
        // $categories = Category::all();
        $categoryWithChilds = Category::with('children')->find($category->id);
        // * if it has children then we modify default values
        if($categoryWithChilds->children->count() > 0){
            $products_or_subcategories = $categoryWithChilds->children;
            $title = "Sub Categories";
            $nxtroute = 'category.single';
        }
        return view(
            'category.single',
            ['products_or_subcategories'=>$products_or_subcategories,
            'category'=>$categoryWithChilds,
            
            'title'=>$title,
            'nxtroute'=>$nxtroute,
            ]
        );
    }
}

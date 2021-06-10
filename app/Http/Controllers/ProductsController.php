<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;


class ProductsController extends Controller
{
    
    public function index(){
        $max_price = Product::orderBy('price','desc')->first()->price;
        //? fetching from db
        if(request('count') >= 4 && request('sort-method') != null && request('sort-order') != null && request('max-price') <= $max_price && request('product_category') >= 0){
            $sort_method = request('sort-method');
            $pagination_count = request('count');
            $sort_order = request('sort-order');
            $max_price = request('max-price');
            $product_category = request('product_category');
        }else{
            $sort_method = 'created_at';
            $pagination_count = 4;
            $sort_order = 'desc';
            $product_category = 0;
        }
        if($product_category > 0){
            $products = Product::orderBy($sort_method,$sort_order)->where('price','<',$max_price)->where('category_id','=',$product_category)->paginate($pagination_count);
        }else{
            $products = Product::orderBy($sort_method,$sort_order)->where('price','<',$max_price)->paginate($pagination_count);
        }
        $categories = Category::all();
        $categories_with_children = Category::with('children')->get();
        $categories_for_filter = [];
        foreach($categories_with_children as $category_with_child){
            if($category_with_child->children->count() == 0){
                array_push($categories_for_filter,$category_with_child);
            }
        }
        return view(
            'products.index',
            ['products' => $products,
            'categories' => $categories,
            'categories_for_filter'=>$categories_for_filter,
            ]
        );
    }
    // using route model binding to find that product automatically
    public function getSingle(Product $product){
        return view('products.single',['product'=>$product]);
    }
}

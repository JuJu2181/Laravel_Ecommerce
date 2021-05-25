<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductsController extends Controller
{
    
    public function index(){
        //? fetching from db
        $products = Product::all();
        $categories = Category::all();
        return view(
            'products.index',
            ['products' => $products,
            'categories' => $categories
            ]
        );
    }
    // using route model binding to find that product automatically
    public function getSingle(Product $product){
        return view('products.single',['product'=>$product]);
    }
}

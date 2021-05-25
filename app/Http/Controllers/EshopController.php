<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Post;

class EshopController extends Controller
{
    //for getting home view
    public function index(){
        // * to get the latest post we use id instead of created_at
    // select * from products order by created_at desc
    // using with will fetch the category when fetching the product so it will reduce the sql queries in backend and hence improves performance
    // $products = Product::latest('id')->without('category')->get();
    $products = Product::latest('id')->get();
    // $products = Product::all();
    $categories = Category::all();
    $posts = Post::all();
    return view('eshop.index',['products'=>$products,'categories'=>$categories,'posts'=>$posts]);
    }

    public function getShopGrid(){
        $categories = Category::all();
        return view('eshop.shop-grid',['categories'=>$categories]);
    }

    public function getCart(){
        return view('eshop.cart');
    }

    public function getCheckout(){
        return view('eshop.checkout');
    }

    public function getContact(){
        return view('eshop.contact');
    }

    public function getBlog(){
        return view('eshop.blog-single-sidebar');
    }

}

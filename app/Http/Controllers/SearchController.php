<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    //serach using controller
    // public function search(){
    //     // this will only give value or text
    //     // return request('search');
    //     // this will return array
    //     // return request(['search']);
    //     // * main implementation
    // //   SELECT * FROM products where product_name like '%mobile%' or product_desc like '%mobile%'
    // // using eloquent
    // $products = Product::latest(); 
    //     if(request('search') != null){
    //         $products->where('name','like','%'.request('search').'%')->orWhere('description','like','%'.request('search').'%')->orWhere('slug','like','%'.request('search').'%');
    //     }
    // // return $products->get();
    // return view('products',['products',$products->get()]);
    // }
    // * Alternatively we can do the same thing inside model by making a localScope method and it is much better as we don't need to repeat code.
    #search for local scope
    public function search(){
        // search is the method here that acts as query builder
    $products = Product::latest('id')->search(request(['search', 'category']))->get();
    // * No need to use it here as we are using the querybuilder in model
    // if(request('search') != null){
        //     $products->where('name','like','%'.request('search').'%')->orWhere('description','like','%'.request('search').'%')->orWhere('slug','like','%'.request('search').'%');
        // }
    // return $products->get();
    // return view('products',['products',$products->get()]);
    if(request('search') != null && request('category') > 0){
        $search_category = Category::find(request('category'))->name;
        $search_title = "All The Search Results For ".request('search')." In ".$search_category." (".count($products).")";
    }else{
        if(request('search')){
            $search_title = "All The Search Results For ".request('search')." In All Categories (".count($products).")";
        }elseif (request('category') > 0) {
            $search_category = Category::find(request('category'))->name;
            $search_title = "All The Products In ".$search_category." (".count($products).")";
        }else{
            $search_title = "All The Products In All Categories"." (".count($products).")";
        }
    }
    return view('products.search_result', ['products' => $products,'search_title'=>$search_title]);
    }
}

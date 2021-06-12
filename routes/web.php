<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\EshopController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// for using auth routes 
require __DIR__.'/auth.php';


//* for eshop template 
// using controllers
Route::get('/', [EshopController::class, 'index'])->name('eshop.home');

Route::get('/shop-grid/', [EshopController::class, 'getShopGrid'])->name('eshop.shop-grid');

Route::get('/shop/{vendor}',[EshopController::class,'getSingleShop'])->name('eshop.getSingleShop');

Route::get('/contact/', [EshopController::class, 'getContact'])->name('eshop.contact');

// Route for replying contact
Route::post('/contact_reply/',[EshopController::class,'sendContactReply'])->name('eshop.reply_contact');

Route::get('/checkout_template/', [EshopController::class, 'getCheckout'])->middleware('auth')->name('eshop.checkout');

Route::post('/checkout/email',[EshopController::class,'sendCheckoutEmail'])->middleware('auth')->name('eshop.checkout.email');

Route::get('/checkout/confirm/{email}/{id}',[EshopController::class,'confirmOrder'])->middleware('auth')->name('eshop.checkout.confirm');

Route::post('checkout/confirm_code',[EshopController::class,'confirmCode'])->middleware('auth')->name('eshop.checkout.confirm_code');

Route::get('order_completed',[EshopController::class,'getCompletedOrder'])->middleware('auth')->name('eshop.completed_order');

Route::get('/cart_template/', [EshopController::class, 'getCart'])->middleware('auth')->name('eshop.cart');

Route::get('/blog-single/', [EshopController::class, 'getBlog'])->name('eshop.blog-single');

//for products
Route::get('/products/', [ProductsController::class, 'index'])->name('product.index');

Route::get('/product/{product}/', [ProductsController::class, 'getSingle'])->name('product.single');


// for categories
Route::get('/categories/', [CategoriesController::class, 'index'])->name('category.index');

Route::get('/category/{category}/', [CategoriesController::class, 'getSingle'])->name('category.single');

// for posts

//? getting all posts
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

//? geting a single post by id
Route::get('/post/{post}', [PostController::class, 'getSingle'])->name('post.single');

// ? for search 
Route::get('search',[SearchController::class,'search'])->name('products.search');


//*For Admin Panel routes
// * to add the same middleware to all the admin items we can use the route group
// * for verification we need to add a middleware verified 
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    //?for crud of products
    // Route::get('products', [App\Http\Controllers\Admin\ProductsController::class, 'index'])->name("products.index");

    // Route::get('products/create', [App\Http\Controllers\Admin\ProductsController::class, 'create'])->name("products.create");

    // Route::post('products/store', [App\Http\Controllers\Admin\ProductsController::class, 'store'])->name("products.store");

    // Route::get('products/{product}/edit', [App\Http\Controllers\Admin\ProductsController::class, 'edit'])->name("products.edit");

    // Route::put('products/{product}/update', [App\Http\Controllers\Admin\ProductsController::class, 'update'])->name("products.update");

    // Route::delete('products/{product}/delete', [App\Http\Controllers\Admin\ProductsController::class, 'destroy'])->name("products.delete");
    // * using resourceful routing it auto generates all resource routes
    Route::resource('products', App\Http\Controllers\Admin\ProductsController::class);
    // for redirecting to the delete page if used 
    Route::get('products/delete/{product}',[App\Http\Controllers\Admin\ProductsController::class,'delete'])->name("products.deletePage");

    // * for crud of categories 
    // Route::get('categories', [App\Http\Controllers\Admin\CategoriesController::class, 'index'])->name("categories.index");

    // Route::get('categories/create', [App\Http\Controllers\Admin\CategoriesController::class, 'create'])->name("categories.create");

    // Route::post('categories/store', [App\Http\Controllers\Admin\CategoriesController::class, 'store'])->name("categories.store");

    // Route::get('categories/{category}/edit', [App\Http\Controllers\Admin\CategoriesController::class, 'edit'])->name("categories.edit");

    // Route::put('categories/{category}/update', [App\Http\Controllers\Admin\CategoriesController::class, 'update'])->name("categories.update");

    // Route::delete('categories/{category}/delete', [App\Http\Controllers\Admin\CategoriesController::class, 'destroy'])->name("categories.delete");
    // * resourceful routing 
    Route::resource('categories', App\Http\Controllers\Admin\CategoriesController::class);

    // ?for dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ? for users 
    Route::resource('users',App\Http\Controllers\Admin\UsersController::class);

    // ? for posts 
    Route::resource('posts',App\Http\Controllers\Admin\PostsController::class);

    // ? for orders 
    Route::resource('orders', App\Http\Controllers\Admin\OrdersController::class);

    Route::get('orders_for_vendors',[App\Http\Controllers\Admin\OrdersController::class,'getVendorOrders'])->name('orders.getVendorOrders');

    Route::get('pending_orders_for_vendors',[App\Http\Controllers\Admin\OrdersController::class,'getPendingVendorOrders'])->name('orders.getPendingVendorOrders');

    Route::get('completed_orders_for_vendors',[App\Http\Controllers\Admin\OrdersController::class,'getCompletedVendorOrders'])->name('orders.getCompletedVendorOrders');

    Route::get('shipping_details_for_order/{item_id}',[App\Http\Controllers\Admin\OrdersController::class,'getShippingDetailsForOrder'])->name('orders.getShippingDetailsForOrder');

    // ? for shipping details 
    // Route::resource('shipping_details',App\Http\Controllers\Admin\ShippingDetailsController::class);

    Route::post('complete_order_by_vendor',[App\Http\Controllers\Admin\OrdersController::class,'completeOrderByVendor'])->name('orders.completeOrderByVendor');

    // for contact details 
    Route::resource('contacts',App\Http\Controllers\Admin\ContactController::class);
});


// * For Order Cart Routes
Route::resource('/order', OrderController::class);
Route::resource('/cart', OrderItemController::class)->middleware('auth');

// get all sub categories with category 0 as parent
Route::get('test',function(){
    //return App\Models\Category::where('parent_id',0)->get();
    foreach(App\Models\Category::where('parent_id',0)->get() as $category){
        if($category->children->count() > 0){
            echo "<pre>";
            echo($category->children);
            echo "</pre>";
        }else{
            echo "<pre>";
            echo($category);
            echo "</pre>";
        }
    }
});


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

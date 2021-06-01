<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\EshopController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Post;
use App\Models\Category;
use GuzzleHttp\Promise\Create;


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




//* for eshop template 
// using controllers
Route::get('/', [EshopController::class, 'index'])->name('eshop.home');

Route::get('/shop-grid/', [EshopController::class, 'getShopGrid'])->name('eshop.shop-grid');

Route::get('/contact/', [EshopController::class, 'getContact'])->name('eshop.contact');

Route::get('/checkout/', [EshopController::class, 'getCheckout'])->name('eshop.checkout');

Route::get('/cart/', [EshopController::class, 'getCart'])->name('eshop.cart');

Route::get('/blog-single/', [EshopController::class, 'getBlog'])->name('eshop.blog-single');

//for products
Route::get('/products/', [ProductsController::class, 'index'])->name('product.index');

Route::get('/product/{product}/', [ProductsController::class, 'getSingle'])->name('product.single');


// for categories
Route::get('/categories/', [CategoriesController::class, 'index'])->name('category.index');

Route::get('/category/{category}/', [CategoriesController::class, 'getSingle'])->name('category.single');

// for posts
Route::get('/create_post/', [PostController::class, 'createPost'])->name('post.create');

//? getting all posts
Route::get('/posts', [PostController::class, 'index'])->name('post.index');

//? geting a single post by id
Route::get('/post/{post}', [PostController::class, 'getSingle'])->name('post.single');




//*For Admin Panel routes
//?for crud of products
Route::get('/admin/products', [App\Http\Controllers\Admin\ProductsController::class, 'index'])->name("admin.products.index");

Route::get('/admin/products/create', [App\Http\Controllers\Admin\ProductsController::class, 'create'])->name("admin.products.create");

Route::post('/admin/products/store', [App\Http\Controllers\Admin\ProductsController::class, 'store'])->name("admin.products.store");

Route::get('/admin/products/edit/{product}', [App\Http\Controllers\Admin\ProductsController::class, 'edit'])->name("admin.products.edit");

Route::put('/admin/products/update/{product}', [App\Http\Controllers\Admin\ProductsController::class, 'update'])->name("admin.products.update");

Route::delete('/admin/products/delete/{product}', [App\Http\Controllers\Admin\ProductsController::class, 'destroy'])->name("admin.products.delete");
// for redirecting to the delete page if used 
Route::get('/admin/products/delete/{product}',[App\Http\Controllers\Admin\ProductsController::class,'delete'])->name("admin.products.deletePage");

// * for crud of categories 



// ?for dashboard
Route::get('/admin/', [DashboardController::class, 'index'])->name('admin.dashboard');


// for authentication
Auth::routes();

Route::get('/home/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

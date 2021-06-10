<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class EshopController extends Controller
{
    //for getting home view
    public function index(){
        // * to get the latest post we use id instead of created_at
    // select * from products order by created_at desc
    // using with will fetch the category when fetching the product so it will reduce the sql queries in backend and hence improves performance
    // $products = Product::latest('id')->without('category')->get();
    $products = Product::latest('id')->get();
    // $paginated_products = Product::latest('id')->paginate(6);
    $paginated_products = Product::latest('id')->take(6)->get();
    // $products = Product::all();
    $categories = Category::all();
    $posts = Post::all();
    return view('eshop.index',[
        'products'=>$products,
        'categories'=>$categories,
        'posts'=>$posts,
        'paginated_products'=>$paginated_products,
        ]);
    }

    public function getShopGrid(){
        $vendors = User::where('role','vendor')->get();
        $categories = Category::all();
        return view('eshop.shop-grid',['categories'=>$categories,'vendors'=>$vendors]);
    }

    public function getSingleShop(User $vendor){
        if($vendor->role != 'vendor'){
            abort(403);
        }
        $products = $vendor->products;
        return view('eshop.singleshop',compact('vendor','products'));
    }

    public function getCart(){
        return redirect(route('order.index'));
    }

    public function getCheckout(){
        $order_id = session('order_id',0);
        // check for valid order_id in session
        if($order_id < 1){
            // creating order if not present in the session
            // if we added user address for registration
            // $user = Auth::user();
            // $user->address
            $order = new Order;
            $order->user_id = Auth::id();
            $order->order_status = 'cart';
            $order->sub_total = 0;
            $order->discount = 0;
            $order->shipping_price = 0;
            $order->total_price = 0;
            $order->shipping_address = '';
            $order->save();
            session(['order_id'=>$order->id]);
            $order_id = $order->id;
        }
        $order = Order::find($order_id);
        return view('eshop.checkout',compact('order'));
    }

    public function getContact(){
        return view('eshop.contact');
    }

    public function getBlog(){
        return view('eshop.blog-single-sidebar');
    }

}

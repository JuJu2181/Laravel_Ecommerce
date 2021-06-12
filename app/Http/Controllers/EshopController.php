<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Post;
use App\Models\ShippingDetails;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
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
    $paginated_products = Product::latest('id')->where('user_id','!=',Auth::id())->take(6)->get();
    // $products = Product::all();
    $categories = Category::all();
    $posts = Post::latest('id')->take(4)->get();
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
        $order = Order::where('user_id',Auth::id())->where('order_status','cart')->first();
        // check for valid order_id in session
        if(empty($order)){
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
            // session(['order_id'=>$order->id]);
            $order_id = $order->id;
        }else{
            $order_id = $order->id;
        }
        $order = Order::find($order_id);
        // return $order->orderItems;
        if($order->orderItems->count() > 0){
            return view('eshop.checkout',compact('order'));
        }else{
            return redirect(route('order.index'));
        }
    }

    public function getContact(){
        return view('eshop.contact');
    }

    public function getBlog(){
        return view('eshop.blog-single-sidebar');
    }

    public function sendCheckoutEmail(Request $request){
        // return $request;
        $request->validate(
            [
                'name'=>'required|string',
                'email'=>'required|email',
                'order'=>'required',
                'country_name'=>'required',
                'number'=>'required|numeric',
                'state'=>'required',
                'post'=>'required|numeric',
                'address1'=>'required',
                'address2'=>'required',
            ]
        );
        $shipping_details = new ShippingDetails;
        $shipping_details->order_id = $request->order;
        $shipping_details->name = $request->name;
        $shipping_details->email = $request->email;
        $shipping_details->number = $request->number;
        $shipping_details->country = $request->country_name;
        $shipping_details->state = $request->state;
        $shipping_details->post = $request->post;
        $shipping_details->address1 = $request->address1;
        $shipping_details->address2 = $request->address2;
        if($shipping_details->save()){
        $order_details = $request;
        $email = $request->email;
        $order = $request->order;
        Mail::to($request->email)->send(new OrderShipped($order_details));
        return redirect()->route('eshop.checkout.confirm',['email'=>$email,'id'=>$order]);
        }else{
            return redirect()->back();
        }
    }

    public function confirmOrder($email,$id){
        // return $order_details;
        return view('orders.confirmOrder',compact('email','id'));
    }

    public function getCompletedOrder(){
        return view('orders.orderComplete');
    }
// for confirming purchase
    public function confirmCode(Request $request){
        $original_code = session('security_code',0);
        if($original_code == $request->security_code){
            $order = Order::find($request->order);
            $order->order_status = "purchased";
            $order->save();
            return redirect()->route('eshop.completed_order');
        }else{
            return redirect()->back();
        }
    }

}

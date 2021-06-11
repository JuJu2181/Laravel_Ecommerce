<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //for all the orders
        // $order_id = session('order_id',0);
        $order = Order::where('user_id',Auth::id())->where('order_status','cart')->first();
        // return $order_id;
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
        // return $order_id;
        // return $order_id;
        // find the order based on the order id
        $order = Order::find($order_id);
        // return gettype($order);
        // return $order;
        // find order items for the order
        $order_items = OrderItem::whereOrderId($order_id)->get();
        // return $order_items;
        return view('eshop.cart',compact('order_items','order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
    }
}

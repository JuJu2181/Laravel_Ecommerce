<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id',Auth::id())->paginate(6);
        return view('admin.orders.index',compact('orders'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        $order_items = $order->orderItems;
        return view('admin.orders.single',compact('order','order_items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == Auth::id()){
            abort(403);
        }
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('admin.orders.index');
    }

    // for vendor orders
    public function getVendorOrders(){
        if(Auth::user()->role == 'user'){
            abort(403);
        }elseif(Auth::user()->role == 'vendor'){
            $order_products = [];
            $order_items = OrderItem::latest('id')->paginate(5);
            foreach($order_items As $order_item){
                if($order_item->product->user_id == Auth::id()){
                    array_push($order_products,$order_item);
                }
            }
            // return $order_products;
            return view('admin.orders.orders_for_vendor',compact('order_products'));
        }else{
            $order_products = OrderItem::latest('id')->paginate(5);
            return view('admin.orders.orders_for_vendor',compact('order_products'));
        }
    }
}

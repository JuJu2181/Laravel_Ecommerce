<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingDetails;
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
        $title = "All order items for ".Auth::user()->name;
        if(Auth::user()->role == 'user'){
            abort(403);
        }elseif(Auth::user()->role == 'vendor'){
            $order_products = [];
            $order_items = OrderItem::latest('id')->get();
            foreach($order_items As $order_item){
                if($order_item->product->user_id == Auth::id() && $order_item->order->order_status != 'cart'){
                    array_push($order_products,$order_item);
                }
            }
            // return $order_products;
            return view('admin.orders.orders_for_vendor',compact('order_products','title'));
        }else{
            $order_items = OrderItem::latest('id')->get();
            $order_products = [];
            foreach($order_items As $order_item){
                if($order_item->order->order_status != 'cart'){
                    array_push($order_products,$order_item);
                }
            }
            return view('admin.orders.orders_for_vendor',compact('order_products','title'));
        }
    }

    public function getPendingVendorOrders(){
        $title = "All pending order items for ".Auth::user()->name;
        if(Auth::user()->role == 'user'){
            abort(403);
        }elseif(Auth::user()->role == 'vendor'){
            $order_products = [];
            $order_items = OrderItem::latest('id')->get();
            foreach($order_items As $order_item){
                if($order_item->product->user_id == Auth::id() && $order_item->order->order_status == 'purchased' && $order_item->status == 'pending'){
                    array_push($order_products,$order_item);
                }
            }
            // return $order_products;
            return view('admin.orders.orders_for_vendor',compact('order_products','title'));
        }else{
            $order_items = OrderItem::latest('id')->get();
            $order_products = [];
            foreach($order_items As $order_item){
                if($order_item->order->order_status == 'purchased' && $order_item->status == 'pending'){
                    array_push($order_products,$order_item);
                }
            }
            return view('admin.orders.orders_for_vendor',compact('order_products','title'));
        }
    }

    public function getCompletedVendorOrders(){
        $title = "All completed order items for ".Auth::user()->name;
        if(Auth::user()->role == 'user'){
            abort(403);
        }elseif(Auth::user()->role == 'vendor'){
            $order_products = [];
            $order_items = OrderItem::latest('id')->get();
            foreach($order_items As $order_item){
                if($order_item->product->user_id == Auth::id() && $order_item->status == 'complete'){
                    array_push($order_products,$order_item);
                }
            }
            // return $order_products;
            return view('admin.orders.orders_for_vendor',compact('order_products','title'));
        }else{
            $order_items = OrderItem::latest('id')->get();
            $order_products = [];
            foreach($order_items As $order_item){
                if($order_item->status == 'complete'){
                    array_push($order_products,$order_item);
                }
            }
            return view('admin.orders.orders_for_vendor',compact('order_products','title'));
        }
    }

    public function getShippingDetailsForOrder($item_id){
        // return $item_id;
        $order_item = OrderItem::find($item_id);
        // return $order_item;
        $order_id = $order_item->order->id;
        $shippingDetails = ShippingDetails::where('order_id','=',$order_id)->get();
        // return $shippingDetails[0]->order->order_status;
        $orderShippingDetail = "";
        foreach($shippingDetails as $shippingDetail){
            if($shippingDetail->order->order_status != 'cart'){
                $orderShippingDetail = $shippingDetail;
            }
        }
        // return $orderShippingDetail;
        return view('admin.orders.shipping_details_for_order',compact('order_item','orderShippingDetail'));
    }

    public function completeOrderByVendor(Request $request){
        // return $request;
        $order_item = OrderItem::find($request->order_item_id);
        // return $order_item;
        $order_item->status = 'complete';
        $order_item->save();
        $order = Order::find($order_item->order->id);
        $flag = 1;
        foreach($order->orderItems as $order_item){
            if($order_item->status == 'pending'){
                $flag = 0;
            }
        }   
        if($flag == 1){
            $order->order_status = 'completed';
            $order->save();
        }
        return redirect()->route('admin.orders.getCompletedVendorOrders');
    }
}

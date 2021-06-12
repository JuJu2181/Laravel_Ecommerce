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

    // for all vendor orders
    public function getVendorOrders(){
        $title = "All order items for ".Auth::user()->name;
        // for user we forbid it
        if(Auth::user()->role == 'user'){
            abort(403);
        //for vendor we will show the items specific to that vendor only 
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
        // for for admin we show all the items for all the vendors as well as admin products
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
//  function to get all the pending order items for vendors
    public function getPendingVendorOrders(){
        $title = "All pending order items for ".Auth::user()->name;
        if(Auth::user()->role == 'user'){
            abort(403);
        }elseif(Auth::user()->role == 'vendor'){
            $order_products = [];
            $order_items = OrderItem::latest('id')->get();
            // get only the items with pending status and order with purchased status
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
            // get the orders with status purchased and item status pending
            foreach($order_items As $order_item){
                if($order_item->order->order_status == 'purchased' && $order_item->status == 'pending'){
                    array_push($order_products,$order_item);
                }
            }
            return view('admin.orders.orders_for_vendor',compact('order_products','title'));
        }
    }
// function to get all the completed order items for vendors
    public function getCompletedVendorOrders(){
        $title = "All completed order items for ".Auth::user()->name;
        if(Auth::user()->role == 'user'){
            abort(403);
        }elseif(Auth::user()->role == 'vendor'){
            $order_products = [];
            $order_items = OrderItem::latest('id')->get();
            // get the orders with status purchased and item status complete
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
            // get the orders with status purchased and item status complete
            foreach($order_items As $order_item){
                if($order_item->status == 'complete'){
                    array_push($order_products,$order_item);
                }
            }
            return view('admin.orders.orders_for_vendor',compact('order_products','title'));
        }
    }
// function to get the shipping details for a certain order_item to complete its order
    public function getShippingDetailsForOrder($item_id){
        // return $item_id;
        // firstly we will get the order item for id
        $order_item = OrderItem::find($item_id);
        // return $order_item;
        // then using eloquent relationship we get the parent order for order item
        $order_id = $order_item->order->id;
        // then we get the shipping details for that order in form of an array
        // $shippingDetails = ShippingDetails::where('order_id','=',$order_id)->get();
        // return $shippingDetails[0]->order->order_status;
        //? Don't know exactly if this is needed or not Here I thought that order associated with the shipping detail may have different statuses like cart and purchased and we will create a shipping detail for an order when checkout form is submitted but its status is changed to purchased only when the security code validation finishes so if a use discard the buying in confirm order page then shipping detail will be created but its order status will still be cart and we don't want such orders. 
        //! I later thought that as all the shipping details will have same order which will be changed when I confirm order so we don't need to loop instad we can simply get the latest shipping detail with the same order id 
        $orderShippingDetail = ShippingDetails::latest('id')->where('order_id','=',$order_id)->first();
        // $orderShippingDetail = "";
        // foreach($shippingDetails as $shippingDetail){
        //     if($shippingDetail->order->order_status != 'cart'){
        //         $orderShippingDetail = $shippingDetail;
        //     }
        // }
        // return $orderShippingDetail;
        return view('admin.orders.shipping_details_for_order',compact('order_item','orderShippingDetail'));
    }
//POST: function to complete the order of a specific item by specific vendor and ultimately update the entire order status if all the order_items have been completed
    public function completeOrderByVendor(Request $request){
        // return $request;
        $order_item = OrderItem::find($request->order_item_id);
        // return $order_item;
        // firstly save the status of item as complete
        $order_item->status = 'complete';
        $order_item->save();
        // get the order representing the order item
        $order = Order::find($order_item->order->id);
        $flag = 1;
        // check for all the order items in that order
        foreach($order->orderItems as $order_item){
            // if any item is pending then we don't update status for the order
            if($order_item->status == 'pending'){
                $flag = 0;
            }
        }   
        // if all the items have been completed by vendors then update the order status
        if($flag == 1){
            $order->order_status = 'completed';
            $order->save();
        }
        return redirect()->route('admin.orders.getCompletedVendorOrders');
    }
}

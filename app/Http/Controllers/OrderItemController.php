<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return redirect(route('order.index'));
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
        //  return $request;
        // ? specifying a default value
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
        // return $order_id;
        // adding the items to cart -> creating order_item and saving in db
        $existingOrderItems = OrderItem::where([['order_id',$order_id],['product_id',$request->input('product_id')]])->get();
        // return $existingOrderItems;
        // return $existingOrderItems;
        // if the item previously exist in cart update quantity
        if(count($existingOrderItems) > 0){
            // return $request->input('product_id')."exists";
            $order_item = $existingOrderItems[0];
            $order_item->order_id = $order_id;
            $order_item->quantity +=1;
            $order_item->total = $order_item->quantity*$order_item->product_price;
            $order_item->save();
            $order = Order::find($order_id);
            $order->sub_total += $order_item->product_price;
            $order->total_price = $order->sub_total + $order->discount + $order->shipping_price;
        }else{
            // if it doesn't exist create a new order_item 
            // return $request->input('product_id')."deosn't exists";
            $order_item = new OrderItem();
            $order_item->order_id = $order_id;
            $order_item->product_id = $request->input('product_id');
            $product = Product::find($order_item->product_id);
            $order_item->product_price = $product->price;
            $order_item->quantity = $request->input('quantity');
            $order_item->total = $order_item->quantity*$order_item->product_price;
            $order_item->save();
            $order = Order::find($order_id);
            $order->sub_total += $order_item->total;
            $order->total_price = $order->sub_total + $order->discount + $order->shipping_price;
        }
        // $order_item = new OrderItem();
        // $order_item->order_id = $order_id;
        // $order_item->product_id = $request->input('product_id');
        // $product = Product::find($order_item->product_id);
        // $order_item->product_price = $product->price;
        // $order_item->quantity = $request->input('quantity');
        // $order_item->total = $order_item->quantity*$order_item->product_price;
        // $order_item->save();
        // updating the order table sub_total price based on the total price of order items
        // $order = Order::find($order_id);
        // $order->sub_total += $order_item->total;
        // $order->total_price = $order->sub_total + $order->discount + $order->shipping_price;
        // update the order table
        $order->save();
        // redirect to order 
        return redirect(route('order.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    // update using form
    public function update(Request $request, $id)
    {
        //get the order item based on the order id 
        $orderItem = OrderItem::find($id);
        // return $orderItem;
        // return $request->quant[$id];
        $oldPrice = $orderItem->total;
        $orderItem->quantity = $request->quant[$id];
        $orderItem->total = $orderItem->quantity*$orderItem->product_price;
        // return $orderItem;
        $orderItem->save();
        $order = Order::find($orderItem->order_id);
        $order->sub_total =$order->sub_total + $orderItem->total - $oldPrice;
        $order->total_price = $order->sub_total + $order->discount + $order->shipping_price;
        $order->save();
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    // this is function for ajax delete
    // public function destroy($id)
    // {
    //     $orderItem = OrderItem::find($id);
    //     $orderItem->order->sub_total -= $orderItem->total;
    //     $orderItem->order->total_price = $orderItem->order->sub_total + $orderItem->order->shipping_price + $orderItem->order->total;
    //     $orderItem->order->save();
    //     $orderItem->delete();
    //     // this is not needed for ajax delete
    //     // return redirect()->route('order.index');
    //     // for ajax delete
    //     // return response()->json([
    //     //     'success'=>'Order Item Deleted Sucessfully'
    //     // ]);
    // }
    // for normal form delete
    public function destroy($id)
    {
        $orderItem = OrderItem::find($id);
        // return $orderItem;
        $orderItem->order->sub_total -= $orderItem->total;
        $orderItem->order->total_price = $orderItem->order->sub_total + $orderItem->order->shipping_price + $orderItem->order->total;
        $orderItem->order->save();
        $orderItem->delete();
        return redirect()->route('order.index');
    }
}

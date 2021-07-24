<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SubVendor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index(){
        // get the current Date time
        $currentDateTime = Carbon::now();
        if(request('filterDate') == null){
            $dateRange = "Day";
        }else{
            $dateRange = request('filterDate');
        }

        // return $dateRange;
        $users = User::all();
        $orders = Order::all()->where('order_status','!=','cart');
        $orderItems = OrderItem::all();
        // order item for a specific vendor
        $orderItemsForMe = [];
        foreach($orderItems as $orderItem){
            if(Auth::id() == $orderItem->product->user_id){
                array_push($orderItemsForMe,$orderItem);
            }
        }
        // own order items
        $myOrders = [];
        foreach($orders as $order){
            if(Auth::id() == $order->user_id){
                array_push($myOrders,$order);
            }
        }
        // return $myOrders;
        $all_users = [];
        $normal_users = [];
        $vendors = [];
        $subvendors = [];
        $all_orders = [];
        $completed_orders = [];
        $pending_orders = [];
        $all_orderItems = [];
        $completed_orderItems = [];
        $pending_orderItems = [];
        $my_all_orders = [];
        $my_purchased_orders = [];
        $my_completed_orders = [];
        // for normal user
        if(Auth::user()->role == 'user'){
            switch ($dateRange) {
                case 'Day':
                    foreach($myOrders as $order){
                        if($currentDateTime->diffInDays($order->created_at) <= 1){
                            array_push($my_all_orders,$order);
                            if($order->order_status == 'completed'){
                                array_push($my_completed_orders,$order);
                            }elseif($order->order_status == 'purchased'){
                                array_push($my_purchased_orders,$order);
                            }
                        }
                    }
                    break;
                
                case 'Week':
                    foreach($myOrders as $order){
                        if($currentDateTime->diffInWeeks($order->created_at) <= 1){
                            array_push($my_all_orders,$order);
                            if($order->order_status == 'completed'){
                                array_push($my_completed_orders,$order);
                            }elseif($order->order_status == 'purchased'){
                                array_push($my_purchased_orders,$order);
                            }
                        }
                    }
                    break;
    
                case 'Month':
                    foreach($myOrders as $order){
                        if($currentDateTime->diffInMonths($order->created_at) <= 1){
                            array_push($my_all_orders,$order);
                            if($order->order_status == 'completed'){
                                array_push($my_completed_orders,$order);
                            }elseif($order->order_status == 'purchased'){
                                array_push($my_purchased_orders,$order);
                            }
                        }
                    }
                    break;
    
                default:
                    foreach($myOrders as $order){
                        if($currentDateTime->diffInYears($order->created_at) <= 1){
                            array_push($my_all_orders,$order);
                            if($order->order_status == 'completed'){
                                array_push($my_completed_orders,$order);
                            }elseif($order->order_status == 'purchased'){
                                array_push($my_purchased_orders,$order);
                            }
                        }
                    }
                    break;
            }
            return view("admin.dashboard",
            compact(
            'my_all_orders','my_completed_orders','my_purchased_orders'
            ));
        }elseif(Auth::user()->role == 'vendor' || Auth::user()->role == 'subvendor'){
            if(Auth::user()->role == 'subvendor'){
            $subvendor = SubVendor::where('email','=',Auth::user()->email)->first();
            $vendor_responsibilities = json_decode($subvendor->responsibility);
            }
            if(Auth::user()->vendor_status != 'verified' ||(Auth::user()->role == 'subvendor' && !in_array('orders',$vendor_responsibilities))){
                switch ($dateRange) {
                    case 'Day':
                        foreach($myOrders as $order){
                            if($currentDateTime->diffInDays($order->created_at) <= 1){
                                array_push($my_all_orders,$order);
                                if($order->order_status == 'completed'){
                                    array_push($my_completed_orders,$order);
                                }elseif($order->order_status == 'purchased'){
                                    array_push($my_purchased_orders,$order);
                                }
                            }
                        }
                        break;
                    
                    case 'Week':
                        foreach($myOrders as $order){
                            if($currentDateTime->diffInWeeks($order->created_at) <= 1){
                                array_push($my_all_orders,$order);
                                if($order->order_status == 'completed'){
                                    array_push($my_completed_orders,$order);
                                }elseif($order->order_status == 'purchased'){
                                    array_push($my_purchased_orders,$order);
                                }
                            }
                        }
                        break;
        
                    case 'Month':
                        foreach($myOrders as $order){
                            if($currentDateTime->diffInMonths($order->created_at) <= 1){
                                array_push($my_all_orders,$order);
                                if($order->order_status == 'completed'){
                                    array_push($my_completed_orders,$order);
                                }elseif($order->order_status == 'purchased'){
                                    array_push($my_purchased_orders,$order);
                                }
                            }
                        }
                        break;
        
                    default:
                        foreach($myOrders as $order){
                            if($currentDateTime->diffInYears($order->created_at) <= 1){
                                array_push($my_all_orders,$order);
                                if($order->order_status == 'completed'){
                                    array_push($my_completed_orders,$order);
                                }elseif($order->order_status == 'purchased'){
                                    array_push($my_purchased_orders,$order);
                                }
                            }
                        }
                        break;
                }
                return view("admin.dashboard",
                compact(
                'my_all_orders','my_completed_orders','my_purchased_orders'
                ));
            }else{
            switch ($dateRange) {
                case 'Day':
                    foreach($orderItemsForMe as $orderItem){
                        if($currentDateTime->diffInDays($orderItem->created_at) <= 1){
                            array_push($all_orderItems,$orderItem);
                            if($orderItem->status == 'complete'){
                                array_push($completed_orderItems,$orderItem);
                            }elseif($orderItem->status == 'pending'){
                                array_push($pending_orderItems,$orderItem);
                            }
                        }
                    }
                    foreach($myOrders as $order){
                        if($currentDateTime->diffInDays($order->created_at) <= 1){
                            array_push($my_all_orders,$order);
                            if($order->order_status == 'completed'){
                                array_push($my_completed_orders,$order);
                            }elseif($order->order_status == 'purchased'){
                                array_push($my_purchased_orders,$order);
                            }
                        }
                    }
                    break;
                
                case 'Week':
                    foreach($orderItemsForMe as $orderItem){
                        if($currentDateTime->diffInWeeks($orderItem->created_at) <= 1){
                            array_push($all_orderItems,$orderItem);
                            if($orderItem->status == 'complete'){
                                array_push($completed_orderItems,$orderItem);
                            }elseif($orderItem->status == 'pending'){
                                array_push($pending_orderItems,$orderItem);
                            }
                        }
                    }
                    foreach($myOrders as $order){
                        if($currentDateTime->diffInWeeks($order->created_at) <= 1){
                            array_push($my_all_orders,$order);
                            if($order->order_status == 'completed'){
                                array_push($my_completed_orders,$order);
                            }elseif($order->order_status == 'purchased'){
                                array_push($my_purchased_orders,$order);
                            }
                        }
                    }
                    break;
    
                case 'Month':
                    foreach($orderItemsForMe as $orderItem){
                        if($currentDateTime->diffInMonths($orderItem->created_at) <= 1){
                            array_push($all_orderItems,$orderItem);
                            if($orderItem->status == 'complete'){
                                array_push($completed_orderItems,$orderItem);
                            }elseif($orderItem->status == 'pending'){
                                array_push($pending_orderItems,$orderItem);
                            }
                        }
                    }
                    foreach($myOrders as $order){
                        if($currentDateTime->diffInMonths($order->created_at) <= 1){
                            array_push($my_all_orders,$order);
                            if($order->order_status == 'completed'){
                                array_push($my_completed_orders,$order);
                            }elseif($order->order_status == 'purchased'){
                                array_push($my_purchased_orders,$order);
                            }
                        }
                    }
                    break;
    
                default:
                    foreach($orderItemsForMe as $orderItem){
                        if($currentDateTime->diffInYears($orderItem->created_at) <= 1){
                            array_push($all_orderItems,$orderItem);
                            if($orderItem->status == 'complete'){
                                array_push($completed_orderItems,$orderItem);
                            }elseif($orderItem->status == 'pending'){
                                array_push($pending_orderItems,$orderItem);
                            }
                        }
                    }
                    foreach($myOrders as $order){
                        if($currentDateTime->diffInYears($order->created_at) <= 1){
                            array_push($my_all_orders,$order);
                            if($order->order_status == 'completed'){
                                array_push($my_completed_orders,$order);
                            }elseif($order->order_status == 'purchased'){
                                array_push($my_purchased_orders,$order);
                            }
                        }
                    }
                    break;
            }
            return view("admin.dashboard",
            compact(
                'all_orderItems','completed_orderItems','pending_orderItems','my_all_orders','my_completed_orders','my_purchased_orders'
            ));
        }
        }else{

        switch ($dateRange) {
            case 'Day':
                foreach($users as $user){
                    if($currentDateTime->diffInDays($user->created_at) <= 1){
                        array_push($all_users,$user);
                        if($user->role == 'user'){
                            array_push($normal_users,$user);
                        }elseif($user->role == 'vendor'){
                            array_push($vendors,$user);
                        }elseif($user->role == 'subvendor'){
                            array_push($subvendors,$user);
                        }
                    }
                }
                foreach($orders as $order){
                    if($currentDateTime->diffInDays($order->created_at) <= 1){
                        array_push($all_orders,$order);
                        if($order->order_status == 'completed'){
                            array_push($completed_orders,$order);
                        }elseif($order->order_status == 'purchased'){
                            array_push($pending_orders,$order);
                        }
                    }
                }
                foreach($orderItemsForMe as $orderItem){
                    if($currentDateTime->diffInDays($orderItem->created_at) <= 1){
                        array_push($all_orderItems,$orderItem);
                        if($orderItem->status == 'complete'){
                            array_push($completed_orderItems,$orderItem);
                        }elseif($orderItem->status == 'pending'){
                            array_push($pending_orderItems,$orderItem);
                        }
                    }
                }
                foreach($myOrders as $order){
                    if($currentDateTime->diffInDays($order->created_at) <= 1){
                        array_push($my_all_orders,$order);
                        if($order->order_status == 'completed'){
                            array_push($my_completed_orders,$order);
                        }elseif($order->order_status == 'purchased'){
                            array_push($my_purchased_orders,$order);
                        }
                    }
                }
                break;
            
            case 'Week':
                foreach($users as $user){
                    if($currentDateTime->diffInWeeks($user->created_at) <= 1){
                        array_push($all_users,$user);
                        if($user->role == 'user'){
                            array_push($normal_users,$user);
                        }elseif($user->role == 'vendor'){
                            array_push($vendors,$user);
                        }elseif($user->role == 'subvendor'){
                            array_push($subvendors,$user);
                        }
                    }
                }
                foreach($orders as $order){
                    if($currentDateTime->diffInWeeks($order->created_at) <= 1){
                        array_push($all_orders,$order);
                        if($order->order_status == 'completed'){
                            array_push($completed_orders,$order);
                        }elseif($order->order_status == 'purchased'){
                            array_push($pending_orders,$order);
                        }
                    }
                }
                foreach($orderItemsForMe as $orderItem){
                    if($currentDateTime->diffInWeeks($orderItem->created_at) <= 1){
                        array_push($all_orderItems,$orderItem);
                        if($orderItem->status == 'complete'){
                            array_push($completed_orderItems,$orderItem);
                        }elseif($orderItem->status == 'pending'){
                            array_push($pending_orderItems,$orderItem);
                        }
                    }
                }
                foreach($myOrders as $order){
                    if($currentDateTime->diffInWeeks($order->created_at) <= 1){
                        array_push($my_all_orders,$order);
                        if($order->order_status == 'completed'){
                            array_push($my_completed_orders,$order);
                        }elseif($order->order_status == 'purchased'){
                            array_push($my_purchased_orders,$order);
                        }
                    }
                }
                break;

            case 'Month':
                foreach($users as $user){
                    if($currentDateTime->diffInMonths($user->created_at) <= 1){
                        array_push($all_users,$user);
                        if($user->role == 'user'){
                            array_push($normal_users,$user);
                        }elseif($user->role == 'vendor'){
                            array_push($vendors,$user);
                        }elseif($user->role == 'subvendor'){
                            array_push($subvendors,$user);
                        }
                    }
                }
                foreach($orders as $order){
                    if($currentDateTime->diffInMonths($order->created_at) <= 1){
                        array_push($all_orders,$order);
                        if($order->order_status == 'completed'){
                            array_push($completed_orders,$order);
                        }elseif($order->order_status == 'purchased'){
                            array_push($pending_orders,$order);
                        }
                    }
                }
                foreach($orderItemsForMe as $orderItem){
                    if($currentDateTime->diffInMonths($orderItem->created_at) <= 1){
                        array_push($all_orderItems,$orderItem);
                        if($orderItem->status == 'complete'){
                            array_push($completed_orderItems,$orderItem);
                        }elseif($orderItem->status == 'pending'){
                            array_push($pending_orderItems,$orderItem);
                        }
                    }
                }
                foreach($myOrders as $order){
                    if($currentDateTime->diffInMonths($order->created_at) <= 1){
                        array_push($my_all_orders,$order);
                        if($order->order_status == 'completed'){
                            array_push($my_completed_orders,$order);
                        }elseif($order->order_status == 'purchased'){
                            array_push($my_purchased_orders,$order);
                        }
                    }
                }
                break;

            default:
                foreach($users as $user){
                    if($currentDateTime->diffInYears($user->created_at) <= 1){
                        array_push($all_users,$user);
                        if($user->role == 'user'){
                            array_push($normal_users,$user);
                        }elseif($user->role == 'vendor'){
                            array_push($vendors,$user);
                        }elseif($user->role == 'subvendor'){
                            array_push($subvendors,$user);
                        }
                    }
                }
                foreach($orders as $order){
                    if($currentDateTime->diffInYears($order->created_at) <= 1){
                        array_push($all_orders,$order);
                        if($order->order_status == 'completed'){
                            array_push($completed_orders,$order);
                        }elseif($order->order_status == 'purchased'){
                            array_push($pending_orders,$order);
                        }
                    }
                }
                foreach($orderItemsForMe as $orderItem){
                    if($currentDateTime->diffInYears($orderItem->created_at) <= 1){
                        array_push($all_orderItems,$orderItem);
                        if($orderItem->status == 'complete'){
                            array_push($completed_orderItems,$orderItem);
                        }elseif($orderItem->status == 'pending'){
                            array_push($pending_orderItems,$orderItem);
                        }
                    }
                }
                foreach($myOrders as $order){
                    if($currentDateTime->diffInYears($order->created_at) <= 1){
                        array_push($my_all_orders,$order);
                        if($order->order_status == 'completed'){
                            array_push($my_completed_orders,$order);
                        }elseif($order->order_status == 'purchased'){
                            array_push($my_purchased_orders,$order);
                        }
                    }
                }
                break;
        }
        // return $all_users;
        return view('admin.dashboard',
        compact(
            'all_users','normal_users','vendors','subvendors',
            'all_orders','completed_orders','pending_orders',
            'all_orderItems','completed_orderItems','pending_orderItems','my_all_orders','my_completed_orders','my_purchased_orders'
        ));
    }
    }
}

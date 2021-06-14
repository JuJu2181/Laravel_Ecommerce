<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewAndRatingPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    // gate worked but policy didn't
    // public function view(User $user, Product $product){
    //     if($user->role == 'admin'){return true;}
    //     else{
    //         $orders = $user->orders;
    //         foreach($orders as $order){
    //             $order_items = $order->orderItems;
    //             foreach($order_items as $order_item){
    //                 if($order_item->product_id == $product->id){
    //                     return true;
    //                 }
    //             }
    //         }
    //         return false;
    //     }
    // }
}

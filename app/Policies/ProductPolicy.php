<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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



    // defining the function for update inside the policy
    public function update(User $user, Product $product){
        // TODO:: If the user is admin then no need to check for product user_id and auth user id as admin can access any product
        if($user->role == 'admin'){return true;}
        if($user->role == 'vendor'){
        return $product->user_id == $user->id;
        }
    }
}

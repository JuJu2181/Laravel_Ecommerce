<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use App\Models\SubVendor;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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
    public function update(User $user, Post $post){
        if($user->role == 'admin'){return true;}
        if($user->role == 'vendor' && $user->vendor_status == 'verified'){
        return $post->user_id == $user->id;
        }
        if($user->role == 'subvendor'){
            $subvendor = SubVendor::where('email','=',$user->email)->first();
            return in_array('posts',json_decode($subvendor->responsibility));
        }
    }
}

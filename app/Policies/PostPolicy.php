<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
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
        if($user->role == 'vendor'){
        return $post->user_id == $user->id;
        }
    }
}

<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Product;
use App\Models\ReviewAndRating;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ReviewAndRatingPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // binding product class and product policy
        Product::class => ProductPolicy::class,
        Post::class => PostPolicy::class,
        ReviewAndRating::class => ReviewAndRatingPolicy::class,
        // Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        
        //*using gates for authorization of update product
        // here the user passed as parameter is the currently logged in user sent automatically by laravel
        // Gate::define('update-product',function(User $user,Product $product){
        //     // condition for checking user
        //     return $product->user_id == $user->id;
        // });

        //* using gate for updating category 
        // TODO: Here checkUser will be a function defined in user model
        Gate::define('authorize-category',function(User $user){
            return $user->role == 'admin';
        });

        // Gate for review product 
        Gate::define('review-product',function(User $user,Product $product){
            $review = ReviewAndRating::where('product_id',$product->id)->where('user_id',$user->id)->get();
            // dd(count($review));
            if(count($review) <= 0){
            // if($user->role == 'admin'){
            //     return true;
            // }
            // else{
            $orders = $user->orders;
            foreach($orders as $order){
                $order_items = $order->orderItems;
                foreach($order_items as $order_item){
                    if($order_item->product_id == $product->id && $order_item->review_status == 'not_reviewed'){
                        return true;
                    }
                }
            // }
            return false;
        }
        }else{
            return false;
        }
        });
    }
}

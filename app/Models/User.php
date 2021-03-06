<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role',
        'vendor_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    // default attributes for model
    protected $attributes = [
        'image' => '',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // * relation between user and product 
    public function products(){
        return $this->hasMany(Product::class);
    }
    // relation between user and post
    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    // one user can only have one review 
    public function review(){
        return $this->hasOne(ReviewAndRating::class);
    }

    // relation between user and comments 
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    // relation between user and subvendors 
    public function subvendors(){
        return $this->hasMany(SubVendor::class);
    }
}

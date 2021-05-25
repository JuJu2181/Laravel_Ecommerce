<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
         //? fetching from db
        $posts = Post::get();
        return view(
            'posts.index',
            ['posts' => $posts]
        );
    }

    public function createPost(){
        $random_number = rand(1,10000);
    // echo $random_number;
        $post_title = 'Post'.strval($random_number);
        echo $post_title."created";
        Post::create(
            [
                'title' => $post_title,
                'body' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minus unde consectetur nesciunt pariatur aspernatur minima quasi voluptas delectus, nulla cupiditate repudiandae eaque atque odit tempora voluptatibus nisi voluptatum quaerat doloribus! Minima, .',
                'image' => '',
            ]
        );
        return redirect()->route('post.index');
    }

    public function getSingle(Post $post){
        return view('posts.single',['post'=>$post]);
    }
}

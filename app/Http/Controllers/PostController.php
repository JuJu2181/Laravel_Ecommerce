<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
         //? fetching from db
        $posts = Post::latest('id')->paginate(4);
        return view(
            'posts.index',
            ['posts' => $posts]
        );
    }

    public function getSingle($slug){
        $post = Post::where('slug','=',$slug)->first();
        // return $post;
        return view('posts.single',['post'=>$post]);
    }
}

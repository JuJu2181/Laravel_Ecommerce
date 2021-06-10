<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests\PostsFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == "user"){
            abort(403);
        }elseif (Auth::user()->role == "vendor") {
            $posts = Post::latest('id')->where('user_id','=',Auth::id())->paginate(4);
            return view('admin.posts.index',compact('posts'));
        }else{
            $posts = Post::latest('id')->paginate(4);
            return view('admin.posts.index',['posts'=>$posts]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == "user"){
            abort(403);
        }
        // $categories = Category::all();
        $categories = Category::with('children')->where('parent_id',0)->get();
        return view("admin.posts.create",compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsFormRequest $request)
    {
        if(Auth::user()->role == "user"){
            abort(403);
        }

        // validation rules using the form request
        // return $request;
        $request->validated();
        $post = new Post;
        $post->title = $request->input('title');
        $post->user_id = Auth::id();
        $post->slug = $request->input('slug');
        $post->body = $request->input('body');
        $post->category_id = $request->input('category_id');
        // for validating image 
        if($request->hasFile('image_upload')){
            // to get original name 
            // $name = time().'_'.$request->file('image_upload')->getClientOriginalName();
            $name = $request->file('image_upload')->getClientOriginalName();
            // this also by default generates a random name
            // $product->image = $request->file('image_upload')->storage('public/images');
            // storing with its original name 
            $request->file('image_upload')->storeAs('public/images',$name);
            image_crop($name);
            $post->image = $name;
        }
        if($post->save()){
            return redirect()->route('admin.posts.index');
        }else{
            return redirect()->back();
        }     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $this->authorize('update',$post);
        $categories = Category::with('children')->where('parent_id',0)->get();
        return view('admin.posts.edit',["post"=>$post,"categories"=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        // ? using authorize helper function which uses update function from policy for authorization
        $this->authorize('update',$post);
        // checking if the slug has changed or not if not then we don't need to check for error
        if($request->input('slug') == $post->slug){
            // return "true";
            $request->validate(
            [
                'title' => 'required|max:255|min:3',
                'body' => 'required|min:10',
                'category_id'=>'required|integer|min:1',
                'image'=>'image|size:2048'
            ],
            // customizing error messages
            [
                'category_id.min'=>'Please select atleast one category'
            ]
        );
        }else{
            // return "false";
        $request->validate(
            [
                'title' => 'required|max:255|min:3',
                'slug' => 'required|string|unique:posts',
                'body' => 'required|min:10',
                'category_id'=>'required|integer|min:1',
                'image'=>'image|size:2048',
            ],
            // customizing error messages
            [
                'category_id.min'=>'Please select atleast one category'
            ]);

        }
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->body = $request->input('body');
        $post->category_id = $request->input('category_id');
        // for validating image 
        if($request->hasFile('image_upload')){
            // to get original name 
            // $name = time().'_'.$request->file('image_upload')->getClientOriginalName();
            $name = $request->file('image_upload')->getClientOriginalName();
            $request->file('image_upload')->storeAs('public/images',$name);
            image_crop($name);
            $post->image = $name;
            // return $product->image;
        }
        if($post->save()){
            return redirect()->route('admin.posts.index');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $this->authorize('update',$post);
        $post->delete();
    }
}

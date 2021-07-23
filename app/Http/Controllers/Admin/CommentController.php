<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('user_id',Auth::id())->paginate(6);
        return view('admin.comments.index',compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'body'=>'required|min:3'
        ]);
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $post = Post::find($comment->post_id);
        if(!empty($request->parent_id)){
            $comment->parent_id = $request->parent_id;
        }
        if($comment->save()){
            return redirect()->route('post.single',$post->slug);
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
    public function show(Comment $comment)
    {
        return view('admin.comments.single',compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        if($comment->user_id != Auth::id()){
            abort(403);
        }
        return view('admin.comments.edit',compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'body'=>'required|min:3'
        ]);
        $comment->body = $request->body;
        if($comment->save()){
            return redirect()->route('admin.comments.show',$comment->id);
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
    public function destroy(Comment $comment)
    {

    }

    public function getPostComments(){
        if(Auth::user()->role == 'user'){
            abort(403);
        }elseif(Auth::user()->role == 'vendor'){
            if(Auth::user()->vendor_status != 'verified'){
                abort(403);
            }
        $posts = Post::where('user_id',Auth::id())->get();
        }else{
            $posts = Post::all();
        }
        // return $productsWithReviews;
        return view('admin.comments.post_comments',compact('posts'));
    }

    public function getPostCommentDetail($id){
        $post = Post::find($id);
        return view('admin.comments.post_comment_detail',compact('post'));
    }

    public function deleteComment($id,$currentPage='dashboard')
    {
        $comment = Comment::find($id);
        if($comment->user_id != Auth::id()){
            abort(403);
        }
        if($comment->children->count() > 0){
            foreach($comment->children as $reply){
                $this->deleteReply($reply);
            }
        }
        $comment->delete();
        if($currentPage == 'post_detail'){
            return redirect()->route('post.single',$comment->post->slug);
        }else{
            return redirect()->route('admin.comments.index');
        }
    }

    public function deleteReply(Comment $comment){
        if($comment->children->count() > 0){
            foreach($comment->children as $reply){
                $this->deleteReply($reply);
            }
        }
        $comment->delete();
    }
}

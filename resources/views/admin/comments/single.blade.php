@section('title',$comment->post->title.'Comment Details')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <div class="jumbotron">
                <h2>Details For Comment Of {{$comment->post->title}}</h2>
                <div class="text-info" style="font-size: 1.1rem;">Post Title: {{$comment->post->title}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Post Author: {{$comment->post->user->name}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Comment Body: {{$comment->body}}</div>
                <div class="text-danger" style="font-size: 1.1rem;">No. of Replies: {{$comment->children->count()}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Comment Date: {{date('M j, Y, g:i a',strtotime($comment->created_at))}}</div>
                
               {{-- check if it is review maker --}}
                @if ($comment->user_id == Auth::id()) 
                <a href="{{route('admin.comments.edit',$comment->id)}}" class="btn btn-outline-info btn-block mt-3"><i class="typcn typcn-shopping-cart mr-3"></i>Edit This Comment</a>

                <form action={{ route('admin.comments.delete_comment',['id'=>$comment->id,'currentPage'=>'dashboard']) }} method="post"
                    class="mt-2" id="deleteForm">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-block" id="deleteButton">
                        Delete This Comment
                        <span><i class="typcn typcn-trash"></i></span>
                    </button>
                </form>               
                @endif
            </div>
            <a href="{{route('admin.comments.index')}}" class=" mt-5 btn btn-block btn-outline-primary">View All Your Comments</a>
            <a href="{{route('post.single',$comment->post->slug)}}" class=" mt-5 btn btn-block btn-outline-primary">View Post</a>
        </div>
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("comments").classList.add("active");
    </script>
@stop
</x-admin.layout>
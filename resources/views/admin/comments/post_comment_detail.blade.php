@section('title','Comments For '.$post->title)
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <div class="jumbotron">
                <h2>Comment Details For {{$post->title}}</h2>
                <div class="text-info" style="font-size: 1.1rem;">Post Title: {{$post->title}}</div>
                <div class="text-danger" style="font-size: 1.1rem;">No. of Comments: {{$post->comments->count()}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Post Author: {{$post->user->name}}</div>
            </div>
            <h2>All Post Comments For {{$post->title}}</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Comment By</td>
                        <td>Body</td>
                        <td>Replies</td>
                        <td>Date</td>
                        <td>Actions</td>
                    </tr>
                    @foreach ($post->comments as $comment)
                    <tr id="commentId{{ $comment->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$comment->author->name}}</td>
                        <td>{{ Str::substr($comment->body, 0, 50) }} {{ strlen($comment->body) > 50 ? "...": "" }}</td>
                        <td>{{$comment->children->count()}}</td>
                        <td>{{date('M j, Y, g:i a',strtotime($comment->created_at))}}</td>
                        <td>  
                        <a href="{{route('admin.comments.show',$comment->id)}}" class="btn btn-info btn-block">Show Details</a>
                        </td>   
                    </tr>
                        @endforeach
                </table>
            </div>
            <a href="{{route('admin.comments.getPostComments')}}" class=" mt-5 btn btn-block btn-outline-primary">View All Post Comments</a>
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
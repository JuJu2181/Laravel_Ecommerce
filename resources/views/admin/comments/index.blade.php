@section('title',Auth::user()->name.' - All Comments')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>All Your Comments</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mg-b-0">
                        <tr>
                            <td>S.N.</td>
                            <td>Post Name</td>
                            <td>Post Author</td>
                            <td>Comment Body</td>
                            <td>Replies</td>
                            <td>Date</td>
                            <td>Actions</td>
                        </tr>
                        @foreach ($comments as $comment)
                        <tr id="commentId{{ $comment->id }}">

                            <td>{{ $loop->iteration }}</td>
                            <td>{{$comment->post->title}}</td>
                            <td>{{$comment->post->user->name}}</td>
                            <td>{{ Str::substr($comment->body, 0, 50) }} {{ strlen($comment->body) > 50 ? "...": "" }}
                            </td>
                            <td>{{$comment->children->count()}}</td>
                            <td>{{date('M j, Y, g:i a',strtotime($comment->created_at))}}</td>
                            {{-- To show product details --}}
                            <td><a href="{{route('admin.comments.show',$comment->id)}}" class="btn btn-info btn-block">
                                    Show Details
                                    <span><i class="typcn typcn-info-large"></i></span>
                                </a>
                                <form action={{ route('admin.comments.delete_comment',['id'=>$comment->id,'currentPage'=>'dashboard']) }} method="post"
                                    class="mt-2" id="deleteForm">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block" id="deleteButton">
                                        Delete
                                        <span><i class="typcn typcn-trash"></i></span>
                                    </button>
                                </form>
                                </tr> 
                                @endforeach
                                        </table> <div class="mt-4">
                                    {{$comments->links()}}
                </div>
            </div>
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

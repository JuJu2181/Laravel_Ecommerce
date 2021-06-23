@section('title',Auth::user()->name.' - All Post Comments')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>All Comments For Your Posts</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mg-b-0">
                        <tr>
                            <td>S.N.</td>
                            <td>Post Name</td>
                            @if (Auth::user()->role == 'admin')
                                <td>Post Author</td>
                            @endif
                            <td>Comments</td>
                            <td>Actions</td>
                        </tr>
                        @foreach ($posts as $post)
                        <tr id="postId{{ $post->id }}">

                            <td>{{ $loop->iteration }}</td>
                            <td>{{$post->title}}</td>
                            @if (Auth::user()->role == 'admin')
                                <td>{{$post->user->name}}</td>
                            @endif
                            <td>{{$post->comments->count()}}</td>
                            {{-- To show product details --}}
                            <td><a href="{{route('admin.comments.getPostCommentDetail',$post->id)}}" class="btn btn-info btn-block">
                                    Show Details
                                    <span><i class="typcn typcn-info-large"></i></span>
                                </a>
                              @endforeach
                        </table> 
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

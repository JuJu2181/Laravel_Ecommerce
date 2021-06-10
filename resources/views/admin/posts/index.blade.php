@section('title',Auth::user()->name.' - All Posts')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        @unless(Auth::user()->role == 'user')
        <div class="az-content-body">
            <h2>All Posts</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Title</td>
                        <td>Body</td>
                        <td>Author</td>
                        <td>Category</td>
                        <td>Actions</td>
                    </tr>
                    @foreach ($posts as $post)
                    {{-- for displaying posts specific to user --}}
                    @can('update',$post)
                    <tr id="postId{{ $post->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $post->title }}</td>
                        <td>  {{ Str::substr($post->body, 0, 50) }} {{ strlen($post->body) > 50 ? "...": "" }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td><a href="{{route('category.single',$post->category->id)}}">{{ $post->category->name }}</a></td>
                        <td>
                            <a href={{ route('admin.posts.edit',$post->id) }} class="btn btn-info btn-block">  
                                Edit
                                <span><i class="typcn typcn-edit"></i></span>
                                </a>
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <button id="deletePost" data-id="{{ $post->id }}" class="btn btn-danger btn-block mt-2" onclick="deletePost({{ $post->id }})">Delete
                                <span><i class="typcn typcn-trash"></i></span
                                </button>
                            </td>
                    </tr>
                    @endcan
                        @endforeach
                </table>
            </div>
            <div class="mt-5 d-flex justify-center mx-auto">
                {{ $posts->links() }}
            </div>
        </div>
        @else
        <h3 class="text-danger">You are unauthorized</h3>
        @endunless
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("posts").classList.add("active");

        // for ajax delete
        function deletePost(id){
            console.log(id);
            let token = $("meta[name='csrf-token']").attr("content");
            if(confirm("Are you sure to delete this product?\n press 'OK' to confirm")){
                $.ajax({
                url:"/admin/posts/"+id,
                type: 'DELETE',
                data:{
                    "id":id,
                    "_token":token,
                },
                success:function(){
                    console.log("deleted");
                    $('#postId'+id).remove();
                }
                });
            }else{
                console.log("cancelled");
            }
            
        }
    </script>
@stop
</x-admin.layout>
@section('title',Auth::user()->name.' - All Reviews')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>All Your Reviews</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mg-b-0">
                        <tr>
                            <td>S.N.</td>
                            <td>Product Name</td>
                            <td>Average Product Rating</td>
                            <td>Your Rating</td>
                            <td>Review</td>
                            <td>Date</td>
                            <td>Actions</td>
                        </tr>
                        @foreach ($reviews as $review)
                        <tr id="reviewId{{ $review->id }}">

                            <td>{{ $loop->iteration }}</td>
                            <td>{{$review->product->name}}</td>
                            <td>{{$review->product->average_rating}}</td>
                            <td>{{ $review->rating }}</td>
                            <td>{{ Str::substr($review->review, 0, 50) }} {{ strlen($review->review) > 50 ? "...": "" }}
                            </td>
                            <td>{{date('M j, Y, g:i a',strtotime($review->created_at))}}</td>
                            {{-- To show product details --}}
                            <td><a href="{{route('admin.reviews.show',$review->id)}}" class="btn btn-info btn-block">
                                    Show Details
                                    <span><i class="typcn typcn-info-large"></i></span>
                                </a>
                                <form action={{ route('admin.reviews.delete_review',['id'=>$review->id,'currentPage'=>'dashboard']) }} method="post"
                                    class="mt-2" id="deleteForm">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block" id="deleteButton">
                                        Delete
                                        <span><i class="typcn typcn-trash"></i></span>
                                    </button>
                                </form>
                                {{-- to delete using ajax request --}}
                                {{-- <meta name="csrf-token" content="{{ csrf_token() }}">
                                <button id="deleteReview" data-id="{{ $review->id }}"
                                    class="btn btn-danger btn-block mt-2"
                                    onclick="deleteReview({{ $review->id }})">Delete
                                    <span><i class="typcn typcn-trash"></i></span </button> </td> --}} </tr> @endforeach
                                        </table> <div class="mt-4">
                                    {{$reviews->links()}}
                </div>
            </div>
        </div>
    </div>
    </div>
    @section('scripts')
    <script>
        // to toggle active state
        document.getElementById("reviews").classList.add("active");

        // for ajax delete
        // function deleteReview(id){
        //     console.log(id);
        //     let token = $("meta[name='csrf-token']").attr("content");
        //     if(confirm("Are you sure to delete this review?\n press 'OK' to confirm")){
        //         $.ajax({
        //         url:"/admin/reviews/"+id,
        //         type: 'DELETE',
        //         data:{
        //             "id":id,
        //             "_token":token,
        //         },
        //         success:function(){
        //             console.log("deleted");
        //             $('#reviewId'+id).remove();
        //         }
        //         });
        //     }else{
        //         console.log("cancelled");
        //     }

        // }

    </script>
    @stop
</x-admin.layout>

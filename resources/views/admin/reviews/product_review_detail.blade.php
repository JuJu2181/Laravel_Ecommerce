@section('title','Reviews For '.$product->name)
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <div class="jumbotron">
                <h2>Review Details For {{$product->name}}</h2>
                <div class="text-info" style="font-size: 1.1rem;">Product Name: {{$product->name}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Average Rating: {{$product->average_rating}}</div>
                <div class="text-danger" style="font-size: 1.1rem;">No. Of Reviews: {{$product->reviews->count()}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Vendor: {{$product->user->name}}</div>
            </div>
            <h2>All Product Reviews For {{$product->name}}</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Reviewer</td>
                        <td>Rating</td>
                        <td>Review</td>
                        <td>Date</td>
                        <td>Actions</td>
                    </tr>
                    @foreach ($product->reviews as $review)
                    <tr id="reviewId{{ $review->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$review->user->name}}</td>
                        <td>{{ $review->rating }}</td>
                        <td>{{ Str::substr($review->review, 0, 50) }} {{ strlen($review->review) > 50 ? "...": "" }}</td>
                        <td>{{date('M j, Y, g:i a',strtotime($review->created_at))}}</td>
                        <td>  
                        <a href="{{route('admin.reviews.show',$review->id)}}" class="btn btn-info btn-block">Show Details</a>
                        </td>   
                    </tr>
                        @endforeach
                </table>
            </div>
            <a href="{{route('admin.reviews.getProductReviews')}}" class=" mt-5 btn btn-block btn-outline-primary">View All Product Reviews</a>
        </div>
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("reviews").classList.add("active");
    </script>
@stop
</x-admin.layout>
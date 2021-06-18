@section('title',$review->product->name.' Review Details')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <div class="jumbotron">
                <h2>Details For Review Of {{$review->product->name}}</h2>
                <div class="text-info" style="font-size: 1.1rem;">Product Name: {{$review->product->name}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Product Vendor: {{$review->product->user->name}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Average Product Rating: {{$review->product->average_rating}}</div>
                <div class="text-danger" style="font-size: 1.1rem;">Rating: {{$review->rating}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Review: {{$review->review}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Review Date: {{date('M j, Y, g:i a',strtotime($review->created_at))}}</div>
                
               {{-- check if it is review maker --}}
                @if ($review->user_id == Auth::id()) 
                <a href="{{route('admin.reviews.edit',$review->id)}}" class="btn btn-outline-warning btn-block mt-3"><i class="typcn typcn-shopping-cart mr-3"></i>Edit This Review</a>

                <form action={{ route('admin.reviews.delete_review',['id'=>$review->id,'currentPage'=>'dashboard']) }} method="post"
                    class="mt-2" id="deleteForm">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-block" id="deleteButton">
                        Delete This Review
                        <span><i class="typcn typcn-trash"></i></span>
                    </button>
                </form>               
                @endif
            </div>
            <a href="{{route('admin.reviews.index')}}" class=" mt-5 btn btn-block btn-outline-primary">View All Your Reviews</a>
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
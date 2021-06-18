@section('title',Auth::user()->name.' - All Product Reviews')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>All Reviews For Your Products</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mg-b-0">
                        <tr>
                            <td>S.N.</td>
                            <td>Product Name</td>
                            @if (Auth::user()->role == 'admin')
                                <td>Vendor</td>
                            @endif
                            <td>Average Product Rating</td>
                            <td>No. of Reviews</td>
                            <td>Actions</td>
                        </tr>
                        @foreach ($productsWithReviews as $product)
                        <tr id="productId{{ $product->id }}">

                            <td>{{ $loop->iteration }}</td>
                            <td>{{$product->name}}</td>
                            @if (Auth::user()->role == 'admin')
                                <td>{{$product->user->name}}</td>
                            @endif
                            <td>{{$product->average_rating}}</td>
                            <td>{{ $product->reviews->count() }}</td>

                            {{-- To show product details --}}
                            <td><a href="{{route('admin.reviews.getProductReviewDetail',$product->id)}}" class="btn btn-info btn-block">
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
        document.getElementById("reviews").classList.add("active");

    </script>
    @stop
</x-admin.layout>

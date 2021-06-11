@extends('layouts.primary')

@section('title','All Products')

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href={{ route('product.index') }}>All Products</a></li>
</ul>
@endsection

@section('content')
@include('partials._breadcumb')
<!-- only in shop-grid -->
<!-- Product Style -->
<section class="product-area shop-sidebar shop section">
    <div class="container">
        <div class="row">
            @include('partials._shop_sidebar')
            <div class="col-lg-9 col-md-8 col-12">
                <div class="row">
                    <div class="col-12">
                        <!-- Shop Top -->
                        <form action="{{route('product.index')}}" method="GET">
                        @include('partials._shoptop')
                        </form>
                        <!--/ End Shop Top -->
                    </div>
                </div>
                <div class="row">
                    @foreach ($products as $product)
                    
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-product">
                            <div class="product-img">
                                <a href={{ route('product.single',$product->id) }}>
                                    <img class="default-img" src="{{ $product->image == ''?"https://via.placeholder.com/550x750" :image_crop($product->image) }}" alt="#">
                                    <img class="hover-img" src="{{ $product->image == ''?"https://via.placeholder.com/550x750" :image_crop($product->image) }}" alt="#">
                                </a>
                                <div class="button-head">
                                    <div class="product-action">
                                        <a data-toggle="modal" data-target="#exampleModal" title="Quick View"
                                            href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                        <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to
                                                Wishlist</span></a>
                                        <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to
                                                Compare</span></a>
                                    </div>
                                    <div class="product-action-2">
                                        @if ($product->user_id != Auth::id())
                                        <form action="{{route('cart.store')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <input type="hidden" name="quantity" value="1">
                                            <a title="Add to cart" href="#" onclick="event.preventDefault();this.closest('form').submit();">Add to cart</a>
                                        </form>
                                        @else
                                        <p>You Own This Product</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href={{ route('product.single',$product->id) }}>{{ $product->name }}</a></h3>
                                <div class="product-price">
                                    <span>{{ $product->price }}</span><br>
                                    <span>
                                        <a href={{ route('category.single',$product->category->id) }}>
                                            {{ $product->category->name }}
                                        </a>
                                    </span>
                                    <br>
                                    <span class=" text-info text-sm">
                                    Added {{ $product->created_at->diffForHumans() }}
                                    </span>
                                    <br>
                                    <span class="text-secondary">
                                        By {{ $product->user->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    

                </div>
                <div class="mt-4 mx-auto" >
                    {{-- to append get request for pagination --}}
                    {{ $products->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Product Style 1  -->
<!-- end of shop grid -->
@include('partials._newsletter')
@include('partials._modal')
@endsection

@section('scripts')
    <script>
        document.getElementById("product").classList.add("active");
    </script>
@endsection
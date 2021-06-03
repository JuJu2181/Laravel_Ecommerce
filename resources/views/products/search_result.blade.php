@extends('layouts.primary')

@section('title','Search Results')

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href="#">Search Results </a></li>
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
                        {{-- <h3>All Search Results For {{$search_key}} ({{count($products)}})</h3> --}}
                        <h3>{{$search_title}}</h3>
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
                                    <img class="hover-img" src="{{ $product->image == ''?"https://via.placeholder.com/550x750" :asset('storage/images/thumbnail/'.$product->image) }}" alt="#">
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
                                        <a title="Add to cart" href="#">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href={{ route('product.single',$product->id) }}>{{ $product->name }}</a></h3>
                                <div class="product-price">
                                    <span>{{ $product->price }}</span><br>
                                    <span>{{ $product->category->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    

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
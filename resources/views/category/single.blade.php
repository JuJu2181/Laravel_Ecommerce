@extends('layouts.primary')

@section('title',$category->name)

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li><a href={{ route('category.index') }}>Categories<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href={{ route('category.single',$category->id) }}>{{ $category->name }}</a></li>
</ul>
@endsection

@section('content')
@include('partials._breadcumb')
<!-- only in shop-grid -->
<!-- Product Style -->
<section class="product-area shop-sidebar shop section">
    <div class="container">
        <div class="row">
            {{-- including shop sidebar --}}
            @include('partials._shop_sidebar')
            <div class="col-lg-9 col-md-8 col-12">
                <div class="row">
                    <div class="col-12">
                        <!-- Shop Top -->
                        <div class="shop-top">
                            <div class="shop-shorter">
                                <div class="single-shorter">
                                    <label>Show :</label>
                                    <select>
                                        <option selected="selected">09</option>
                                        <option>15</option>
                                        <option>25</option>
                                        <option>30</option>
                                    </select>
                                </div>
                                <div class="single-shorter">
                                    <label>Sort By :</label>
                                    <select>
                                        <option selected="selected">Name</option>
                                        <option>Price</option>
                                        <option>Size</option>
                                    </select>
                                </div>
                            </div>
                            <ul class="view-mode">
                                <li class="active"><a href="shop-grid.html"><i class="fa fa-th-large"></i></a></li>
                                <li><a href="shop-list.html"><i class="fa fa-th-list"></i></a></li>
                            </ul>
                        </div>
                        <!--/ End Shop Top -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 my-3">
                        <h3>{{$category->name}}</h3>
                        <p class="mt-2">{{$category->description}}</p>
                    </div>
                </div>
                {{-- this is for products --}}
                <div class="row">
                    <div class="col-12 mt-5">
                        <h3>{{$title}} In {{$category->name}} ({{count($products_or_subcategories)}})</h3>
                    </div>

                    @foreach ($products_or_subcategories as $product_or_subcategory)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-product">
                            <div class="product-img">
                                <a href="product-details.html">
                                    <img class="default-img"
                                        src="{{$product_or_subcategory->image==''?"https://via.placeholder.com/550x750":image_crop($product_or_subcategory->image)}}"
                                        alt="#">
                                    <img class="hover-img"
                                        src="{{$product_or_subcategory->image==''?"https://via.placeholder.com/550x750":image_crop($product_or_subcategory->image)}}"
                                        alt="#">
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
                                <h3><a href={{ route($nxtroute,$product_or_subcategory->id) }}>{{ $product_or_subcategory->name }}</a></h3>
                                <div class="product-price">
                                    <span>{{ $product_or_subcategory->price }}</span>
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

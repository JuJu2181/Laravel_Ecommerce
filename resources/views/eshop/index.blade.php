@extends('layouts.primary')

@section('title','Home')

@section('category_menu')
    @include('partials._category_sublist')
@endsection

@section('content')
{{-- getting products using php for layout--}}
@php
    $singleProduct = $products[0];
    $fourProducts = [];
    $threeProducts = [];
    for($i=1;$i<count($products);$i++){
        if($i < 4){
            array_push($threeProducts,$products[$i]);
        }
        if($i<5){
        array_push($fourProducts,$products[$i]);
        }
    }
@endphp

<!-- only in index page -->
<!-- Slider Area -->
<section class="hero-slider">
    <!-- Single Slider -->
    <?php
    $image_url = $singleProduct->image == ''?'https://via.placeholder.com/1900x700':image_crop($singleProduct->image,1900,700);
    ?>
    <div class="single-slider" style="background-image: url({{$image_url}})">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-9 offset-lg-3 col-12">
                    <div class="text-inner">
                        <div class="row">
                            <div class="col-lg-7 col-12">
                                <div class="hero-text">
                                    <h1><span>UP TO 50% OFF </span>{{$singleProduct->name}}</h1>
                                    <p>{{$singleProduct->description}}</p>
                                    <div class="button">
                                        <a href="#" class="btn">Shop Now!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Single Slider -->
</section>
<!--/ End Slider Area -->

<!-- Start Small Banner  -->
<section class="small-banner section">
    <div class="container-fluid">
        <div class="row">
            <!-- Single Banner  -->
            {{-- Error for crop_image solved--}}
            @foreach ($fourProducts as $product)
                <div class="col-lg-4 col-md-6 col-12">
                <div class="single-banner">
                    <img src="{{$product->image == ''?"https://via.placeholder.com/600x370":image_crop($product->image,600,370)}}" alt="#">
                    <div class="content">
                        <p>{{$product->category->name}}</p>
                        <h3 style="color:#b12ffc">{{$product->name}}</h3>
                        <a href="{{ route('product.single',$product->id) }}" >Discover Now</a>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- /End Single Banner  -->
        </div>
    </div>
</section>
<!-- End Small Banner -->

<!-- Start Product Area -->
<div class="product-area section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Trending Item</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-info">
                    <div class="tab-content" id="myTabContent">
                        <!-- Start Single Tab -->
                        <div class="tab-pane fade show active" id="man" role="tabpanel">
                            <div class="tab-single">
                                <div class="row">
									@foreach ($paginated_products as $product)
                                    @unless ($product->user->id == Auth::id())
										<div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href={{ route('product.single',$product->id) }}>
                                                    <img class="default-img" src="{{ $product->image == ''?"https://via.placeholder.com/550x750" :image_crop($product->image) }}" alt="#">
                                                    <img class="hover-img" src="{{ $product->image == ''?"https://via.placeholder.com/550x750" :image_crop($product->image) }}" alt="#">
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a data-toggle="modal" data-target="#exampleModal"
                                                            title="Quick View" href="#"><i
                                                                class=" ti-eye"></i><span>Quick Shop</span></a>
                                                        <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add
                                                                to Wishlist</span></a>
                                                        <a title="Compare" href="#"><i
                                                                class="ti-bar-chart-alt"></i><span>Add to
                                                                Compare</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        {{-- <a title="Add to cart" href="#">Add to cart</a> --}}
                                <form action="{{route('cart.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="quantity" value="1">
                                    <a title="Add to cart" href="#" onclick="event.preventDefault();this.closest('form').submit();">Add to cart</a>
                                </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3 class="text-dark"><a href={{ route('product.single',$product->id) }}>{{$product->name}}</a></h3>
                                                <div class="product-price">
                                                    <span>Rs. {{$product->price}}</span>
                                                    <br>
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
                                    @endunless
									@endforeach

                                </div>
                            </div>
                        </div>
                        <!--/ End Single Tab -->
                    </div>
                </div>
                
        
            </div>
        </div>
    </div>
</div>
<!-- End Product Area -->

<!-- Start Midium Banner  -->
<section class="midium-banner">
    <div class="container">
        <div class="row">
            <!-- Single Banner  -->
            <div class="col-lg-6 col-md-6 col-12">
                <div class="single-banner">
                    <img src="{{$products[0]->image==''?'https://via.placeholder.com/600x370':image_crop($products[0]->image,600,370)}}" alt="#">
                    <div class="content">
                        <p>{{$products[0]->category->name}}</p>
                        <h3>{{$products[0]->name}} <br>Up to<span> 50%</span></h3>
                        <a href="{{route('product.single',$products[0]->id)}}">Shop Now</a>
                    </div>
                </div>
            </div>
            <!-- /End Single Banner  -->
            <!-- Single Banner  -->
            <div class="col-lg-6 col-md-6 col-12">
                <div class="single-banner">
                    <img src="{{$products[1]->image==''?'https://via.placeholder.com/600x370':image_crop($products[1]->image,600,370)}}" alt="#">
                    <div class="content">
                        <p>{{$products[1]->category->name}}</p>
                        <h3>{{$products[1]->name}} <br>Up to<span> 50%</span></h3>
                        <a href="{{route('product.single',$products[1]->id)}}">Shop Now</a>
                    </div>
                </div>
            </div>
            <!-- /End Single Banner  -->
        </div>
    </div>
</section>
<!-- End Midium Banner -->

<!-- Start Most Popular -->
<div class="product-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Hot Item</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    <!-- Start Single Product -->
                    @foreach ($products as $product)
                        <div class="single-product">
                        <div class="product-img">
                            <a href="{{route('product.single',$product->id)}}">
                                <img class="default-img" src="{{$product->image == ''?'https://via.placeholder.com/550x750':image_crop($product->image,550,750)}}" alt="#">
                                <img class="hover-img" src="{{$product->image == ''?'https://via.placeholder.com/550x750':image_crop($product->image,550,750)}}" alt="#">
                                <span class="out-of-stock">Hot</span>
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i
                                            class=" ti-eye"></i><span>Quick Shop</span></a>
                                    <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to
                                            Wishlist</span></a>
                                    <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to
                                            Compare</span></a>
                                </div>
                                <div class="product-action-2">
                                    {{-- <a title="Add to cart" href="#">Add to cart</a> --}}
                                    @if($product->user_id != Auth::id())
                                    <form action="{{route('cart.store')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <input type="hidden" name="quantity" value="1">
                                        <a title="Add to cart" href="#" onclick="event.preventDefault();this.closest('form').submit();">Add to cart</a>
                                    </form>
                                    @else
                                    <p class="m-2">You Own This Product</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="{{route('product.single',$product->id)}}">{{$product->name}}</a></h3>
                            <div class="product-price">
                                <span class="old">${{$product->oldprice}}</span>
                                <span>${{$product->price}}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- End Single Product -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->

<!-- Start Shop Home List  -->
<section class="shop-home-list section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section-title">
                            <h1>On sale</h1>
                        </div>
                    </div>
                </div>
                @foreach ($threeProducts as $product)
                <!-- Start Single List  -->
                <div class="single-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="list-image overlay">
                                <img src="{{$product->image == ''?'https://via.placeholder.com/115x140':image_crop($product->image,115,140)}}" alt="#">
                                {{-- <a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a> --}}
                                <form action="{{route('cart.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="quantity" value="1">
                                    <a href="#" class="buy" onclick="event.preventDefault();this.closest('form').submit();"><i class="fa fa-shopping-bag"></i></a>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 no-padding">
                            <div class="content">
                                <h4 class="title"><a href="{{route('product.single',$product->id)}}">{{$product->name}}</a></h4>
                                <p class="price with-discount">${{$product->price}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single List  -->
                @endforeach

            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section-title">
                            <h1>Best Seller</h1>
                        </div>
                    </div>
                </div>
                @foreach ($threeProducts as $product)
                <!-- Start Single List  -->
                <div class="single-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="list-image overlay">
                                <img src="{{$product->image == ''?'https://via.placeholder.com/115x140':image_crop($product->image,115,140)}}" alt="#">
                                {{-- <a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a> --}}
                                <form action="{{route('cart.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="quantity" value="1">
                                    <a href="#" class="buy" onclick="event.preventDefault();this.closest('form').submit();"><i class="fa fa-shopping-bag"></i></a>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 no-padding">
                            <div class="content">
                                <h4 class="title"><a href="{{route('product.single',$product->id)}}">{{$product->name}}</a></h4>
                                <p class="price with-discount">${{$product->price}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single List  -->
                @endforeach
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section-title">
                            <h1>Top viewed</h1>
                        </div>
                    </div>
                </div>
                @foreach ($threeProducts as $product)
                <!-- Start Single List  -->
                <div class="single-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="list-image overlay">
                                <img src="{{$product->image == ''?'https://via.placeholder.com/115x140':image_crop($product->image,115,140)}}" alt="#">
                                {{-- <a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a> --}}
                                <form action="{{route('cart.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="quantity" value="1">
                                    <a href="#" class="buy" onclick="event.preventDefault();this.closest('form').submit();"><i class="fa fa-shopping-bag"></i></a>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 no-padding">
                            <div class="content">
                                <h4 class="title"><a href="{{route('product.single',$product->id)}}">{{$product->name}}</a></h4>
                                <p class="price with-discount">${{$product->price}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single List  -->
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- End Shop Home List  -->

<!-- Start Cowndown Area -->
<section class="cown-down">
    <div class="section-inner ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-12 padding-right">
                    <div class="image">
                        <img src="{{$products[0]->image==''?'https://via.placeholder.com/750x590':image_crop($products[0]->image,750,590)}}" alt="#">
                    </div>
                </div>
                <div class="col-lg-6 col-12 padding-left">
                    <div class="content">
                        <div class="heading-block">
                            <p class="small-title">Deal of day</p>
                            <h3 class="title">{{$products[0]->name}}</h3>
                            <p class="text">{{$products[0]->description}}</p>
                            <h1 class="price">${{$products[0]->price}} <s>${{$products[0]->oldprice}}</s></h1>
                            <div class="coming-time">
                                <div class="clearfix" data-countdown="2021/06/30"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Cowndown Area -->

<!-- Start Shop Blog  -->
<section class="shop-blog section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>From Our Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Blog  -->
                    <div class="shop-single-blog">
                        <img src="{{$post->image==''?'https://via.placeholder.com/370x300':image_crop($post->image,370,300)}}" alt="#">
                        <div class="content">
                            <p class="date"> Posted {{ $post->created_at->diffForHumans()  }}</p>
                            <p class="text-info">By {{$post->user->name}}</p>
                            <p class="text-warning">{{$post->category->name}}</p>
                            <a href={{ route('post.single',$post->slug) }} class="title">{{ $post->title }}</a>
                            <p>{{ Str::substr($post->body, 0, 50) }} {{ strlen($post->body) > 50 ? "...": "" }}</p>
                            <a href={{ route('post.single',$post->slug) }} class="more-btn">Continue Reading</a>
                        </div>
                    </div>
                    <!-- End Single Blog  -->
                </div>   
            @endforeach
        </div>
    </div>
</section>
<!-- End Shop Blog  -->

<!-- Start Shop Services Area -->
<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Free shiping</h4>
                    <p>Orders over $100</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Free Return</h4>
                    <p>Within 30 days returns</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Sucure Payment</h4>
                    <p>100% secure payment</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Best Peice</h4>
                    <p>Guaranteed price</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services Area -->  
<!-- upto here index specific -->
@include('partials._newsletter')
@include('partials._modal')
@endsection

@section('scripts')
    <script>
        document.getElementById("home").classList.add("active");
    </script>
@endsection

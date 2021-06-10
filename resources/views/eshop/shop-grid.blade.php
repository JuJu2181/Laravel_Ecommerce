@extends('layouts.primary')

@section('title','Shop List')

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href={{ route('eshop.shop-grid') }}>Shop Grid</a></li>
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
                        @include('partials._shoptop')
                        <!--/ End Shop Top -->
                    </div>
                </div>
                <h2 class="mt-4">All The Shop Owners - {{ $vendors->count() }}</h2>
                <div class="row">
                    @foreach ($vendors as $vendor)
                        
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{ route('eshop.getSingleShop',$vendor->id) }}">
                                    <img class="default-img" src="{{$vendor->image == ''?  'https://via.placeholder.com/550x750':image_crop($vendor->image)}}" alt="#">
                                </a>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{ route('eshop.getSingleShop',$vendor->id) }}">
                                    {{ $vendor->name }}    
                                </a></h3>
                                <div>
                                    <span>No. Of Products: {{ $vendor->products->count() }}</span>
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
        document.getElementById("shop").classList.add("active");
    </script>
@endsection
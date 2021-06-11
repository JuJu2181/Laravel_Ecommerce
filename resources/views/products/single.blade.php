@extends('layouts.primary')

@section('title',$product['name'])

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li><a href={{ route('product.index') }}>Products<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href={{ route('product.single',$product->id) }}>{{ $product->name }}</a></li>
</ul>
@endsection

@section('content')
    @include('partials._breadcumb')
    <div class="container  p-5">
        <img src="{{ $product->image == '' ? "https://via.placeholder.com/950x460":image_crop($product->image,950,460)}}" alt="#">
        <article class="m-4">
            <h2 class="m-1">{{ $product['name'] }}</h2>
            <p class="m-1"> {{$product['description']}} </p>
            <p class="m-1"><strong>Price: </strong>{{ $product['price'] }}</p>
            <span> <strong>Category: </strong> {{ $product->category->name }}</span>
        </article>
        @if ($product->user_id != Auth::id())
        <form action="{{route('cart.store')}}" method="post">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <input type="hidden" name="quantity" value="1">
            <a title="Add to cart" href="#" onclick="event.preventDefault();this.closest('form').submit();">Add to cart</a>
        </form>
        @else
        <p>You Own This Product As A Vendor</p>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById("product").classList.add("active");
    </script>
@endsection

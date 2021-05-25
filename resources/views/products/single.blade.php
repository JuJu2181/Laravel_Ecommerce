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
        <img src="https://via.placeholder.com/950x460" alt="#">
        <article class="m-4">
            <h2 class="m-1">{{ $product['name'] }}</h2>
            <p class="m-1"> {{$product['description']}} </p>
            <p class="m-1"><strong>Price: </strong>{{ $product['price'] }}</p>
            <span> <strong>Category: </strong> {{ $product->category->name }}</span>
        </article>
        
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById("product").classList.add("active");
    </script>
@endsection

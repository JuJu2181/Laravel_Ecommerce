@extends('layouts.primary')

@section('title',$product['name'])

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li><a href={{ route('product.index') }}>Products<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href={{ route('product.single',$product->id) }}>{{ $product->name }}</a></li>
</ul>
@endsection

@section('stylesheets')
<style>


.card {
    border-radius: 5px;
    background-color: #fff;
    padding-left: 60px;
    padding-right: 60px;
    margin-top: 30px;
    padding-top: 30px;
    padding-bottom: 30px
}

.rating-box {
    width: 130px;
    height: 130px;
    margin-right: auto;
    margin-left: auto;
    background-color: #FBC02D;
    color: #fff
}

.rating-label {
    font-weight: bold
}

.rating-bar {
    width: 300px;
    padding: 8px;
    border-radius: 5px
}

.bar-container {
    width: 100%;
    background-color: #f1f1f1;
    text-align: center;
    color: white;
    border-radius: 20px;
    cursor: pointer;
    margin-bottom: 5px
}

.bar-5 {
    width: 70%;
    height: 13px;
    background-color: #FBC02D;
    border-radius: 20px
}

.bar-4 {
    width: 30%;
    height: 13px;
    background-color: #FBC02D;
    border-radius: 20px
}

.bar-3 {
    width: 20%;
    height: 13px;
    background-color: #FBC02D;
    border-radius: 20px
}

.bar-2 {
    width: 10%;
    height: 13px;
    background-color: #FBC02D;
    border-radius: 20px
}

.bar-1 {
    width: 0%;
    height: 13px;
    background-color: #FBC02D;
    border-radius: 20px
}

td {
    padding-bottom: 10px
}

.star-active {
    color: #FBC02D;
    margin-top: 10px;
    margin-bottom: 10px
}

.star-active:hover {
    color: #F9A825;
    cursor: pointer
}

.star-inactive {
    color: #CFD8DC;
    margin-top: 10px;
    margin-bottom: 10px
}

.blue-text {
    color: #0091EA
}

.content {
    font-size: 18px
}

.profile-pic {
    width: 90px;
    height: 90px;
    border-radius: 100%;
    margin-right: 30px
}

.pic {
    width: 80px;
    height: 80px;
    margin-right: 10px
}

.vote {
    cursor: pointer
}

fieldset,
label {
    margin: 0;
    padding: 0
}

.rating {
    border: none;
    margin-right: 49px
}

.myratings {
    font-size: 85px;
    color: green
}

.rating>[id^="star"] {
    display: none
}

.rating>label:before {
    margin: 5px;
    font-size: 2.25em;
    font-family: FontAwesome;
    display: inline-block;
    content: "\f005"
}

.rating>.half:before {
    content: "\f089";
    position: absolute
}

.rating>label {
    color: #ddd;
    float: right
}

.rating>[id^="star"]:checked~label,
.rating:not(:checked)>label:hover,
.rating:not(:checked)>label:hover~label {
    color: #FFD700
}

.rating>[id^="star"]:checked+label:hover,
.rating>[id^="star"]:checked~label:hover,
.rating>label:hover~[id^="star"]:checked~label,
.rating>[id^="star"]:checked~label:hover~label {
    color: #FFED85
}

.reset-option {
    display: none
}

.reset-button {
    margin: 6px 12px;
    background-color: rgb(255, 255, 255);
    text-transform: uppercase
}
</style>
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
        <div class="col-12 text-center">
        <form action="{{route('cart.store')}}" method="post">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <input type="hidden" name="quantity" value="1">
            <a title="Add to cart" href="#" onclick="event.preventDefault();this.closest('form').submit();" class="btn">Add to cart</a>
        </form>
    </div>
        @else
        <div class="col-12 text-center">
        <p class="text-warning">You Own This Product As A Vendor</p>
        </div>
        @endif
    </div>
    @include('partials._review')
@endsection

@section('scripts')
    <script>
        document.getElementById("product").classList.add("active");
        $(document).ready(function(){
        $("input[type='radio']").prop('checked',false);
        $("input[type='radio']").click(function(){
        // $(".reset-option").show();
        var sim = $("input[type='radio']:checked").val();
        //alert(sim);
        if (sim<3) { 
            $('.myratings').css('color','red');
            $(".myratings").text(sim); 
        }else{ 
                $('.myratings').css('color','green'); 
                $(".myratings").text(sim); 
        } 
        }); 
        });
    </script>
@endsection

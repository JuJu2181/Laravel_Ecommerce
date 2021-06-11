@extends('layouts.primary')

@section('title','Shopping Cart')

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href={{ route('eshop.cart') }}>Shopping Cart</a></li>
</ul>
@endsection

@section('content')
@include('partials._breadcumb')
<!-- cart only section -->

<!-- Shopping Cart -->
<div class="shopping-cart section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Shopping Summery -->
                <table class="table shopping-summery">
                    <thead>
                        <tr class="main-hading">
                            <th>PRODUCT</th>
                            <th>NAME</th>
                            <th class="text-center">UNIT PRICE</th>
                            <th class="text-center">QUANTITY</th>
                            <th class="text-center">TOTAL</th>
                            <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- single item --}}
                        @foreach ($order_items as $order_item)
                        @php
                        // $product = App\Models\Product::find($order_item->product_id);
                        @endphp
                        <tr id="orderItem{{$order_item->id}}">
                            <td class="image" data-title="No"><img
                                    src='{{$order_item->product->image == ''?"https://via.placeholder.com/100x100":image_crop($order_item->product->image,100,100)}}'
                                    alt="#">
                            </td>
                            <td class="product-des" data-title="Description">
                                <p class="product-name"><a
                                        href="{{route('product.single',$order_item->product->id)}}">{{$order_item->product->name}}</a>
                                </p>
                                <p class="product-des">{{$order_item->product->description}}</p>
                            </td>
                            <td class="price" data-title="Price"><span id="unitPrice">${{$order_item->product_price}}
                                </span></td>
                            <td class="qty" data-title="Qty">
                                {{-- using form for update --}}
                                <form action="{{route('cart.update',$order_item->id)}}"method="post">
                                    @csrf
                                    @method("PUT")
                                    <!-- Input Order -->
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number"
                                                {{$order_item->quantity>1?'':'disabled="disabled"'}} id="decrement-btn"
                                                data-type="minus" data-field="quant[{{$order_item->id}}]"
                                                onclick="decrementCount({{$order_item->id}})">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>


                                        <input type="text" name="quant[{{$order_item->id}}]" class="input-number"
                                            data-min="1" data-max="20" value="{{$order_item->quantity}}">

                                        {{-- <input type="text" name="quant[{{$order_item->id}}]" class="input-number"
                                        data-min="1" data-max="20" value="{{$order_item->quantity}}"> --}}

                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number"
                                                {{$order_item->quantity>20?'disabled="disabled"':''}} id="increment-btn"
                                                data-type="plus" data-field="quant[{{$order_item->id}}]"
                                                onclick="incrementCount({{$order_item->id}})">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
          
                                        
                                    </div>
                                    <button type="submit" 
                                    >
                                            
                                    <i class=" ti-pencil"></i>
                                    </button>
                                </form>
                                <!--/ End Input Order -->
                            </td>
                            <td class="total-amount" data-title="Total"><span>${{$order_item->total}}</span></td>
                            {{-- to delete using ajax request --}}
                            <meta name="csrf-token" content="{{ csrf_token() }}">

                            <td class="action" data-title="Remove">
                                {{-- this is for ajax delete --}}
                                {{-- <a  data-id="{{$order_item->id}}" onclick="deleteCartItem({{ $order_item->id }})"
                                id="deleteCartItem"><i class="ti-trash remove-icon"></i></a> --}}
                                {{-- this is for form delete --}}
                                <form action="{{route('cart.destroy',$order_item->id)}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit"><i class="ti-trash remove-icon"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--/ End Shopping Summery -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Total Amount -->
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-8 col-md-5 col-12">
                            <div class="left">
                                <div class="coupon">
                                    <form action="#" target="_blank">
                                        <input name="Coupon" placeholder="Enter Your Coupon">
                                        <button class="btn">Apply</button>
                                    </form>
                                </div>
                                <div class="checkbox">
                                    <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox">
                                        Shipping (+10$)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-7 col-12">
                            <div class="right">
                                <ul>
                                    <li>Cart Subtotal<span id="subTotalPrice">${{$order->sub_total}}</span></li>
                                    <li>Shipping<span id="shippingPrice">${{$order->shipping_price}}</span></li>
                                    <li>You Save<span id="discountPrice">${{$order->discount}}</span></li>
                                    <li class="last">You Pay<span id="totalPrice">${{$order->total_price}}</span></li>
                                </ul>
                                <div class="button5">
                                    @if ($order->orderItems->count()>0)
                                    <a href="{{route('eshop.checkout')}}" class="btn">Checkout</a>
                                    @else 
                                    <button class="btn" disabled>Add Items To Checkout</button>
                                    @endif
                                    <a href="{{route('eshop.home')}}" class="btn">Continue shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ End Total Amount -->
            </div>
        </div>
    </div>
</div>
<!--/ End Shopping Cart -->

<!-- Start Shop Services Area  -->
<section class="shop-services section">
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

<!-- End cart only section->
	
    @include('partials._newsletter')
    @include('partials._modal')    

    @section('scripts')
        <script>
            document.getElementById("shop").classList.add("active");
            const decrementBtn = document.getElementById("decrement-btn");
            const incrementBtn = document.getElementById("increment-btn");
            const deleteBtn = document.getElementById('deleteCartItem');
            {{-- function to update the finalPrice --}}
            function updateFinalPrice(){
                let finalPrice = 0;
                $("table > tbody > tr > .total-amount").each(function(){
                    finalPrice += parseInt($(this).text().replace('$',''));
                });
                console.log("Final:"+finalPrice);
                $('#subTotalPrice').text('$'+finalPrice);
                $('#totalPrice').text('$'+finalPrice);
            }

            {{-- function to update view when increment and decrement is pressed --}}
            function incrementCount(id){
                let currentQuantity = parseInt($(`#orderItem${id} .input-number`).val());
                let increasedQuantity = currentQuantity+1;
                let unitPrice = parseInt($(`#orderItem${id} #unitPrice`).text().replace('$',''));
                let updatedPrice = increasedQuantity*unitPrice;
                $(`#orderItem${id} .total-amount`).text('$'+updatedPrice);
                {{-- updating the final prices --}}
                updateFinalPrice();
            }

            function decrementCount(id){
                let currentQuantity = parseInt($(`#orderItem${id} .input-number`).val());
                let decreasedQuantity = currentQuantity-1;
                let unitPrice = parseInt($(`#orderItem${id} #unitPrice`).text().replace('$',''));
                let updatedPrice = decreasedQuantity*unitPrice;
                $(`#orderItem${id} .total-amount`).text('$'+updatedPrice);
                {{-- updating the final prices --}}
                updateFinalPrice();
            }

            {{-- function for ajax update --}}
            function updateCartItem(id){
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                url:"/cart/"+id,
                type: 'PUT',
                data:{
                    "id":id,
                    "_token":token,
                },
                success:function(){
                    console.log("Item Updated");
                }
                });
            }


            {{-- function for ajax delete --}}
            {{-- function deleteCartItem(id){
                console.log(id);
                let token = $("meta[name='csrf-token']").attr("content");
                if(confirm("Are you sure to remove this item?\n press 'OK' to confirm")){
                $.ajax({
                url:"/cart/"+id,
                type: 'DELETE',
                data:{
                    "id":id,
                    "_token":token,
                },
                success:function(){
                    console.log("deleted");
                    $('#orderItem'+id).remove();
                    updateFinalPrice();
                }
                });
            }else{
                console.log("cancelled");
            }
            } --}}
        </script>
    @endsection

@stop

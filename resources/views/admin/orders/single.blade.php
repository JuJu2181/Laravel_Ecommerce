@section('title','Order '.$order->id.' Details')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <div class="jumbotron">
                <h2>Details For Order {{$order->id}}</h2>
                <div class="text-info" style="font-size: 1.1rem;">Order Id: {{$order->id}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Order Maker: {{$order->user->name}}</div>
                <div class="text-danger" style="font-size: 1.1rem;">Order Status: {{$order->order_status}}</div>
                <div class="text-info" style="font-size: 1.1rem;">No Of Items: {{$order->orderItems->count()}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Order Sub_total: Rs {{$order->sub_total}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Discount: Rs {{$order->discount}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Shipping Price: Rs {{$order->shipping_price}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Total Price: Rs {{$order->total_price}}</div>
               {{-- check if it is order maker --}}
                @if ($order->user_id == Auth::id() && $order->order_status == 'cart') 
                <a href="{{route('cart.index')}}" class="btn btn-outline-secondary btn-block mt-3"><i class="typcn typcn-shopping-cart mr-3"></i>View Shopping Cart</a>
                 {{-- to directly delete the product instead of redirecting to the delete page --}}
                <form action={{ route('admin.orders.destroy',$order->id) }} method="post" class="mt-2" id="deleteForm">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-block" id="deleteButton">
                    <span><i class="typcn typcn-trash mr-3"></i></span>
                    Delete This Order
                </button>
                </form>
                @endif
            </div>
            <h2>All Order Items For Order {{$order->id}}</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Product</td>
                        <td>Vendor</td>
                        <td>Date</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Total Price</td>
                    </tr>
                    @foreach ($order_items as $order_item)
                    <tr id="cartId{{ $order_item->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$order_item->product->name}}</td>
                        <td>{{ $order_item->product->user->name }}</td>
                        <td>{{date('M j, Y, g:i a',strtotime($order_item->created_at))}}</td>
                        <td>  {{$order_item->product_price }} </td>
                        <td>{{$order_item->quantity}}</td>
                        <td>{{ $order_item->total }}
                        </td>       
                    </tr>
                        @endforeach
                </table>
            </div>
        </div>
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("orders").classList.add("active");
    </script>
@stop
</x-admin.layout>
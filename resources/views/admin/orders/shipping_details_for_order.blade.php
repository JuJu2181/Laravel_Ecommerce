@section('title','Shipping Details For Order '.$orderShippingDetail->order->id)
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <div class="jumbotron">
                <h2>Shipping Details For Order {{$orderShippingDetail->order->id}}</h2>
                <div class="text-info" style="font-size: 1.1rem;">Order Id: {{$orderShippingDetail->order->id}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Order Maker Name: {{$orderShippingDetail->name}}</div>
                <div class="text-danger" style="font-size: 1.1rem;">Email: {{$orderShippingDetail->email}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Number: {{$orderShippingDetail->number}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Country: {{$orderShippingDetail->country}}</div>
                <div class="text-info" style="font-size: 1.1rem;">State: {{$orderShippingDetail->state}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Post Box No: {{$orderShippingDetail->post}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Address 1: {{$orderShippingDetail->address1}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Address 2: {{$orderShippingDetail->address2}}</div>
                <div class="text-dark" style="font-size: 1.1rem;">Order Item Id: {{$order_item->id}}</div>
                <div class="text-dark" style="font-size: 1.1rem;">Order Item name: {{$order_item->product->name}}</div>
                <div class="text-dark" style="font-size: 1.1rem;">Order Item Status: {{$order_item->status}}</div>
                @if($order_item->status != 'complete')
                <form action="{{route('admin.orders.completeOrderByVendor')}}" method="post">
                @csrf
                <input type="hidden" name="order_item_id" value="{{$order_item->id}}">
                <a href="#" class="mt-5 btn btn-block btn-outline-success" onclick="event.preventDefault();this.closest('form').submit()">Complete Order <span class="typcn typcn-tick"></span></a>
                </form>
                @endif
                <a href="{{route('admin.orders.getVendorOrders')}}" class="mt-5 btn btn-block btn-outline-secondary">Return To All Orders <span class="typcn typcn-arrow"></span></a>
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
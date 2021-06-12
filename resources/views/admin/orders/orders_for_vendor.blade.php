@section('title','All Orders For '.Auth::user()->name)
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <h2>{{$title}}</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Product Name</td>
                        <td>Order No</td>
                        <td>From</td>
                        @if (Auth::user()->role == 'admin')
                            <td>To</td>
                        @endif
                        <td>Date</td>
                        <td>Order Status/ Item Status</td>
                        <td>Unit Price</td>
                        <td>Quantity</td>
                        <td>Total Price</td>
                        <td>Actions</td>
                    </tr>
                    @foreach ($order_products as $order_product)
                    <tr> 
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$order_product->product->name}}</td>
                        <td>{{$order_product->order->id}}</td>
                        <td>{{ $order_product->order->user->name }}</td>
                        @if (Auth::user()->role == 'admin')
                        <td>{{ $order_product->product->user->name }}</td>
                        @endif
                        <td>{{date('M j, Y, g:i a',strtotime($order_product->created_at))}}</td>
                        <td>  {{$order_product->order->order_status }}/{{$order_product->status}} </td>
                        <td>{{$order_product->product_price}}</td>
                        <td>{{$order_product->quantity}}</td>
                        <td>{{ $order_product->total }}</td>     
                        <td>   
                        @if(Auth::user()->role=='admin')
                        {{-- To show product details --}}
                        <a href="{{route('admin.orders.show',$order_product->order->id)}}" class="btn btn-info btn-block">  
                            Show Order Details
                            <span><i class="typcn typcn-edit"></i></span>
                        </a>
                        @if ($order_product->product->user_id == Auth::id())
                        <a href="{{route('admin.orders.getShippingDetailsForOrder',$order_product->id)}}" class="btn btn-success btn-block">Shipping Details<span><i class="typcn typcn-clipboard"></i></span></a>     
                        @endif
                        @else 
                        <a href="{{route('admin.orders.getShippingDetailsForOrder',$order_product->id)}}" class="btn btn-success btn-block">Shipping Details<span><i class="typcn typcn-clipboard"></i></span></a>
                        @endif
                        </td>
                        {{-- to delete using ajax request --}}
                                {{-- <meta name="csrf-token" content="{{ csrf_token() }}">
                                <button id="deleteOrder" data-id="{{ $order->id }}" class="btn btn-danger btn-block mt-2" onclick="deleteOrder({{ $order->id }})">Delete
                                <span><i class="typcn typcn-trash"></i></span
                                </button>
                            </td> --}}
                    </tr>
                        @endforeach
                </table>
                {{-- <div class="mt-4">
                    {{$order_products->links()}}
                </div> --}}
            </div>
        </div>
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("orders").classList.add("active");

        // // for ajax delete
        // function deleteOrder(id){
        //     console.log(id);
        //     let token = $("meta[name='csrf-token']").attr("content");
        //     if(confirm("Are you sure to delete this order?\n press 'OK' to confirm")){
        //         $.ajax({
        //         url:"/order/"+id,
        //         type: 'DELETE',
        //         data:{
        //             "id":id,
        //             "_token":token,
        //         },
        //         success:function(){
        //             console.log("deleted");
        //             $('#orderId'+id).remove();
        //         }
        //         });
        //     }else{
        //         console.log("cancelled");
        //     }
            
        // }
    </script>
@stop
</x-admin.layout>
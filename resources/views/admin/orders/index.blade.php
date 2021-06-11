@section('title',Auth::user()->name.' - All Orders')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <h2>All Orders</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Order No</td>
                        <td>Maker</td>
                        <td>Date</td>
                        <td>Status</td>
                        <td>Total Items</td>
                        <td>Total Price</td>
                        <td>Actions</td>
                    </tr>
                    @foreach ($orders as $order)
                    <tr id="orderId{{ $order->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$order->id}}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{date('M j, Y, g:i a',strtotime($order->created_at))}}</td>
                        <td>  {{$order->order_status }} </td>
                        <td>{{$order->orderItems->count()}}</td>
                        <td>{{ $order->total_price }}</td>     
                        <td>   
                        {{-- To show product details --}}
                        <a href="{{route('admin.orders.show',$order->id)}}" class="btn btn-info btn-block">  
                            Show Details
                            <span><i class="typcn typcn-edit"></i></span>
                        </a>
                        {{-- to delete using ajax request --}}
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <button id="deleteOrder" data-id="{{ $order->id }}" class="btn btn-danger btn-block mt-2" onclick="deleteOrder({{ $order->id }})">Delete
                                <span><i class="typcn typcn-trash"></i></span
                                </button>
                            </td>
                    </tr>
                        @endforeach
                </table>
                <div class="mt-4">
                    {{$orders->links()}}
                </div>
            </div>
        </div>
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("orders").classList.add("active");

        // for ajax delete
        function deleteOrder(id){
            console.log(id);
            let token = $("meta[name='csrf-token']").attr("content");
            if(confirm("Are you sure to delete this order?\n press 'OK' to confirm")){
                $.ajax({
                url:"/order/"+id,
                type: 'DELETE',
                data:{
                    "id":id,
                    "_token":token,
                },
                success:function(){
                    console.log("deleted");
                    $('#orderId'+id).remove();
                }
                });
            }else{
                console.log("cancelled");
            }
            
        }
    </script>
@stop
</x-admin.layout>
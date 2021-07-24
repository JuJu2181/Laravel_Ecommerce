@section('title',Auth::user()->name.' - Admin Dashboard')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <div class="az-dashboard-one-title">
                    <div>
                        <h2 class="az-dashboard-title">Hi {{ Auth::user()->name }}, welcome back!</h2> 
                        <p class="az-dashboard-text">Here is your web analytics report.</p>

                    </div>

                </div><!-- az-dashboard-one-title -->
                @if (Auth::user()->role =='vendor' && Auth::user()->vendor_status == 'not_verified')
                    <p>You have been added to vendors list for verification. This may take time. Sorry but till you are not verified you can't access vendor features. We will notify you when available</p>
                @endif
                {{-- <div class="az-dashboard-nav">
                    <nav class="nav">
                        <a class="nav-link active" data-toggle="tab" href="#">Overview</a>
                        <a class="nav-link" data-toggle="tab" href="#">Audiences</a>
                        <a class="nav-link" data-toggle="tab" href="#">Demographics</a>
                        <a class="nav-link" data-toggle="tab" href="#">More</a>
                    </nav>

                    <nav class="nav">
                        <a class="nav-link" href="#"><i class="far fa-save"></i> Save Report</a>
                        <a class="nav-link" href="#"><i class="far fa-file-pdf"></i> Export to PDF</a>
                        <a class="nav-link" href="#"><i class="far fa-envelope"></i>Send to Email</a>
                        <a class="nav-link" href="#"><i class="fas fa-ellipsis-h"></i></a>
                    </nav>
                </div> --}}
                <div class="card card-dashboard-one">
                    <div class="card-header">
                        @php
                        $dateFilters = ['Day','Week','Month','Year'];
                        $old_filter = request('filterDate') != ""?request('filterDate'):"";
                        if(Auth::user()->role == 'subvendor'){
                        $subvendor = App\Models\SubVendor::where('email','=',Auth::user()->email)->first();
                        $vendor_responsibilities = json_decode($subvendor->responsibility);
                        }
                        @endphp
                        {{-- @dd($vendor_responsibilities) --}}
                        <h5>Date Range</h5>
                        <div class="btn-group">
                            <form action="{{route('admin.dashboard')}}" method="GET">
                                <select name="filterDate" class="btn active">
                                    @foreach ($dateFilters as $dateFilter)
                                    <option value="{{$dateFilter}}" {{$dateFilter == $old_filter?"selected":""}}>
                                        {{$dateFilter}}</option>
                                    @endforeach
                                </select>
                                <a href="#" class="btn typcn typcn-arrow-shuffle"
                                    onclick="event.preventDefault();this.closest('form').submit()"></a>
                            </form>
                        </div>
                    </div>
                </div>
                @unless (Auth::user()->role == 'user' || Auth::user()->vendor_status == 'not_verified'||(Auth::user()->role == 'subvendor' && !in_array('orders',$vendor_responsibilities)))
                @if (Auth::user()->role == 'admin')
                <div class="row row-sm mg-b-20">
                    <div class="col-lg-7 ht-lg-100p mt-3">
                        <div class="card card-dashboard-one">
                            <div class="card-header">
                                <div>
                                    <h5 class="card-title">Users Report</h5>
                                    <p class="card-text">New Users in current date range.</p>
                                </div>

                            </div><!-- card-header -->
                            <div class="card-body">
                                <div class="card-body-top">
                                    <div>
                                        <label class="mg-b-0">New Users</label>
                                        <h2>{{count($all_users)}}</h2>
                                    </div>
                                    <div>
                                        <label class="mg-b-0">Normal Users</label>
                                        <h2>{{count($normal_users)}}</h2>
                                    </div>
                                    <div>
                                        <label class="mg-b-0">New Vendors</label>
                                        <h2>{{count($vendors)}}</h2>
                                    </div>
                                    <div>
                                        <label class="mg-b-0">New Sub Vendors</label>
                                        <h2>{{count($subvendors)}}</h2>
                                    </div>
                                    <div>
                                        <label class="mg-b-0">New Purchases</label>
                                        <h2>{{count($all_orders)}}</h2>
                                    </div>
                                </div><!-- card-body-top -->
                                {{-- <div class="flot-chart-wrapper">
                                    <div id="flotChart" class="flot-chart"></div>
                                </div><!-- flot-chart-wrapper --> --}}
                                <div class="table-responsive mt-5">
                                    <table class="table table-hover table-bordered mg-b-0">
                                        <tr>
                                            <td>S.N.</td>
                                            <td>Name</td>
                                            <td>Role</td>
                                            <td>Joined Date</td>
                                        </tr>
                                        @foreach ($all_users as $user)
                                        <tr id="userId{{ $user->id }}">

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>

                                            <td>{{ $user->role }}</td>
                                            <td>
                                                {{$user->created_at->diffForHumans()}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div> <!-- card-body -->
                            </div><!-- card -->
                        </div><!-- col -->
                    </div><!-- row -->
                <div class="col-lg-7 ht-lg-100p mt-3">
                    <div class="card card-dashboard-one">
                        <div class="card-header">
                            <div>
                                <h5 class="card-title">Orders Report</h5>
                                <p class="card-text">New Orders in current date range.</p>
                            </div>

                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="card-body-top">
                                <div>
                                    <label class="mg-b-0">New Orders</label>
                                    <h2>{{count($all_orders)}}</h2>
                                </div>
                                <div>
                                    <label class="mg-b-0">Completed Orders</label>
                                    <h2>{{count($completed_orders)}}</h2>
                                </div>
                                <div>
                                    <label class="mg-b-0">Pending Orders</label>
                                    <h2>{{count($pending_orders)}}</h2>
                                </div>

                            </div><!-- card-body-top -->
                            <div class="table-responsive mt-5">
                                <table class="table table-hover table-bordered mg-b-0">
                                    <tr>
                                        <td>S.N.</td>
                                        <td>Order Id</td>
                                        <td>Status</td>
                                        <td>From</td>
                                        <td>Items Count</td>
                                        <td>Order Price</td>
                                        <td>Order Date</td>
                                    </tr>
                                    @foreach ($all_orders as $order)
                                    <tr id="orderId{{ $order->id }}">

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->id }}</td>

                                        <td>{{ $order->order_status }}</td>
                                        <td>{{$order->user->name}}</td>
                                        <td>{{$order->orderItems->count()}}</td>
                                        <td>{{$order->total_price}}</td>
                                        <td>
                                        {{$order->created_at->diffForHumans()}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div> <!-- card-body -->
                        </div><!-- card -->
                    </div><!-- col -->
                </div>
                @endif
                <div class="col-lg-7 ht-lg-100p mt-3">
                    <div class="card card-dashboard-one">
                        <div class="card-header">
                            <div>
                                <h5 class="card-title">Order Items Report For {{Auth::user()->name}}</h5>
                                <p class="card-text">New Order Items in current date range.</p>
                            </div>

                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="card-body-top">
                                <div>
                                    <label class="mg-b-0">New Order Items</label>
                                    <h2>{{count($all_orderItems)}}</h2>
                                </div>
                                <div>
                                    <label class="mg-b-0">Completed Order Items</label>
                                    <h2>{{count($completed_orderItems)}}</h2>
                                </div>
                                <div>
                                    <label class="mg-b-0">Pending Order Items</label>
                                    <h2>{{count($pending_orderItems)}}</h2>
                                </div>

                            </div><!-- card-body-top -->
                            <div class="table-responsive mt-5">
                                <table class="table table-hover table-bordered mg-b-0">
                                    <tr>
                                        <td>S.N.</td>
                                        <td>Item Name</td>
                                        <td>Order Id</td>
                                        <td>Status</td>
                                        <td>From</td>
                                        <td>Price</td>
                                        <td>Quantity</td>
                                        <td>Total Price</td>
                                        <td>Order Date</td>
                                    </tr>
                                    @foreach ($all_orderItems as $orderItem)
                                    <tr id="orderItemId{{ $orderItem->id }}">

                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{$orderItem->product->name}}
                                        </td>
                                        <td>{{ $orderItem->order_id }}</td>

                                        <td>{{ $orderItem->status }}</td>
                                        <td>{{$orderItem->order->user->name}}</td>
                                        <td>{{$orderItem->product_price}}</td>
                                        <td>{{$orderItem->quantity}}</td>
                                        <td>{{$orderItem->total}}</td>
                                        <td>
                                        {{$orderItem->created_at->diffForHumans()}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div> <!-- card-body -->
                        </div><!-- card -->
                    </div><!-- col -->
                </div>
                @endunless
                <div class="col-lg-7 ht-lg-100p mt-3">
                    <div class="card card-dashboard-one">
                        <div class="card-header">
                            <div>
                                <h5 class="card-title">My Orders History Report</h5>
                                <p class="card-text">New Orders in current date range.</p>
                            </div>

                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="card-body-top">
                                <div>
                                    <label class="mg-b-0">New Orders</label>
                                    <h2>{{count($my_all_orders)}}</h2>
                                </div>
                                <div>
                                    <label class="mg-b-0">Pending Orders</label>
                                    <h2>{{count($my_purchased_orders)}}</h2>
                                </div>
                                <div>
                                    <label class="mg-b-0">Completed Orders</label>
                                    <h2>{{count($my_completed_orders)}}</h2>
                                </div>

                            </div><!-- card-body-top -->
                            <div class="table-responsive mt-5">
                                <table class="table table-hover table-bordered mg-b-0">
                                    <tr>
                                        <td>S.N.</td>
                                        <td>Order Id</td>
                                        <td>Status</td>
                                        <td>Items Count</td>
                                        <td>Order Price</td>
                                        <td>Order Date</td>
                                        <td>Actions</td>
                                    </tr>
                                    @foreach ($my_all_orders as $order)
                                    <tr id="myOrderId{{ $order->id }}">

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->id }}</td>

                                        <td>{{ $order->order_status }}</td>
                                        <td>{{$order->orderItems->count()}}</td>
                                        <td>{{$order->total_price}}</td>
                                        <td>
                                        {{$order->created_at->diffForHumans()}}
                                        </td>
                                        <td>
                        {{-- To show product details --}}
                        <a href="{{route('admin.orders.show',$order->id)}}" class="btn btn-info btn-block">  
                            Show Details
                            <span><i class="typcn typcn-edit"></i></span>
                        </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div> <!-- card-body -->
                        </div><!-- card -->
                    </div><!-- col -->
                </div>
                </div>
            </div>
        </div>
    </div><!-- az-content -->
    @section('scripts')
    <script>
        document.getElementById("dashboard").classList.add("active");

    </script>
    @stop
</x-admin.layout>

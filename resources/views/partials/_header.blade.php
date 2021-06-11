<!-- Header -->
<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            <li><i class="ti-headphone-alt"></i> +060 (800) 801-582</li>
                            <li><i class="ti-email"></i> support@shophub.com</li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-8 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            <li><i class="ti-location-pin"></i> Store location</li>
                            <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li>

                            @if (Route::has('login'))
                            @auth
                            <li><i class="ti-user"></i> <a href="{{ url('/admin') }}">{{ Auth::User()->name }}</a></li>
                            <li>
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                    this.closest('form').submit();""><i class="ti-power-off"></i> Log Out</a>
                                </form>
                            </li>
                            @else
                            <li><i class="ti-power-off"></i><a href="{{ route('login') }}">Login</a></li>
                            @if (Route::has('register'))
                            <li><i class="ti-user"></i> <a href="{{ route('register') }}">Register</a></li>
                            @endif
                            @endauth
                            @endif


                        </ul>
                    </div>
                    <!-- End Top Right -->

                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{route('eshop.home')}}"><img src="/images/logo.png" alt="logo"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form" method="get" action="#">
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    @include('partials._search')
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Search Form -->
                        <div class="sinlge-bar">
                            <a href="#" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <div class="sinlge-bar">
                            <a href="{{route('admin.dashboard')}}" class="single-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
                        </div>
                        @auth
                        @php
                            $order = App\Models\Order::where('user_id',Auth::id())->where('order_status','cart')->first();
                            // dd($order_id);
                            if(empty($order)){
                            // creating order if not present in the session
                            // if we added user address for registration
                            // $user = Auth::user();
                            // $user->address
                            $order = new App\Models\Order;
                            $order->user_id = Auth::id();
                            $order->order_status = 'cart';
                            $order->sub_total = 0;
                            $order->discount = 0;
                            $order->shipping_price = 0;
                            $order->total_price = 0;
                            $order->shipping_address = '';
                            $order->save();
                            // session(['order_id'=>$order->id]);
                            $order_id = $order->id;
                            }else{
                                $order_id = $order->id;
                            }
                            $order = App\Models\Order::find($order_id);
                            $order_items = App\Models\OrderItem::whereOrderId($order_id)->get();
                        @endphp
                          <div class="sinlge-bar shopping">
                            <a href="#" class="single-icon"><i class="ti-bag"></i> <span
                                    class="total-count">{{$order_items->count()}}</span></a>
                            <!-- Shopping Item -->
                            <div class="shopping-item">
                                <div class="dropdown-cart-header">
                                    <span>{{$order_items->count()}} Items</span>
                                    <a href={{route('eshop.cart')}}>View Cart</a>
                                </div>
                                <!-- navbar shopping cart -->
                                <ul class="shopping-list" id="headerShoppingList">
                                    @if ($order_items->count() > 0)          
                                    @foreach ($order_items as $order_item)
                                    <li id="#orderItemOfHeader{{$order_item->id}}">
                                        <a class="cart-img" href="{{route('product.single',$order_item->product->id)}}"><img src='{{$order_item->product->image == ''?"https://via.placeholder.com/70x70":image_crop($order_item->product->image,70,70)}}'
                                                alt="#"></a>
                                        <h4><a href="{{route('product.single',$order_item->product->id)}}">{{$order_item->product->name}}</a></h4>
                                        <p class="quantity productQuantityInCart" id="">{{$order_item->quantity}}x -<span class="amount">${{$order_item->product_price}}</span></p>
                                    </li>
                                    @endforeach
                                    @else
                                    <li>No Items in Cart</li>
                                    @endif
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <span>Total</span>
                                        <span class="total-amount" id="totalHeaderCartPrice">${{$order->total_price}}</span>
                                    </div>
                                    <a href={{route('eshop.checkout')}} class="btn animate">Checkout</a>
                                </div>
                            </div>
                            <!--/ End Shopping Item -->
                        </div>
                        @endauth
                      
                            
                      

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials._header_inner_menu')
</header>
<!--/ End Header -->

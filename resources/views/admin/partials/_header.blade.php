<div class="az-header">
    <div class="container">
        <div class="az-header-left">
            <a href="{{route('admin.dashboard')}}" class="az-logo"><span></span> azia</a>
            <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
        </div><!-- az-header-left -->
        <div class="az-header-menu">
            <div class="az-header-menu-header">
                <a href={{ route('admin.dashboard') }} class="az-logo"><span></span> ADMIN</a>
                <a href="" class="close">&times;</a>
            </div><!-- az-header-menu-header -->
            {{-- some php code for sub vendors responsibility --}}
            @php
            if(Auth::user()->role == 'subvendor'){
                $subvendor = App\Models\SubVendor::where('email','=',Auth::user()->email)->first();
                $vendor_responsibilities = json_decode($subvendor->responsibility);
            }
            @endphp
            <ul class="nav">
                <li class="nav-item show" id="dashboard">
                    <a href={{ route('admin.dashboard') }} class="nav-link"><i class="typcn typcn-chart-area-outline"></i>
                        Dashboard</a>
                    </li>
                    <li class="nav-item show" id="cart">
                        <a href={{ route('eshop.cart') }} class="nav-link"><i class="typcn typcn-shopping-cart"></i>
                            Shopping Cart</a>
                    </li>
                    <li class="nav-item" id="orders">
                        <a href="#" class="nav-link with-sub"><i class="typcn typcn-clipboard"></i>
                            All Orders</a>
                        <nav class="az-menu-sub">
                                <a href={{ route('admin.orders.index') }} class="nav-link">My Orders</a>
                                @unless (Auth::user()->role == 'user' || Auth::user()->vendor_status == 'not_verified')
                                @unless(Auth::user()->role == 'subvendor' && !in_array('orders',$vendor_responsibilities))
                                    <a href="#" class="nav-link with-sub">Orders For Vendor</a>
                                    <nav class="az-menu-sub">
                                        <a href="{{route('admin.orders.getVendorOrders')}}" class="nav-link">All Orders</a>
                                        <a href="{{route('admin.orders.getPendingVendorOrders')}}" class="nav-link">
                                        Pending Orders</a>
                                        <a href="{{route('admin.orders.getCompletedVendorOrders')}}" class="nav-link">
                                            Completed Orders</a>
                                    </nav>
                                    @endunless
                                @endunless
                            </nav>
                    </li>
                    <li class="nav-item" id="reviews">
                        <a href="#" class="nav-link with-sub"><i class="typcn typcn-pencil"></i>
                            All Reviews</a>
                        <nav class="az-menu-sub">
                                <a href={{ route('admin.reviews.index') }} class="nav-link">My Reviews</a>
                                @unless (Auth::user()->role == 'user'|| Auth::user()->vendor_status == 'not_verified')
                                @unless(Auth::user()->role == 'subvendor' && !in_array('reviews',$vendor_responsibilities))
                                    <a href="{{route('admin.reviews.getProductReviews')}}" class="nav-link">Product Reviews</a>
                                    @endunless
                                @endunless
                            </nav>
                    </li>
                    <li class="nav-item" id="comments">
                        <a href="#" class="nav-link with-sub"><i class="typcn typcn-messages"></i>
                            All Comments</a>
                        <nav class="az-menu-sub">
                                <a href={{ route('admin.comments.index') }} class="nav-link">My Comments</a>
                                @unless (Auth::user()->role == 'user'|| Auth::user()->vendor_status == 'not_verified')
                                @unless(Auth::user()->role == 'subvendor' && !in_array('comments',$vendor_responsibilities))
                                    <a href="{{route('admin.comments.getPostComments')}}" class="nav-link">Post Comments</a>
                                @endunless
                                @endunless
                            </nav>
                    </li>
                @unless(Auth::user()->role == 'user'|| Auth::user()->vendor_status == 'not_verified')
                @unless(Auth::user()->role == 'subvendor' && !in_array('products',$vendor_responsibilities))
                <li class="nav-item" id="products">
                  <a href="" class="nav-link with-sub"><i class="typcn typcn-gift"></i> Products</a>
                  <nav class="az-menu-sub">
                      <a href={{ route('admin.products.index') }} class="nav-link">List</a>
                      <a href={{ route('admin.products.create') }} class="nav-link">Create</a>
                  </nav>
              </li>
              @endunless
              @unless (Auth::user()->role=='subvendor')
              <li class="nav-item" id="subvendors">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-group"></i>Sub Vendors</a>
                <nav class="az-menu-sub">
                    <a href={{ route('admin.subvendors.index') }} class="nav-link">List</a>
                    @unless(Auth::user()->role!='vendor')
                    <a href={{ route('admin.subvendors.create') }} class="nav-link">Register Subvendor</a>
                    {{-- <a href={{ route('admin.subvendors.change_task') }} class="nav-link">Change Tasks</a> --}}
                    @endunless
                </nav>
            </li>
            
              @unless(Auth::user()->role == 'vendor')
              <li class="nav-item" id="categories">
                <a href={{ route('admin.products.index') }} class="nav-link with-sub"><i class="typcn typcn-chart-pie"></i> Categories</a>
                <nav class="az-menu-sub">
                    <a href={{ route('admin.categories.index') }} class="nav-link">List</a>
                    <a href={{ route('admin.categories.create') }} class="nav-link">Create</a>
                </nav>
            </li>
            <li class="nav-item" id="users">
                <a href="#" class="nav-link with-sub"><i class="typcn typcn-group"></i> User</a>
                <nav class="az-menu-sub">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">List</a>
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                    <a href="{{ route('admin.users.getVendorRequests') }}" class="nav-link">Vendor Requests</a>
                    <a href="{{ route('admin.users.getVerifiedVendors') }}" class="nav-link">Verified Vendors</a>
                </nav>
            </li>
            <li class="nav-item" id="contacts">
                <a href="#" class="nav-link with-sub"><i class="typcn typcn-mail"></i> Contact Messages</a>
                <nav class="az-menu-sub">
                    <a href="{{ route('admin.contacts.index') }}" class="nav-link">List</a>
                </nav>
            </li>
            @endunless
            @endunless
            @unless(Auth::user()->role == 'subvendor' && !in_array('posts',$vendor_responsibilities))
                <li class="nav-item" id="posts">
                    <a href="#" class="nav-link with-sub"><i class="typcn typcn-document-text"></i>Post</a>
                    <nav class="az-menu-sub">
                        <a href="{{route('admin.posts.index')}}" class="nav-link">List</a>
                        <a href="{{route('admin.posts.create')}}" class="nav-link">Create</a>
                    </nav>
                </li>
                @endunless
                {{-- <li class="nav-item">
                    <a href="chart-chartjs.html" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i>
                        Charts</a>
                </li>
                <li class="nav-item">
                    <a href="form-elements.html" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i>
                        Forms</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-book"></i> Components</a>
                    <div class="az-menu-sub">
                        <div class="container">
                            <div>
                                <nav class="nav">
                                    <a href="elem-buttons.html" class="nav-link">Buttons</a>
                                    <a href="elem-dropdown.html" class="nav-link">Dropdown</a>
                                    <a href="elem-icons.html" class="nav-link">Icons</a>
                                    <a href="table-basic.html" class="nav-link">Table</a>
                                </nav>
                            </div>
                        </div><!-- container -->
                    </div>
                </li> --}}
            </ul>
            @endunless
        </div><!-- az-header-menu -->
        <div class="az-header-right">
            <a href="https://www.bootstrapdash.com/demo/azia-free/docs/documentation.html" target="_blank"
                class="az-header-search-link"><i class="far fa-file-alt"></i></a>
            <a href="" class="az-header-search-link"><i class="fas fa-search"></i></a>
            <div class="az-header-message">
                <a href="#"><i class="typcn typcn-messages"></i></a>
            </div><!-- az-header-message -->
            <div class="dropdown az-header-notification">
                <a href="" class="new"><i class="typcn typcn-bell"></i></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header mg-b-20 d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <h6 class="az-notification-title">Notifications</h6>
                    <p class="az-notification-text">You have 2 unread notification</p>
                    <div class="az-notification-list">
                        <div class="media new">
                            <div class="az-img-user"><img src="/admin_public/img/faces/face2.jpg" alt=""></div>
                            <div class="media-body">
                                <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                                <span>Mar 15 12:32pm</span>
                            </div><!-- media-body -->
                        </div><!-- media -->
                        <div class="media new">
                            <div class="az-img-user online"><img src="/admin_public/img/faces/face3.jpg" alt="">
                            </div>
                            <div class="media-body">
                                <p><strong>Joyce Chua</strong> just created a new blog post</p>
                                <span>Mar 13 04:16am</span>
                            </div><!-- media-body -->
                        </div><!-- media -->
                        <div class="media">
                            <div class="az-img-user"><img src="/admin_public/img/faces/face4.jpg" alt=""></div>
                            <div class="media-body">
                                <p><strong>Althea Cabardo</strong> just created a new blog post</p>
                                <span>Mar 13 02:56am</span>
                            </div><!-- media-body -->
                        </div><!-- media -->
                        <div class="media">
                            <div class="az-img-user"><img src="/admin_public/img/faces/face5.jpg" alt=""></div>
                            <div class="media-body">
                                <p><strong>Adrian Monino</strong> added new comment on your photo</p>
                                <span>Mar 12 10:40pm</span>
                            </div><!-- media-body -->
                        </div><!-- media -->
                    </div><!-- az-notification-list -->
                    <div class="dropdown-footer"><a href="">View All Notifications</a></div>
                </div><!-- dropdown-menu -->
            </div><!-- az-header-notification -->
            {{-- for gravatar images --}}
            @php
                $hashed_email = md5(strtolower(trim(Auth::user()->email)));
            @endphp
            {{-- gravatar end --}}
            <div class="dropdown az-profile-menu">
                <a href="" class="az-img-user"><img src="{{ Auth::user()->image == ''?"https://www.gravatar.com/avatar/".$hashed_email."?s=32&d=robohash" :image_crop(Auth::user()->image,32,32) }}" alt="user profile pic"></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <div class="az-header-profile">
                        <div class="az-img-user">
                            <img src="{{ Auth::user()->image == ''?"https://www.gravatar.com/avatar/".$hashed_email."?s=80&d=robohash" :image_crop(Auth::user()->image,80,80) }}" alt="">
                        </div><!-- az-img-user -->
                        <h6>{{Auth::user()->name}}</h6>
                        <span>{{Auth::user()->role}}</span>
                    </div><!-- az-header-profile -->

                    <a href="" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                    <a href="" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
                    <a href="" class="dropdown-item"><i class="typcn typcn-time"></i> Activity Logs</a>
                    <a href="" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account Settings</a>
                    <a href="{{route('eshop.home')}}" class="dropdown-item"><i class="typcn typcn-shopping-bag"></i> Store Home</a>
                    <!-- Authentication -->
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                        this.closest('form').submit();""><i class="typcn typcn-power-outline"></i> Sign Out</a>
                    </form>
                </div><!-- dropdown-menu -->
            </div>
        </div><!-- az-header-right -->
    </div><!-- container -->
</div><!-- az-header -->

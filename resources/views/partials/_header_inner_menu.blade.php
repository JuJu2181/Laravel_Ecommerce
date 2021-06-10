<!-- Header Inner -->
<div class="header-inner">
    <div class="container">
        <div class="cat-nav-head">
            <div class="row">
                @yield('category_menu')
                <div class="col-lg-9 col-12">
                    <div class="menu-area">
                        <!-- Main Menu -->
                        <nav class="navbar navbar-expand-lg">
                            <div class="navbar-collapse">
                                <div class="nav-inner">
                                    <ul class="nav main-menu menu navbar-nav" id="nav-container">
                                        <li id="home"><a href={{route('eshop.home')}}>Home</a></li>
                                        <li id="product"><a href={{ route('product.index') }}>Product</a></li>
                                        <li id="category"><a href="{{ route('category.index') }}">Categories</a></li>
                                        <li id="shop"><a href="#">Shop<i class="ti-angle-down"></i><span
                                                    class="new">New</span></a>
                                            <ul class="dropdown">
                                                <li><a href={{route('eshop.shop-grid')}}>Shop Grid</a></li>
                                                <li><a href={{route('cart.index')}}>Cart</a></li>
                                                <li><a href={{route('eshop.checkout')}}>Checkout</a></li>
                                            </ul>
                                        </li>
                                        {{-- <li id="pages"><a href="#">Pages</a></li> --}}
                                        <li id="blog"><a href="#">Blog<i class="ti-angle-down"></i></a>
                                            <ul class="dropdown">
                                                <li><a href={{route('eshop.blog-single')}}>Blog Single Sidebar</a>
                                                </li>
                                                <li><a href={{route('posts.index')}}>All Blogs</a>
                                                </li>
                                                @auth
                                                @unless (Auth::user()->role == 'user')
                                                    <li><a href={{route('admin.posts.create')}}>Create Post</a>
                                                </li>
                                                @endunless
                                                @endauth
                                            </ul>
                                        </li>
                                        <li id="contacts"><a href={{route('eshop.contact')}}>Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <!--/ End Main Menu -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ End Header Inner -->

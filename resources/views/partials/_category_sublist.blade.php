<div class="col-lg-3">
    <div class="all-category">
        <h3 class="cat-heading"><i class="fa fa-bars" aria-hidden="true"></i>CATEGORIES</h3>
        <ul class="main-category">
            {{-- <li><a href="#">New Arrivals <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                <ul class="sub-category">
                    <li><a href="#">accessories</a></li>
                    <li><a href="#">best selling</a></li>
                    <li><a href="#">top 100 offer</a></li>
                    <li><a href="#">sunglass</a></li>
                    <li><a href="#">watch</a></li>
                    <li><a href="#">man’s product</a></li>
                    <li><a href="#">ladies</a></li>
                    <li><a href="#">westrn dress</a></li>
                    <li><a href="#">denim </a></li>
                </ul>
            </li>
            <li class="main-mega"><a href="#">best selling <i class="fa fa-angle-right"
                        aria-hidden="true"></i></a>
                <ul class="mega-menu">
                    <li class="single-menu">
                        <a href="#" class="title-link">Shop Kid's</a>
                        <div class="image">
                            <img src="https://via.placeholder.com/225x155" alt="#">
                        </div>
                        <div class="inner-link">
                            <a href="#">Kids Toys</a>
                            <a href="#">Kids Travel Car</a>
                            <a href="#">Kids Color Shape</a>
                            <a href="#">Kids Tent</a>
                        </div>
                    </li>
                    <li class="single-menu">
                        <a href="#" class="title-link">Shop Men's</a>
                        <div class="image">
                            <img src="https://via.placeholder.com/225x155" alt="#">
                        </div>
                        <div class="inner-link">
                            <a href="#">Watch</a>
                            <a href="#">T-shirt</a>
                            <a href="#">Hoodies</a>
                            <a href="#">Formal Pant</a>
                        </div>
                    </li>
                    <li class="single-menu">
                        <a href="#" class="title-link">Shop Women's</a>
                        <div class="image">
                            <img src="https://via.placeholder.com/225x155" alt="#">
                        </div>
                        <div class="inner-link">
                            <a href="#">Ladies Shirt</a>
                            <a href="#">Ladies Frog</a>
                            <a href="#">Ladies Sun Glass</a>
                            <a href="#">Ladies Watch</a>
                        </div>
                    </li>
                </ul>
            </li>
            <li><a href="#">accessories</a></li>
            <li><a href="#">top 100 offer</a></li>
            <li><a href="#">sunglass</a></li>
            <li><a href="#">watch</a></li>
            <li><a href="#">man’s product</a></li>
            <li><a href="#">ladies</a></li>
            <li><a href="#">westrn dress</a></li>
            <li><a href="#">denim </a></li> --}}
            <li><a href="{{ route('category.index') }}">All Categories</a></li>
            @foreach ($categories as $category)
            <li><a href={{ route('category.single',$category->id) }}>{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
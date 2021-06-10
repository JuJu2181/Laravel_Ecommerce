<div class="col-lg-3 col-md-4 col-12">
    <div class="shop-sidebar">
        <!-- Single Widget -->
        <div class="single-widget category">
            <h3 class="title"><a href={{ route('category.index') }}>Categories</a></h3>
            <?php
            function generateCategoryList($category){
            ?>
                <li><a href={{ route('category.single',$category->id) }}>{{ $category->name }}</a>
            <?php 
                if($category->children->count() > 0){
            ?>
                <ul class="categor-list">
            <?php 
                    foreach($category->children as $subcategory){
                        generateCategoryList($subcategory);
                    }
            ?>
                </ul>
            <?php
            }
            ?>                
                </li>
            <?php
            }
            ?>
            <ul class="categor-list">
                @foreach (App\Models\Category::with('children')->where('parent_id',0)->get() as $category)
                    {{-- <li><a href={{ route('category.single',$category->id) }}>{{ $category->name }}</a></li> --}}
                    {{generateCategoryList($category)}}
                @endforeach
            </ul>
        </div>
        <!--/ End Single Widget -->
        <!-- Shop By Price -->
        {{-- <div class="single-widget range">
            <h3 class="title">Shop by Price</h3>
            <div class="price-filter">
                <div class="price-filter-inner">
                    <div id="slider-range"></div>
                    <div class="price_slider_amount">
                        <div class="label-input">
                            <span>Range:</span><input type="text" id="amount" name="price"
                                placeholder="Add Your Price" />
                        </div>
                    </div>
                </div>
            </div>
            <ul class="check-box-list">
                <li>
                    <label class="checkbox-inline" for="1"><input name="news" id="1" type="checkbox">$20 -
                        $50<span class="count">(3)</span></label>
                </li>
                <li>
                    <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox">$50 -
                        $100<span class="count">(5)</span></label>
                </li>
                <li>
                    <label class="checkbox-inline" for="3"><input name="news" id="3" type="checkbox">$100 -
                        $250<span class="count">(8)</span></label>
                </li>
            </ul>
        </div> --}}
        <!--/ End Shop By Price -->
        <!-- Single Widget -->
        <div class="single-widget recent-post">
            <h3 class="title">Recent posts</h3>
            @if (App\Models\Post::all()->count() > 0)
            @foreach (App\Models\Post::latest('id')->take(3)->get() as $post)
            <!-- Single Post -->
            <div class="single-post first">
                <div class="image">
                    <img src="{{$post->image==''?'https://via.placeholder.com/75x75':image_crop($post->image,75,75)}}" alt="#">
                </div>
                <div class="content">
                    <h5><a href="#">{{ $post->title }}</a></h5>
                    <p>{{ Str::substr($post->body, 0, 20) }} {{ strlen($post->body) > 20 ? "...": "" }}</p>
                    <ul class="reviews">
                        <li class="yellow"><i class="ti-star"></i></li>
                        <li class="yellow"><i class="ti-star"></i></li>
                        <li class="yellow"><i class="ti-star"></i></li>
                        <li><i class="ti-star"></i></li>
                        <li><i class="ti-star"></i></li>
                    </ul>
                </div>
            </div>
            <!-- End Single Post -->
                 
            @endforeach
            @else 
            <p class="text-secondary">No Posts Available</p>
            @endif
       </div>
        <!--/ End Single Widget -->
        <!-- Single Widget -->
        <div class="single-widget category">
            <h3 class="title">Manufacturers</h3>
            <ul class="categor-list">
                @foreach (App\Models\User::all() as $user)
                @if ($user->role == "vendor")
                    
                <li><a href="{{ route('eshop.getSingleShop',$user->id) }}">{{ $user->name }}</a></li>
                @endif
                @endforeach
            </ul>
        </div>
        <!--/ End Single Widget -->
    </div>
</div>
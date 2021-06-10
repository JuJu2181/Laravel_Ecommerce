<div class="shop-top">
    <div class="shop-shorter">
        @php
            $count_options = [4,6,8,10];
            $sort_methods = ["name","price"];
            $old_option = request('count') >= 4 ? request('count'):4;
            $old_method = request('sort-method') != ""?request('sort-method'):"";
            $old_order = request('sort-order') != "" ? request('sort-order'):"desc";
            $old_category = gettype(request('product_category')) == 'string' ? request('product_category'):0;
        @endphp
        <div class="single-shorter">
            <label>Show :</label>
            <select name="count">
                @foreach ($count_options as $option)
                    <option value="{{$option}}" {{$option == $old_option?"selected":""}}>{{$option}}</option>
                @endforeach
            </select>
        </div>
        <div class="single-shorter">
            <label>Sort By :</label>
            <select name="sort-method">
                <option value="created_at" selected>date</option>
                @foreach ($sort_methods as $method)
                    <option value="{{$method}}" {{$method == $old_method?"selected":""}}>{{$method}}</option>
                @endforeach
            </select>
        </div>
        <div class="single-shorter">
            <label>Sort order :</label>
            <select name="sort-order">
                <option value="desc" {{$old_order == "desc"?"selected":""}}>Falling</option>
                <option value="asc" {{$old_order == "asc"?"selected":""}}>Rising</option>
            </select>
        </div>
        <div class="single-shorter">
            <label>Category :</label>
            <select name="product_category">
                <option selected="selected" value="0">All</option>
                @foreach ($categories_for_filter as $category)
                    <option value="{{$category->id}}"{{$category->id == $old_category?"selected":""}}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="single-widget range">
        <h3 class="title">Shop by Price</h3>
        <div class="label-input">
            <span>Max Price:</span><input type="number" name="max-price" value="{{request('max-price') == null?App\Models\Product::orderBy('price','desc')->first()->price:request('max-price')}}"
            />
        </div>
    </div>
    <div>
        <a title="change post view" class="btn btn-outline-secondary" href="#" onclick="event.preventDefault();this.closest('form').submit();"><i class="ti-control-shuffle"></i></a>
    </div>
</div>
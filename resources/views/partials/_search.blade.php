<div class="search-bar-top">
    <div class="search-bar">
        @php
            // echo "<pre>"; print_r(categories_list()); echo "</pre>";
            //  call to the categories_list() helper function
            $categories = categories_list();
            @endphp
        <form method="GET" action="{{route('products.search')}}">
            <select name="category">
                <option selected="selected" value="0">All Category</option>
                @foreach (App\Models\Category::with('children')->get() as $category)
                @unless ($category->children->count() > 0) 
                <?php
                // for displaying category name in search bar
                $searched_category = gettype(request('category')) == 'string' ? request('category'):0;
                ?> 
                <option value="{{ $category->id }}"{{$category->id == $searched_category ? "selected":""}}>
                    {{ $category->name }}</option>  
                @endunless
            @endforeach
            </select>
            <input name="search" value="{{request('search')}}" placeholder="Search Products Here....." type="search">
            <button class="btnn"><i class="ti-search"></i></button>
        </form>
    </div>
</div>
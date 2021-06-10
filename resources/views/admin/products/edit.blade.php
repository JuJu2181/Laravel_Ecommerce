@section('title',Auth::user()->name.' - Edit Product')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>Edit Product: {{ $product->name }}</h2>
                {{-- determines whether one can update product or not --}}
                {{-- for gate we defined update-product --}}
                {{-- @can('update-product',$product) --}}
                {{-- for policy we defined a function called update --}}
                @can('update',$product)
                <form action={{ route('admin.products.update',$product->id) }} method='POST' enctype="multipart/form-data">
                    {{-- here we need to use POST instead of put in html as html forms only support post and get--}}
                    {{-- Then we need to add the put method as hiden field --}}
                    @method('PUT')
                    @csrf
                    {{-- for name --}}
                    <label for="name" class="m-1">Product Name: </label> 
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  value="{{$product->name}}">
                    @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for slug --}}
                <label for="slug" class="m-1">Product Slug: </label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{ $product->slug }}">
                @error('slug')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                    {{-- for description --}}
                    <label for="description" class="m-1">Product Description: </label>
                    
                    <textarea name="description" id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" >{{ $product->description}}</textarea>
                    @error('description')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for price --}}
                    <label for="price" class="m-1">Price: </label> 
                    <input type="text" name="price" id="" class="form-control @error('price') is-invalid @enderror" value="{{ $product->price }}">
                    @error('price')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                {{-- for category select --}}
                <label for="category_id" class="m-1">Category:</label>
                <x-forms.select name="category_id" class="form-control ">
                    {{-- implementing for all categories using recursion --}}
                    <?php
                    function generateCategoryList($category,$spaceCount,$product){  
                        // * for categories with children
                        if ($category->children->count() > 0)
                        {  
                        ?>
                        {{-- here we won't allow the products for categories with children --}}
                            <option disabled value="{{ $category->id }}">{!!str_repeat('&nbsp;',$spaceCount)!!}>
                        {{ $category->name }}</option>   
                        <?php
                        $spaceCount +=4;
                        foreach ($category->children as $subcategory){
                        generateCategoryList($subcategory,$spaceCount,$product);
                        }
                    }else{
                        $spaceCount +=4;
                    ?>
                    {{-- products can only have category without children --}}
                    {{-- {{dd($product->category_id)}} --}}
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id?"selected":"" }}>{!!str_repeat('&nbsp;',$spaceCount)!!}*
                        {{ $category->name }}</option>
                    <?php
                    }
                    
                }
                ?>

                    <option value="0"> Select A Category</option>
                    @foreach ($categories as $category)
                    {{ generateCategoryList($category,0,$product)}}
                    @endforeach

                </x-forms.select>
                @error('category_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for images --}}
                <input type="file" name="image_upload" id="" class="form-control mt-3"  >
                <p class="m-2 text-sm text-warning">If you want the previous image to be used don't choose a new file.</p>
                {{-- for submit btn --}}
                <input type="submit" value="Update Product" name="submit" class="btn btn-primary btn-block mt-4">
                </form>
                <a href={{ route('admin.products.index') }} class="btn btn-warning btn-block mt-2">Discard Changes</a>
                @else 
                <p class="text-danger">You are not authorized to edit this product</p>
                @endcan
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        document.getElementById("products").classList.add("active");
        // for auto generating title based on input 
        $(document).ready(($) => {
        $('#name').on('change', () => {
            let name = $('#name').val();
            console.log('name: ', name);
            // using regular expression to remove space with -
            let slug = name.replace(/\s+/g, '-').toLowerCase();
            console.log('slug', slug);
            $('#slug').val(slug);
        });
    });
    </script>
    @stop
    </x-admin.layout>
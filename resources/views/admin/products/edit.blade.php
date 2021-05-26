@section('title','Edit Product')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>Edit Product: {{ $product->name }}</h2>
                <form action={{ route('admin.products.update',$product->id) }} method='POST'>
                    {{-- here we need to use POST instead of put in html as html forms only support post and get--}}
                    {{-- Then we need to add the put method as hiden field --}}
                    @method('PUT')
                    @csrf
                    <label for="name">Product Name: </label> <br>
                    <input type="text" name="name" id="" class="form-control" value="{{ $product->name }}"><br>
                    <label for="description">Product Description: </label>
                    <br>
                    <textarea name="description" id="" cols="30" rows="10" class="form-control" >{{ $product->description }}</textarea>
                    <br>
                    <label for="price">Price: </label> <br>
                    <input type="text" name="price" id="" class="form-control" value="{{ $product->price }}"><br><br>
                    <label for="category_id">Category:</label><br>
                    <x-forms.select name="category_id" class="form-control">
                        <option value="0"> Select A Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id === $product->category_id ? "selected":"" }}>{{ $category->name }}</option>
                        @endforeach
                    </x-forms.select>
                    <br><br>
                    <input type="submit" value="Update Product" name="submit" class="btn btn-primary btn-block">
                </form>
            </div>
        </div>
    </div>
    </x-admin.layout>
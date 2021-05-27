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
                    <label for="name" class="m-1">Product Name: </label> 
                    <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror"  value="{{$product->name}}">
                    @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    <label for="description" class="m-1">Product Description: </label>
                    
                    <textarea name="description" id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" >{{ $product->description}}</textarea>
                    @error('description')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    <label for="price" class="m-1">Price: </label> 
                    <input type="text" name="price" id="" class="form-control @error('price') is-invalid @enderror" value="{{ $product->price }}">
                    @error('price')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    <label for="category_id" class="m-1">Category:</label><br>
                    <x-forms.select name="category_id" class="form-control">
                        <option value="0" disabled> Select A Category</option>
                        @foreach ($categories as $category)
                            
                            <option value="{{ $category->id }}" {{ $category->id === $product->category_id ? "selected":"" }}>{{ $category->name }}</option>
                        @endforeach
                    </x-forms.select>
                    @error('category_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    
                    <input type="submit" value="Update Product" name="submit" class="btn btn-primary btn-block mt-4">
                </form>
                <a href={{ route('admin.products.index') }} class="btn btn-warning btn-block mt-2">Discard Changes</a>
            </div>
        </div>
    </div>
    @section('scripts')
    <script>
        document.getElementById("products").classList.add("active");
    </script>
    @stop
    </x-admin.layout>
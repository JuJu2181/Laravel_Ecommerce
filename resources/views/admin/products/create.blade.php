@section('title','Create New Product')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            {{-- displaying all errors before form--}}
            {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif --}}
            <h2>Create Product</h2>
            <form action={{ route('admin.products.store') }} method="post" enctype="multipart/form-data">
                @csrf
                {{-- for name --}}
                <label for="name" class="m-1">Product Name: </label> 
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for slug --}}
                <label for="slug" class="m-1">Product Slug: </label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug') }}">
                @error('slug')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for description --}}
                <label for="description" class="m-1">Product Description: </label>
                <textarea name="description" id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" >{{ old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for price --}}
                <label for="price" class="m-1">Price: </label> 
                <input type="text" name="price" id="" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                @error('price')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for category select --}}
                <label for="category_id" class="m-1">Category:</label>
                <x-forms.select name="category_id" class="form-control ">
                    <option value="0"> Select A Category</option>
                    @foreach (App\Models\Category::with('children')->where('parent_id',0)->get() as $category)
                    @if ($category->children->count() > 0)
                    <option value="{{ $category->id }}" {{ $category->id == old('category_id')?"selected":"" }}>
                    {{ $category->name }}</option>
                    @foreach ($category->children as $subcategory)
                    @if ($subcategory->children->count()>0)
                    <option value="{{ $subcategory->id }}"
                        {{ $subcategory->id == old('category_id')?"selected":"" }}> {!!str_repeat('&nbsp;',4)!!}->
                        {{ $subcategory->name }}</option>
                    @foreach ($subcategory->children as $thirdlevelcategory)
                    <option value="{{ $thirdlevelcategory->id }}"
                        {{ $thirdlevelcategory->id == old('category_id')?"selected":"" }}> {!!str_repeat('&nbsp;',8)!!}->
                        {{ $thirdlevelcategory->name }}</option>
                    @endforeach
                    @else
                    <option value="{{ $subcategory->id }}"
                        {{ $subcategory->id == old('category_id')?"selected":"" }}> {!!str_repeat('&nbsp;',4)!!}->
                        {{ $subcategory->name }}</option>
                    @endif
                    @endforeach
                    @else
                    <option value="{{ $category->id }}" {{ $category->id == old('category_id')?"selected":"" }}>
                        {{ $category->name }}</option>
                    @endif
                    @endforeach

                </x-forms.select>
                @error('category_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for images --}}
                <input type="file" name="image_upload" id="" class="form-control mt-3" required>
                <input type="submit" value="Create Product" name="submit" class="btn btn-success btn-block mt-4">
            </form>
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
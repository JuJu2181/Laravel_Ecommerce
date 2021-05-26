@section('title','Create New Product')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <h2>Create Product</h2>
            <form action={{ route('admin.products.store') }} method="post">
                @csrf
                <label for="name">Product Name: </label> <br>
                <input type="text" name="name" id="" class="form-control"><br>
                <label for="description">Product Description: </label>
                <br>
                <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                <br>
                <label for="price">Price: </label> <br>
                <input type="text" name="price" id="" class="form-control"><br><br>
                <label for="category_id">Category:</label><br>
                <x-forms.select name="category_id" class="form-control">
                    <option value="0"> Select A Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-forms.select>
                <br><br>
                <input type="submit" value="Create Product" name="submit" class="btn btn-success btn-block">
            </form>
        </div>
    </div>
</div>
</x-admin.layout>
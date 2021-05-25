<form action={{ route('admin.products.store') }} method="post">
    @csrf
    <label for="product_name">Product Name: </label> <br>
    <input type="text" name="name" id=""><br>
    <label for="product_desc">Product Description: </label>
    <br>
    <textarea name="description" id="" cols="30" rows="10"></textarea>
    <br>
    <label for="price">Price: </label> <br>
    <input type="text" name="price" id=""><br>
    <label for="category_id">Category:</label><br>
    <select name="category_id" id="">
        <option value="0"> Select A Category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select><br><br>
    <input type="submit" value="Create Product" name="submit">
</form>
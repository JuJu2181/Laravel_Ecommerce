<a href={{ route('admin.products.create') }}>Create Product</a>

<table width="900" align="center">
    <tr>
        <td>S.N.</td>
        <td>Name</td>
        <td>Description</td>
        <td>Price</td>
        <td>Actions</td>
    </tr>
    @foreach ($products as $product)
    <tr>
        
        <td>{{ $product->id }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ Str::substr($product->description, 0, 50) }}...</td>
        <td>{{ $product->price }}</td>
        <td>
            <a href="">Edit</a> |
            <a href="">Delete</a>
        </td>
        </tr>
        @endforeach
</table>
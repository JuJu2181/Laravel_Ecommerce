@section('title','All Products')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <h2>All Products</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
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
                            <a href={{ route('admin.products.edit',$product->id) }} class="btn btn-info">  
                                <span><i class="typcn typcn-edit"></i></span>
                                Edit</a> 
                            <a href="" class="btn btn-danger">
                                <span><i class="typcn typcn-trash"></i></span>
                                Delete</a>
                        </td>
                        </tr>
                        @endforeach
                </table>
            </div>
        </div>
    </div>
</div>    
</x-admin.layout>
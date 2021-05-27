{{-- Delete Page --}}
@section('title','Delete Product')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <h2>Delete Product: {{ $product->name }}</h2>
            <form action={{ route('admin.products.delete',$product->id) }} method="post">
                @method('DELETE')
                @csrf
                <p class="mt-2">
                    <strong>Product Name: </strong>{{$product->name}}<br>
                    <strong>Product Description: </strong>{{$product->description}}<br>
                    <strong>Price: </strong>{{$product->price}}
                    <br>
                    <strong>Category: </strong>{{$product->category->name}}
                </p>
                <h3 class="mt-2">Are you sure to delete {{ $product->name }} ?</h3>
                <input type="submit" class="mt-4 btn btn-block btn-danger" value="Delete {{ $product->name }}">
            </form>
            <a href={{ route('admin.products.index') }} class="btn btn-block btn-warning mt-2">Cancel</a>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        document.getElementById("products").classList.add("active");
    </script>
@stop
</x-admin.layout>
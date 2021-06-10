@section('title',Auth::user()->name.' - All Products')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        @unless(Auth::user()->role == 'user')
        <div class="az-content-body">
            <h2>All Products</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Category</td>
                        <td>Actions</td>
                    </tr>
                    @foreach ($products as $product)
                    {{-- for displaying products specific to user --}}
                    @can('update',$product)
                    <tr id="productId{{ $product->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>  {{ Str::substr($product->description, 0, 50) }} {{ strlen($product->description) > 50 ? "...": "" }}</td>
                        <td>{{ $product->price }}</td>
                        <td><a href="{{route('category.single',$product->category->id)}}">{{ $product->category->name }}</a></td>
                        <td>
                            <a href={{ route('admin.products.edit',$product->id) }} class="btn btn-info btn-block">  
                                Edit
                                <span><i class="typcn typcn-edit"></i></span>
                                </a>
                            {{--deleting by redirecting to delete page  --}}
                            {{-- <a href={{ route('admin.products.deletePage',$product->id) }} class="btn btn-danger btn-block mt-2">
                                Delete
                                <span><i class="typcn typcn-trash"></i></span>
                                </a> --}}
                                
                                {{-- to directly delete the product instead of redirecting to the delete page --}}
                                {{-- <form action={{ route('admin.products.delete',$product->id) }} method="post" class="mt-2" id="deleteForm">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-block" id="deleteButton">
                                    Delete
                                    <span><i class="typcn typcn-trash"></i></span>
                                </button>
                                </form> --}}
                                {{-- to delete using ajax request --}}
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <button id="deleteProduct" data-id="{{ $product->id }}" class="btn btn-danger btn-block mt-2" onclick="deleteProduct({{ $product->id }})">Delete
                                <span><i class="typcn typcn-trash"></i></span
                                </button>
                            </td>
                    </tr>
                    @endcan
                        @endforeach
                </table>
            </div>
            <div class="mt-5 d-flex justify-center mx-auto">
                {{ $products->links() }}
            </div>
        </div>
        @else
        <h3 class="text-danger">You are unauthorized</h3>
        @endunless
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("products").classList.add("active");
        // for deleting by form
        // const deleteButton = document.getElementById("deleteButton");
        // deleteButton.addEventListener("click",(e)=>{
        //     e.preventDefault();
        //     if(confirm("Are you sure to delete this product?\n press 'OK' to confirm")){
        //         console.log("deleted");
        //         document.getElementById("deleteForm").submit();
        //     }else{
        //         console.log("cancelled");
        //     }
        // });

        // for ajax delete
        function deleteProduct(id){
            console.log(id);
            let token = $("meta[name='csrf-token']").attr("content");
            if(confirm("Are you sure to delete this product?\n press 'OK' to confirm")){
                $.ajax({
                url:"/admin/products/"+id,
                type: 'DELETE',
                data:{
                    "id":id,
                    "_token":token,
                },
                success:function(){
                    console.log("deleted");
                    $('#productId'+id).remove();
                }
                });
            }else{
                console.log("cancelled");
            }
            
        }
    </script>
@stop
</x-admin.layout>
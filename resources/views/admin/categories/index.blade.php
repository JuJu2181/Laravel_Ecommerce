@section('title',Auth::user()->name.' - All Categories')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        @can('authorize-category')
        <div class="az-content-body">
            <h2>All Categories</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Slug</td>
                        <td>No Of Products</td>
                        <td>Parent Category</td>
                        <td>Actions</td>
                    </tr>
                    @foreach ($categories as $category)
                    <tr id="categoryId{{ $category->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>  {{ Str::substr($category->description, 0, 50) }} {{ strlen($category->description) > 50 ? "...": "" }}</td>
                        <td>{{$category->slug}}</td>
                        <td>{{ count($category->products) }}</td>
                        <td>
                            @if (isset($category->parent_id) && !empty($category->parent_id))
                            <a href="{{ route('category.single',$category->parent_id) }}">
                                {{App\Models\Category::find($category->parent_id)->name}}
                            </a>
                            @else 
                            None
                            @endif
                        </td>
                        <td>
                            <a href={{ route('admin.categories.edit',$category->id) }} class="btn btn-info btn-block">  
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
                                <button id="deleteCategory" data-id="{{ $category->id }}" class="btn btn-danger btn-block mt-2" onclick="deleteCategory({{ $category->id }})">Delete
                                <span><i class="typcn typcn-trash"></i></span
                                </button>
                        </td>
                        </tr>
                        @endforeach
                </table>
                <div class="mt-5 mx-auto">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
        @else  
        <h3 class="text-danger">You are unauthorized</h3>
        @endcan
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("categories").classList.add("active");
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
        // delete is working here but it is not removing row from table
        function deleteCategory(id){
            console.log(id);
            let token = $("meta[name='csrf-token']").attr("content");
            if(confirm("Are you sure to delete this category?\n press 'OK' to confirm")){
                $.ajax({
                url:"/admin/categories/"+id,
                type: 'DELETE',
                data:{
                    "id":id,
                    "_token":token,
                },
                success:function(){
                    console.log("deleted");
                    $('#categoryId'+id).remove();
                }
                });
            }else{
                console.log("cancelled");
            }
            
        }
    </script>
@stop
</x-admin.layout>
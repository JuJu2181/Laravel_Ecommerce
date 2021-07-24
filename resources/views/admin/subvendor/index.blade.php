@section('title',Auth::user()->name.' - All Sub Vendors')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        @unless(Auth::user()->role == 'user' || Auth::user()->vendor_status == 'not_verified')
        <div class="az-content-body">
            <h2>All Sub Vendors</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Name</td>
                        <td>Email</td>
                        @if(Auth::user()->role == 'admin')
                        <td>Vendor</td>
                        @endif
                        <td>Responsibilities</td>
                        @if(Auth::user()->role == 'vendor')
                        <td>Actions</td>
                        @endif
                    </tr>
                    @foreach ($subvendors as $subvendor)
                    {{-- for displaying products specific to user --}}
                    <tr id="subVendorId{{ $subvendor->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subvendor->name }}</td>
                        <td> {{ $subvendor->email }}</td>
                        @if(Auth::user()->role=='admin')
                        <td>{{ $subvendor->vendor->name }}</td>
                        @endif
                        <td>
                        {{implode(", ",json_decode($subvendor->responsibility))}}
                        </td>
                        @if(Auth::user()->role == 'vendor')
                        <td>
                            <a href={{ route('admin.subvendors.edit',$subvendor->id) }} class="btn btn-info btn-block">  
                                Edit
                                <span><i class="typcn typcn-edit"></i></span>
                                </a>
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <button id="deleteSubVendor" data-id="{{ $subvendor->id }}" class="btn btn-danger btn-block mt-2" onclick="deleteSubVendor({{ $subvendor->id }})">Delete
                                <span><i class="typcn typcn-trash"></i></span
                                </button>
                            </td>
                        @endif
                    </tr>
                        @endforeach
                </table>
            </div>
            <div class="mt-5 d-flex justify-center">
                {{ $subvendors->links() }}
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
        document.getElementById("subvendors").classList.add("active");

        // for ajax delete
        function deleteSubVendor(id){
            console.log(id);
            let token = $("meta[name='csrf-token']").attr("content");
            if(confirm("Are you sure to delete this sub vendor?\n press 'OK' to confirm")){
                $.ajax({
                url:"/admin/subvendors/"+id,
                type: 'DELETE',
                data:{
                    "id":id,
                    "_token":token,
                },
                success:function(){
                    console.log("deleted");
                    $('#subVendorId'+id).remove();
                }
                });
            }else{
                console.log("cancelled");
            }
            
        }
    </script>
@stop
</x-admin.layout>
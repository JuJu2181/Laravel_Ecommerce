@section('title',Auth::user()->name.' - All Users')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        @if(Auth::user()->role == 'admin')
        <div class="az-content-body">
            <h2>All Users</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Role</td>
                        <td>Actions</td>
                    </tr>
                    @foreach ($users as $user)
                    {{-- for displaying products specific to user --}}
                    <tr id="userId{{ $user->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td> {{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href={{ route('admin.users.edit',$user->id) }} class="btn btn-info btn-block">  
                                Edit
                                <span><i class="typcn typcn-edit"></i></span>
                                </a>
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <button id="deleteUser" data-id="{{ $user->id }}" class="btn btn-danger btn-block mt-2" onclick="deleteUser({{ $user->id }})">Delete
                                <span><i class="typcn typcn-trash"></i></span
                                </button>
                            </td>
                    </tr>
                        @endforeach
                </table>
            </div>
            <div class="mt-5 d-flex justify-center">
                {{ $users->links() }}
            </div>
        </div>
        @else
        <h3 class="text-danger">You are unauthorized</h3>
        @endif
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("users").classList.add("active");

        // for ajax delete
        function deleteUser(id){
            console.log(id);
            let token = $("meta[name='csrf-token']").attr("content");
            if(confirm("Are you sure to delete this user?\n press 'OK' to confirm")){
                $.ajax({
                url:"/admin/users/"+id,
                type: 'DELETE',
                data:{
                    "id":id,
                    "_token":token,
                },
                success:function(){
                    console.log("deleted");
                    $('#userId'+id).remove();
                }
                });
            }else{
                console.log("cancelled");
            }
            
        }
    </script>
@stop
</x-admin.layout>
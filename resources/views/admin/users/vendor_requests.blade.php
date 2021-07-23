@section('title',Auth::user()->name.' - All Pending Vendors')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        @if(Auth::user()->role == 'admin')
        <div class="az-content-body">
            <h2>All Pending Vendors</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Role</td>
                        <td>Actions</td>
                    </tr>
                    @foreach ($pending_vendors as $user)
                    {{-- for displaying products specific to user --}}
                    <tr id="userId{{ $user->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td> {{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <form action="{{route('admin.users.verify_vendor',$user->id)}}" method="post">
                                @csrf
                                <a href='#' onclick="event.preventDefault();this.closest('form').submit();" class="btn btn-info btn-block">  
                                    Verify
                                </a>
                            </form>
                        </td>
                    </tr>
                        @endforeach
                </table>
            </div>
            <div class="mt-5 d-flex justify-center">
                {{ $pending_vendors->links() }}
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
    </script>
@stop
</x-admin.layout>
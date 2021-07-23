@section('title',Auth::user()->name.' - All Verified Vendors')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        @if(Auth::user()->role == 'admin')
        <div class="az-content-body">
            <h2>All Verified Vendors</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Role</td>
                    </tr>
                    @foreach ($verified_vendors as $user)
                    {{-- for displaying products specific to user --}}
                    <tr id="userId{{ $user->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td> {{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                    </tr>
                        @endforeach
                </table>
            </div>
            <div class="mt-5 d-flex justify-center">
                {{ $verified_vendors->links() }}
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
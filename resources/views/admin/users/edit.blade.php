@section('title',Auth::user()->name.' - Edit Product')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>Edit User Role: {{ $user->name }}</h2>
                {{-- determines whether one can update product or not --}}
                {{-- for gate we defined update-product --}}
                {{-- @can('update-product',$product) --}}
                {{-- for policy we defined a function called update --}}
                @if(Auth::user()->role == 'admin')
                <form action={{ route('admin.users.update',$user->id) }} method='POST' >
                    {{-- here we need to use POST instead of put in html as html forms only support post and get--}}
                    {{-- Then we need to add the put method as hiden field --}}
                    @method('PUT')
                    @csrf
                    {{-- for name --}}
                    <label for="name" class="m-1">User Name: </label> 
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  value="{{$user->name}}" disabled>
                    @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for slug --}}
                <label for="slug" class="m-1">Email: </label>
                <input type="text" name="slug" id="slug" class="form-control @error('email') is-invalid @enderror"
                    value="{{ $user->email }}" disabled>
                @error('slug')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for category select --}}
                <label for="role" class="m-1">Role:</label>
                <x-forms.select name="role" class="form-control ">
                    <option value="vendor" {{ $user->role == "vendor"?"selected":"" }}>Vendor</option>
                    <option value="user" {{ $user->role == "user"?"selected":"" }}>User</option>
                </x-forms.select>
                @error('role')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for submit btn --}}
                <input type="submit" value="Update User Role" name="submit" class="btn btn-primary btn-block mt-4">
                </form>
                <a href={{ route('admin.users.index') }} class="btn btn-warning btn-block mt-2">Discard Changes</a>
                @else 
                <p class="text-danger">You are not authorized to edit this user</p>
                @endif
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        document.getElementById("users").classList.add("active");
    </script>
    @stop
    </x-admin.layout>